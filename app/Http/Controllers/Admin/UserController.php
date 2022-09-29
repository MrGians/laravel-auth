<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Models\UserDetail;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('id', 'ASC')->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'phone' => 'nullable|string|max:20',
        ], [
            'first_name.required' => 'Il Nome è obbligatorio',
            'first_name.string' => 'Il Nome deve essere una stringa',
            'last_name.required' => 'Il Cognome è obbligatorio',
            'last_name.string' => 'Il Cognome deve essere una stringa',
            'phone.string' => 'Il Numero di Telefono deve essere una stringa',
            'phone.max' => 'Il Numero di Telefono non può essere più lungo di :max caratteri',
        ]);

        $data = $request->all();
        $user_details = new UserDetail();
        $user_details->user_id = Auth::id();
        $user_details->fill($data);
        $user_details->save();

        return redirect()->route('admin.users.index')
        ->with('message', 'Le Informazioni sono state aggiornate correttamente')->with('type', 'success');
    }
}

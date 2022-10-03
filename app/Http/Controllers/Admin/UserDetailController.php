<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserDetail;
use Illuminate\Support\Facades\Auth;

class UserDetailController extends Controller
{

    public function edit()
    {
        $user_details = Auth::user()->detail;
        return view('admin.userdetails.edit', compact('user_details'));
    }

    
    public function update(Request $request)
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
        $user_details = Auth::user()->detail;
        $user_details->update($data);

        return redirect()->route('admin.home')
        ->with('message', 'Le Informazioni sono state aggiornate correttamente')->with('type', 'success');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('id', 'ASC')->paginate(10);

        return view('admin.users.index', compact('users'));
    }

}

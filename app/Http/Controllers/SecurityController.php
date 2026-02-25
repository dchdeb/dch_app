<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SecurityController extends Controller
{
       public function index()
    {
        return view('settings.security_settings.index');
    }

    public function createUser()
    {
        return view('settings.security.create_user');
    }

    public function createGroup()
    {
        return view('settings.security.create_group');
    }

    public function roles()
    {
        return view('settings.security.roles');
    }

    public function permissions()
    {
        return view('settings.security.permissions');
    }
}

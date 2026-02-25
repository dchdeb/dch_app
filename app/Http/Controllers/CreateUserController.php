<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CreateUserController extends Controller
{
       public function index()
    {
        return view('settings.security_settings.create_user.index');
    }
}

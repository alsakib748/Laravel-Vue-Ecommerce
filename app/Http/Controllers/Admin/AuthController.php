<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{

    public function createAdmin()
    {

        $user = new User();
        $user->name = 'Admin';
        $user->email = 'admin@gmail.com';
        $user->password = bcrypt('1111');
        $user->save();

        $admin = Role::where('slug', 'admin')->first();

        $user->roles()->attach($admin);

    }

}

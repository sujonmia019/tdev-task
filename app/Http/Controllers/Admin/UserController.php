<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Role;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){
        $data['users'] = User::isRole(Role::USER_ROLE)->latest()->paginate(10);
        return view('user.index', $data);
    }
}

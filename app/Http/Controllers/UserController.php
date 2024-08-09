<?php

namespace App\Http\Controllers;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;

class userController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return [
            // examples with aliases, pipe-separated names, guards, etc:
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('view user,web'), only:['index']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('create user'), only:['create','store']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('update user'), only:['update','edit']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('delete user'), only:['destroy']),
            
            /*'role_or_permission:manager|edit articles',
            new Middleware('role:author', only: ['index']),
            new Middleware(\Spatie\Permission\Middleware\RoleMiddleware::using('manager'), except:['show']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('delete records,api'), only:['destroy']),*/
        ];
    }

    public function index(){
        $users = User::get();
        return view('role-permission.user.index', ['users' => $users]);
    }

    public function create(){
        $roles = Role::pluck('name', 'name')->all();
        return view('role-permission.user.create', ['roles' => $roles]);
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|max:20',
            'roles' => 'required'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
    ]);
        $user->syncRoles($request->roles);
        
        return redirect('/users')->with('status', 'User created Successfully with roles.');
    }

    public function edit(User $user){
        $user;
        $roles = Role::pluck('name', 'name')->all();
        $userRoles = $user->roles->pluck('name', 'name')->all();

        return view('role-permission.user.edit', ['user' => $user, 'roles' => $roles, 'userRoles' => $userRoles]);
    }

    public function update(Request $request, User $user){

        $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'nullable|string|min:8|max:20',
            'roles' => 'required'
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if(!empty($request->password)){
            $data += [
                'password' => Hash::make($request->password)
            ];
        }

        $user->update($data);
        $user->syncRoles($request->roles);

        return redirect('users')->with('status', 'user Updated Successfully with the roles');
    }

    public function destroy($user_id){
        $user = User::find($user_id);
        $user->delete();

        return redirect('users')->with('status', "user Deleted Successfully");
        
    }

}

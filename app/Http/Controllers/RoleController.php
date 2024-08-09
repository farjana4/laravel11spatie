<?php

namespace App\Http\Controllers;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return [
            // examples with aliases, pipe-separated names, guards, etc:
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('view role,web'), only:['index']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('create role'), only:['create','store']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('update role'), only:['update','edit']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('delete role'), only:['destroy']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('add-edit role permission'), only:['addPermissionToRole','givePermissionToRole']),
            
            /*'role_or_permission:manager|edit articles',
            new Middleware('role:author', only: ['index']),
            new Middleware(\Spatie\Permission\Middleware\RoleMiddleware::using('manager'), except:['show']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('delete records,api'), only:['destroy']),*/
        ];
    }

    public function index(){
        $roles = Role::get();
        return view('role-permission.role.index', ['roles' => $roles]);
    }

    public function create(){
        
        return view('role-permission.role.create');
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required|string|unique:roles,name'
        ]);

        $role = Role::create(['name' => $request->name]);
        
        return redirect('roles')->with('status', 'Permission created Successfully.');

    }

    public function edit(Role $role){

        return view('role-permission.role.edit', ['role' => $role]);
    }

    public function update(Request $request, Role $role){

        $request->validate([
            'name' => 'required|string|unique:roles,name,'.$role->id
        ]);
        $role->update([
            'name' => $request->name
        ]);

        return redirect('roles')->with('status', 'role Updated Successfully');
        
    }

    public function destroy($role_id){
        $role = Role::find($role_id);
        $role->delete();

        return redirect('roles')->with('status', "role Deleted Successfully");
        
    }

    //get permission data role wise
    public function addPermissionToRole($roleId){
        $permissions = Permission::get();
        $role = Role::findOrFail($roleId);
        $rolePermissions = DB::table('role_has_permissions')
                            ->where('role_id', $role->id)
                            ->pluck('permission_id', 'permission_id')
                            ->all();
                            
        return view('role-permission.role.add-permissions', ['role' => $role, 'permissions' => $permissions, 'rolePermissions' => $rolePermissions]);
    }

    //insert data into role_has_permissions table
    public function givePermissionToRole(Request $request, $roleId){
        $request->validate([
            'permission' => 'required'
        ]);

        $role = Role::findOrFail($roleId);
        $role->syncPermissions($request->permission);

        return redirect()->back()->with('status','Permission added to the role');
    }
}

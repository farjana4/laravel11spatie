<?php

namespace App\Http\Controllers;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class PermissionController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return [
            // examples with aliases, pipe-separated names, guards, etc:
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('view permission,web'), only:['index']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('create permission'), only:['create','store']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('update permission'), only:['update','edit']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('delete permission'), only:['destroy']),
            
            /*'role_or_permission:manager|edit articles',
            new Middleware('role:author', only: ['index']),
            new Middleware(\Spatie\Permission\Middleware\RoleMiddleware::using('manager'), except:['show']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('delete records,api'), only:['destroy']),*/
        ];
    }

    public function index(){
        $permissions = Permission::get();
        return view('role-permission.permission.index', ['permissions' => $permissions]);
    }

    public function create(){
        
        return view('role-permission.permission.create');
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required|string|unique:permissions,name'
        ]);

        $permission = Permission::create(['name' => $request->name]);
        
        return redirect('permissions')->with('status', 'Permission created Successfully.');

    }

    public function edit(Permission $permission){

        return view('role-permission.permission.edit', ['permission' => $permission]);
    }

    public function update(Request $request, Permission $permission){

        $request->validate([
            'name' => 'required|string|unique:permissions,name,'.$permission->id
        ]);
        $permission->update([
            'name' => $request->name
        ]);

        return redirect('permissions')->with('status', 'Permission Updated Successfully');
        
    }

    public function destroy($permission_id){
        $permission = Permission::find($permission_id);
        $permission->delete();

        return redirect('permissions')->with('status', "permission Deleted Successfully");
        
    }
}

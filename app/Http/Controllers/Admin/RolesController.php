<?php

namespace App\Http\Controllers\Admin;

use DB;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function list() {
        if (!auth()->check()) {
            return redirect('/')->with('error', 'You need to log in to access this page.');
        }

        if (!auth()->user()->can('list roles')) {
            return redirect()->route('admin.dashboard')->with('error', 'You do not have permission to view this page.');
        }

        // Check the role of the logged-in user
        if (auth()->user()->hasRole('super admin')) {
            // If the user is a superadmin, show all roles
            $list = Role::orderBy('id', 'DESC')->get();
        } elseif (auth()->user()->hasRole('Admin')) {
            // If the user is an admin, show only the role with id 5
            $list = Role::where('id', 5)->get();
        } else {
            // If the user is neither superadmin nor admin, handle accordingly (optional)
            $list = collect();  // Empty collection or handle accordingly
        }

        return view('admin.roles.index')->with('list', $list);
    }

           public function addshow() {
        if (!auth()->check()) {
            return redirect('/')->with('error', 'You need to log in to access this page.');
        }

        if (!auth()->user()->can('add roles')) {
            return redirect()->route('admin.dashboard')->with('error', 'You do not have permission to view this page.');
        }
        return view('admin.roles.add');
       }
       public function store(Request $request) {

        if (!auth()->check()) {
            return redirect('/')->with('error', 'You need to log in to access this page.');
        }

        if (!auth()->user()->can('add roles')) {
            return redirect()->route('admin.dashboard')->with('error', 'You do not have permission to view this page.');
        }
           $request->validate([
               'name' => 'required|unique:roles,name',
                   ]);

           $permission = new Role();
           $permission->name = $request->name;
           $permission->save();

           return response()->json(['message' => 'Role added successfully']);
       }
       public function edit($encryptedId){
        if (!auth()->check()) {
            return redirect('/')->with('error', 'You need to log in to access this page.');
        }

        if (!auth()->user()->can('edit roles')) {
            return redirect()->route('admin.dashboard')->with('error', 'You do not have permission to view this page.');
        }
        $id = Crypt::decryptString($encryptedId);

     $edit=Role::find($id);
     return view('admin.roles.edit')->with('edit',$edit);
    }
    public function update(Request $request,$id)  {

        if (!auth()->check()) {
            return redirect('/')->with('error', 'You need to log in to access this page.');
        }

        if (!auth()->user()->can('edit roles')) {
            return redirect()->route('admin.dashboard')->with('error', 'You do not have permission to view this page.');
        }
     $request->validate([

        'name' => 'required|unique:roles,name,'.$id,
    ]);

     $store= Role::find($id);
     $store->name = $request->name;
     $store->save();
     return response()->json(['message' => 'Role Updated  successfully']);
    }
    public function delete($id)
    {
        if (!auth()->check()) {
            return redirect('/')->with('error', 'You need to log in to access this page.');
        }

        if (!auth()->user()->can('delete roles')) {
            return redirect()->route('admin.dashboard')->with('error', 'You do not have permission to view this page.');
        }
       $delete=Role::find($id);
       $delete->delete();
       return redirect()->back()->with('success', 'Role deleted successfully.');
    }
    public function addPermissiontorole($encryptedId) {
        if (!auth()->check()) {
            return redirect('/')->with('error', 'You need to log in to access this page.');
        }

        if (!auth()->user()->can('addPermissiontorole roles')) {
            return redirect()->route('admin.dashboard')->with('error', 'You do not have permission to view this page.');
        }
        $id = Crypt::decryptString($encryptedId);

        $permission = Permission::get();
        $role = Role::findOrFail($id);
        $getpermissions = DB::table('role_has_permissions')->where('role_has_permissions.role_id', $role->id)->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')->all();

        return view('admin.roles.addpermission')->with('role', $role)->with('permissions', $permission)->with('getpermissions', $getpermissions);
    }

    public function updatePermissiontorole(Request $request, $roleid) {
        if (!auth()->check()) {
            return redirect('/')->with('error', 'You need to log in to access this page.');
        }

        if (!auth()->user()->can('addPermissiontorole roles')) {
            return redirect()->route('admin.dashboard')->with('error', 'You do not have permission to view this page.');
        }
        try {
            $role = Role::findOrFail($roleid);

            // If no permissions are selected, pass an empty array to syncPermissions
            $permissions = $request->has('permission') ? $request->permission : [];
            $role->syncPermissions($permissions);

            return response()->json(['message' => 'Permissions assigned to role updated successfully']);
        } catch (\Exception $e) {
            Log::error('Error updating permissions: ' . $e->getMessage());
            return response()->json(['error' => 'An unexpected error occurred'], 500);
        }
    }


}

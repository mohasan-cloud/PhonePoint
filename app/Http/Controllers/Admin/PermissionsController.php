<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Spatie\Permission\Models\Permission;

class PermissionsController extends Controller
{

    public function addshow() {
        if (!auth()->check()) {
            return redirect('/')->with('error', 'You need to log in to access this page.');
        }

        if (!auth()->user()->can('add permission')) {
            return redirect()->route('admin.dashboard')->with('error', 'You do not have permission to view this page.');
        }

     return view('admin.permissions.add');
    }
    public function store(Request $request) {

        if (!auth()->check()) {
            return redirect('/')->with('error', 'You need to log in to access this page.');
        }

        if (!auth()->user()->can('add permission')) {
            return redirect()->route('admin.dashboard')->with('error', 'You do not have permission to view this page.');
        }
        $request->validate([
            'name' => 'required|unique:permissions,name',
                ]);

        $permission = new Permission();
        $permission->name = $request->name;
        $permission->save();

        return response()->json(['message' => 'Permission added successfully']);
    }
    public function list() {
        if (!auth()->check()) {
            return redirect('/')->with('error', 'You need to log in to access this page.');
        }

        if (!auth()->user()->can('list permission')) {
            return redirect()->route('admin.dashboard')->with('error', 'You do not have permission to view this page.');
        }

        // Check the role of the logged-in user
        if (auth()->user()->hasRole('super admin')) {
            // If the user is a super admin, show all permissions
            $list = Permission::all();
        } elseif (auth()->user()->hasRole('Admin')) {
            // If the user is an admin, get the permissions associated with the admin's roles
            $list = auth()->user()->getPermissionsViaRoles(); // Get permissions associated with the user's roles
        } else {
            // If the user has no roles, return an empty collection (optional)
            $list = collect();
        }

        return view('admin.permissions.list')->with('list', $list);
    }

    public function edit($encryptedId){
        if (!auth()->check()) {
            return redirect('/')->with('error', 'You need to log in to access this page.');
        }

        if (!auth()->user()->can('edit permission')) {
            return redirect()->route('admin.dashboard')->with('error', 'You do not have permission to view this page.');
        }

        $id = Crypt::decryptString($encryptedId);
     $edit=Permission::find($id);
     return view('admin.permissions.edit')->with('edit',$edit);
    }
    public function update(Request $request,$id)  {

        if (!auth()->check()) {
            return redirect('/')->with('error', 'You need to log in to access this page.');
        }

        if (!auth()->user()->can('edit permission')) {
            return redirect()->route('admin.dashboard')->with('error', 'You do not have permission to view this page.');
        }
     $request->validate([

        'name' => 'required|unique:permissions,name,'.$id,
    ]);

     $store= Permission::find($id);
     $store->name = $request->name;
     $store->save();
     return response()->json(['message' => 'Permission Updated  successfully']);
    }
    public function delete($id)
{

    if (!auth()->check()) {
            return redirect('/')->with('error', 'You need to log in to access this page.');
        }

        if (!auth()->user()->can('delete permission')) {
            return redirect()->route('admin.dashboard')->with('error', 'You do not have permission to view this page.');
        }
       $delete=Permission::find($id);
       $delete->delete();
       return redirect()->back()->with('success', 'Permission deleted successfully.');
    }


    public function updatePermission(Request $request)
    {
        $id = $request->input('pk');
        $name = $request->input('name');
        $value = $request->input('value');

        $permission = Permission::find($id);
        if ($permission) {
            $permission->$name = $value;
            $permission->save();

            return response()->json(['success' => true, 'msg' => 'Updated successfully']);
        }

        return response()->json(['success' => false, 'msg' => 'Permission not found']);
    }

    // Other methods...

 }

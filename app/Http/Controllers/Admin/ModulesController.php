<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExtraFields;
use App\Models\FieldsShow;
use App\Models\Modules;
use App\Models\ModulesData;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Str;

class ModulesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = array();
        $data['modules'] = Modules::get();
        $data['roles']=Role::get();

        return view('admin.modules.index')->with($data);
    }
    public function getPermissionsByModule(Request $request)
    {
        $moduleName = $request->input('module_name');

        // Validate module_name
        if (!$moduleName) {
            return response()->json([
                'success' => false,
                'message' => 'Module name is required.'
            ], 400);
        }

        // Fetch permissions and roles
        $permissions = Permission::where('module_name', $moduleName)->get();
        $roles = Role::all();

        if ($permissions->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No permissions found for this module.'
            ]);
        }

        // Prepare permissions with roles
        $permissionsWithRoles = $permissions->map(function ($permission) use ($roles) {
            $permissionRoles = $permission->roles->pluck('id');
            return [
                'id' => $permission->id,
                'name' => $permission->name,
                'roles' => $roles->map(function ($role) use ($permissionRoles) {
                    return [
                        'id' => $role->id,
                        'name' => $role->name,
                        'is_assigned' => $permissionRoles->contains($role->id),
                    ];
                }),
            ];
        });

        return response()->json([
            'success' => true,
            'permissions' => $permissionsWithRoles,
            'roles' => $roles,
        ]);
    }

    public function savePermissions(Request $request)
    {
        // Validate incoming request
        $validated = $request->validate([
            'permissions' => 'required|array',
            'permissions.*.permission_id' => 'integer|exists:permissions,id',
            'permissions.*.role_id' => 'integer|exists:roles,id',
        ]);

        $permissions = $request->permissions;

        foreach ($permissions as $item) {
            $permission = Permission::find($item['permission_id']);
            $role = Role::find($item['role_id']);

            if ($item['is_assigned']) {
                // Attach the permission to the role if not already assigned
                if (!$role->hasPermissionTo($permission)) {
                    $role->givePermissionTo($permission);
                }
            } else {
                // Detach the permission from the role
                if ($role->hasPermissionTo($permission)) {
                    $role->revokePermissionTo($permission);
                }
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Permissions updated successfully!',
        ]);
    }


    public function getPermissionsWithRoles(Request $request)
    {
        $moduleName = $request->query('module_name');

        if (!$moduleName) {
            return response()->json(['success' => false, 'message' => 'Module name is required.']);
        }

        $permissions = Permission::where('module_name', $moduleName)
            ->with('roles') // Assuming a relationship between Permission and Role
            ->get()
            ->map(function ($permission) {
                return [
                    'id' => $permission->id,
                    'name' => $permission->name,
                    'assigned_roles' => $permission->roles->pluck('id'), // IDs of assigned roles
                ];
            });

        $roles = Role::all();

        return response()->json(['success' => true, 'permissions' => $permissions, 'roles' => $roles]);
    }


    public function add() {
        $data['industries']=ModulesData::where('module_id',43)->where('status','active')->pluck('title', 'id')->toArray();
        $data['categories'] = Modules::select('name', 'id')->where('status','active')->pluck('name', 'id')->toArray();

        $data['permissions'] = Permission::
        get()
        ->keyBy('name');

        return view('admin.modules.add')->with($data);
    }


    public function getDepartmentsByIndustry(Request $request)
{
    $industryId = $request->industry_id;

    // Fetch departments related to the selected industry
    $departments = ModulesData::where('category', $industryId)->pluck('title', 'id');

    return response()->json($departments);
}



public function edit($id)
{
    $data = array();
    $data['industries']=ModulesData::where('module_id',43)->where('status','active')->pluck('title', 'id')->toArray();

    $data['categories'] = Modules::select('name', 'id')->where('status', 'active')->pluck('name', 'id')->toArray();
    $data['module'] = Modules::findOrFail($id);

    $data['module_name'] = $data['module']->term;

    $data['permissions'] = Permission::where('module_name', $data['module_name'])
    ->get()
    ->keyBy('name'); // Group by permission name

$data['industries_id']=Modules::findOrFail($id);

    return view('admin.modules.edit')->with($data);
}



    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'term' => 'required',
        ], [
            'name.required' => 'Module Name is required.',
            'term.required' => 'Module Term is required.',
        ]);


        $slug = Str::slug($request->name, '-');
        $slugs = unique_slug($slug, 'modules', $field = 'slug', $key = NULL, $value = NULL);
        $module = new Modules();
        $module->name = $request->name;
        $module->term = $request->term;
        $module->is_slug = $request->is_slug;
        $module->is_menu = $request->is_menu;
        $module->is_description = $request->is_description;
        $module->is_highlights = $request->is_highlights;
        $module->is_seo = $request->is_seo;
        $module->category = $request->category;
        $module->multiple_category = $request->multiple_category;
        $module->sub_category = $request->sub_category;
        $module->parent_sub_id = $request->parent_sub_id;
        $module->tags = $request->tags;
        $module->is_image = $request->is_image;
        $module->multi_images = $request->multi_images;
        $module->parent_id = $request->parent_id;
        $module->thumbnail_height = $request->thumbnail_height;
        $module->thumbnail_width = $request->thumbnail_width;
        $module->extra_fields = $request->extra_fields;
        $module->sidebar_icon = $request->sidebar_icon;
        $module->industry_id = $request->industry_id;
        $module->department_id = $request->department_id;

        $module->slug = $slugs;
        if ($request->hasFile('image')) {
            // Generate a unique name for the image
            $imageName = uniqid() . '.' . $request->file('image')->getClientOriginalExtension();
            // Save the image directly to the public/images folder
            $request->file('image')->move(public_path('images'), $imageName);
            // Assign the image path to the module's image field
            $module->image = 'images/' . $imageName;
        }
        $module->save();

         // Get the checked permissions
    $actions = $request->input('actions');

    // Loop through each action and save it
    foreach ($actions as $action => $value) {
        $permission = new Permission();
        $permission->module_name = $request->name;

        $permission->name = $action . ' ' . $request->input($action . '_name'); // Combine action with the corresponding input
        $permission->save();
    }

        if($request->extra_fields && (int)$request->extra_fields>0){
               for ($i=1; $i <=$request->extra_fields ; $i++) {
                    $extra_field_title = 'extra_field_title_'.$i;
                    $extra_field_type = 'extra_field_type_'.$i;
                    $extra_field_attr = 'extra_field_attr_'.$i;
                    $extra_field_sort = 'extra_field_sort_'.$i;
                    $extra_field_col = 'extra_field_col_'.$i;
                    $extra_field_max_length = 'extra_field_max_length_'.$i;
                    $extra_field_required = 'extra_field_required_'.$i;
                    $extra_field_required_message = 'extra_field_required_message_'.$i;
                    $extra_field_show = 'extra_field_show_'.$i;
                    $extra_field_show_in_list = 'extra_field_show_in_list_'.$i;

                    $module->$extra_field_title = $request->$extra_field_title;
                    $module->$extra_field_type = $request->$extra_field_type;
                    $module->$extra_field_attr = $request->$extra_field_attr;
                    $module->$extra_field_sort = $request->$extra_field_sort;
                    $module->$extra_field_col = $request->$extra_field_col;
                    $module->$extra_field_max_length = $request->$extra_field_max_length;
                    $module->$extra_field_required = $request->$extra_field_required;
                    $module->$extra_field_required_message = $request->$extra_field_required_message;
                    $module->$extra_field_show = $request->$extra_field_show;

                    if($request->$extra_field_show_in_list){
                        $field_show = new FieldsShow();
                        $field_show->module_id = $request->id;
                        $field_show->field = 'extra_field_'.$i;
                        $field_show->field_title = $request->$extra_field_title;
                        $field_show->field_type = $request->$extra_field_type;
                        $field_show->field_attr = $request->$extra_field_attr;
                        $field_show->save();
                    }
            }
        }






        if ($module->save() == true) {
            $request->session()->flash('message.added', 'success');
            $request->session()->flash('message.content', 'A module has been successfully Created!');
        }
        return redirect(route('admin.modules'));
    }


    public function add_columns(Request $request)
    {
        Schema::table('modules', function (Blueprint $table) use($request) {

            for ($i=$request->start; $i <=$request->end ; $i++) {

                $extra_field_title = 'extra_field_title_'.$i;
                $extra_field_type = 'extra_field_type_'.$i;
                $extra_field_attr = 'extra_field_attr_'.$i;
                $extra_field_sort = 'extra_field_sort_'.$i;
                $extra_field_col = 'extra_field_col_'.$i;
                $extra_field_max_length = 'extra_field_max_length_'.$i;
                $extra_field_required = 'extra_field_required_'.$i;
                $extra_field_required_message = 'extra_field_required_message_'.$i;
                $extra_field_show = 'extra_field_show_'.$i;

                $table->text($extra_field_title)->nullable();
                $table->text($extra_field_type)->nullable();
                $table->text($extra_field_attr)->nullable();
                $table->text($extra_field_sort)->nullable();
                $table->text($extra_field_col)->nullable();
                $table->text($extra_field_max_length)->nullable();
                $table->text($extra_field_required)->nullable();
                $table->text($extra_field_required_message)->nullable();
                $table->text($extra_field_show)->nullable();

            }
        });
    }


    public function add_module_data_columns(Request $request)
    {
        Schema::table('modules_data', function (Blueprint $table) use($request) {

            for ($i=$request->start; $i <=$request->end ; $i++) {

                $extra_field = 'extra_field_'.$i;

                $table->string($extra_field)->nullable();


            }
        });
    }

    public function update(Request $request)
    {
        // Validation
        $this->validate($request, [
            'name' => 'required',
            'term' => 'required',
        ], [
            'name.required' => 'Module Name is required.',
            'term.required' => 'Module Term is required.',
        ]);

        // Find module by ID
        $module = Modules::findOrFail($request->id);

        // Handle module name and slug change
        if (trim($module->name) != trim($request->name)) {
            $slug = Str::slug($request->name, '-');
            $slugs = unique_slug($slug, 'modules', $field = 'slug');
            $module->slug = $slugs;
        }

        // Update module fields
        $module->name = $request->name;
        $module->term = $request->term;
        $module->is_slug = $request->is_slug;
        $module->is_menu = $request->is_menu;
        $module->is_description = $request->is_description;
        $module->is_highlights = $request->is_highlights;
        $module->is_seo = $request->is_seo;
        $module->is_preview = $request->is_preview;
        $module->category = $request->category;
        $module->multiple_category = $request->multiple_category;
        $module->sub_category = $request->sub_category;
        $module->parent_sub_id = $request->parent_sub_id;
        $module->tags = $request->tags;
        $module->is_image = $request->is_image;
        $module->multi_images = $request->multi_images;
        $module->parent_id = $request->parent_id;
        $module->thumbnail_height = $request->thumbnail_height;
        $module->thumbnail_width = $request->thumbnail_width;
        $module->extra_fields = $request->extra_fields;
        $module->industry_id = $request->industry_id;
        $module->department_id = $request->department_id;

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($module->image && file_exists(public_path($module->image))) {
                unlink(public_path($module->image));
            }

            // Generate a unique name for the new image
            $imageName = uniqid() . '.' . $request->file('image')->getClientOriginalExtension();
            // Save the new image to the public/images folder
            $request->file('image')->move(public_path('images'), $imageName);
            // Assign the new image path to the module
            $module->image = 'images/' . $imageName;
        }

        // Handle extra fields
        if ($request->extra_fields && (int) $request->extra_fields > 0) {
            for ($i = 1; $i <= $request->extra_fields; $i++) {
                $extra_field_title = 'extra_field_title_' . $i;
                $extra_field_type = 'extra_field_type_' . $i;
                $extra_field_attr = 'extra_field_attr_' . $i;
                $extra_field_sort = 'extra_field_sort_' . $i;
                $extra_field_col = 'extra_field_col_' . $i;
                $extra_field_max_length = 'extra_field_max_length_' . $i;
                $extra_field_required = 'extra_field_required_' . $i;
                $extra_field_required_message = 'extra_field_required_message_' . $i;
                $extra_field_show = 'extra_field_show_' . $i;
                $extra_field_show_in_list = 'extra_field_show_in_list_' . $i;

                // Update extra field data dynamically
                $module->$extra_field_title = $request->$extra_field_title;
                $module->$extra_field_type = $request->$extra_field_type;
                $module->$extra_field_attr = $request->$extra_field_attr;
                $module->$extra_field_sort = $request->$extra_field_sort;
                $module->$extra_field_col = $request->$extra_field_col;
                $module->$extra_field_max_length = $request->$extra_field_max_length;
                $module->$extra_field_required = $request->$extra_field_required;
                $module->$extra_field_required_message = $request->$extra_field_required_message;
                $module->$extra_field_show = $request->$extra_field_show;

                // Handle the extra field visibility in list
                if ($request->$extra_field_show_in_list) {
                    $field_show = FieldsShow::where('field', 'extra_field_' . $i)->where('module_id', $request->id)->first();
                    if ($field_show) {
                        $field_show->update([
                            'module_id' => $request->id,
                            'field' => 'extra_field_' . $i,
                            'field_title' => $request->$extra_field_title,
                            'field_type' => $request->$extra_field_type,
                            'field_attr' => $request->$extra_field_attr,
                        ]);
                    } else {
                        FieldsShow::create([
                            'module_id' => $request->id,
                            'field' => 'extra_field_' . $i,
                            'field_title' => $request->$extra_field_title,
                            'field_type' => $request->$extra_field_type,
                            'field_attr' => $request->$extra_field_attr,
                        ]);
                    }
                } else {
                    // Delete the field show if not selected
                    $field_show = FieldsShow::where('field', 'extra_field_' . $i)->where('module_id', $request->id)->first();
                    if ($field_show) {
                        $field_show->delete();
                    }
                }
            }
        }


    //     $term = $request->term; // The term (module name) inputted
    // $permissions = ['list', 'add', 'edit', 'update', 'delete']; // Permissions actions

    // foreach ($permissions as $action) {
    //     $permissionKey = $action . ' ' . $term;
    //     $name = $request->input($action . '_name'); // Get the name for each action
    //     $checked = $request->has($action); // Check if the checkbox is checked

    //     $existingPermission = Permission::where('name', $permissionKey)->first();

    //     if ($checked) {
    //         // If permission exists and it's being updated
    //         if ($existingPermission) {
    //             if ($existingPermission->name !== $name) {
    //                 // Only update if the name has changed
    //                 $existingPermission->name = $name;
    //                 $existingPermission->save();
    //             }
    //         } else {
    //             // If the permission doesn't exist, create a new one
    //             Permission::create([
    //                 'name' => $permissionKey,
    //                 'display_name' => $name,
    //             ]);
    //         }
    //     } else {
    //         // If the checkbox is unchecked and the permission exists, delete it
    //         if ($existingPermission) {
    //             $existingPermission->delete();
    //         }
    //     }
    // }

        // Update the module
        $module->update();



        // Flash success message and redirect
        $request->session()->flash('message.added', 'success');
        $request->session()->flash('message.content', 'A module has been successfully updated!');

        return redirect(route('admin.modules'));
    }


    public function destroy(Request $request, $id)
    {
        // Find the module by ID
        $module = Modules::findOrFail($id);

        // Find and delete permissions where 'module_name' matches the module's name
        Permission::where('module_name', $module->term)->delete();

        // Delete the module itself
        $module->delete();

        // Flash success message
        $request->session()->flash('message.added', 'success');
        $request->session()->flash('message.content', 'A module and its associated permissions have been successfully deleted!');

        // Redirect to modules list
        return redirect(route('admin.modules'));
    }

}

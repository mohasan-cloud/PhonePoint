<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\CampusFormRequest;
use Illuminate\Support\Facades\Hash;
use Laravel\Jetstream\HasProfilePhoto;
use Spatie\Permission\Models\Role;
use DataTables;
use Str;

class UsersController extends Controller
{
    use HasProfilePhoto;
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!auth()->check()) {
                return redirect('/home')->with('error', 'You need to log in to access this page.');
            }
    
            return $next($request);
        });
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // if (!auth()->check()) {
        //     return redirect('/')->with('error', 'You need to log in to access this page.');
        // }
        
        // if (!auth()->user()->can('list user')) {
        //     return redirect()->route('admin.dashboard')->with('error', 'You do not have permission to view this page.');
        // }
        if ($request->ajax()) {
            $data = User::select('*');
            return Datatables::of($data)
                        ->filter(function ($query) use ($request) {
                            if ($request->has('name') && !empty($request->name)) {
                                $query->where('name', 'like', "%{$request->get('name')}%");
                            }
                            if ($request->has('email') && !empty($request->email)) {
                                $query->where('email',$request->email);
                            }
                            if ($request->has('role') && !empty($request->role)) {
                                $query->where('role',$request->role);
                            }
                            if ($request->has('status') && !empty($request->status)) {
                                $query->where('status',$request->status);
                            }
                            $query->where('parent_id',auth()->user()->id);
                        })->addColumn('name', function ($data) {
                            return $data->name;
                        })->addColumn('email', function ($data) {
                               return $data->email; 
                        })->addColumn('role', function ($data) {
                                return role($data->role).' '.parent($data->parent_id);
                        })->addColumn('status', function ($data) {
                                $class = $data->status=='active'?'bg-success':'bg-warning';
                                return '<div class="badge '.$class.' text-white rounded-pill">'.ucfirst($data->status).'</div>';        
                        })->addColumn('action', function ($data) {
                           $edit = '';
                            $delete = '';                                $edit = '<a class="btn btn-datatable btn-icon btn-transparent-dark me-2" href="'.route('admin.users.edit',[$data->id]).'"><i class="fa-solid fa-pen-to-square"></i></a>';

                                $delete = '<a class="btn btn-datatable btn-icon btn-transparent-dark" href="'.route('admin.users.destroy',[$data->id]).'"><i class="fa-solid fa-trash"></i></a>';
                            return $edit.$delete;
                        })->rawColumns(['name', 'status', 'action', 'email'])

                        ->setRowId(function($data) {
                            return 'countryDtRow' . $data->id;
                        })->make(true);
        }
          
        return view('admin.users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // if (!auth()->check()) {
        //     return redirect('/')->with('error', 'You need to log in to access this page.');
        // }
        
        // if (!auth()->user()->can('add user')) {
        //     return redirect()->route('admin.dashboard')->with('error', 'You do not have permission to view this page.');
        // }
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // if (!auth()->check()) {
        //     return redirect('/')->with('error', 'You need to log in to access this page.');
        // }
        
        // if (!auth()->user()->can('add user')) {
        //     return redirect()->route('admin.dashboard')->with('error', 'You do not have permission to view this page.');
        // }
        $user = new User();
       $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->name = $request->first_name.' '.$request->last_name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->department = $request->department;
        $user->designation = $request->designation;
        $user->country = $request->country;
        $user->city = $request->city;
        $user->username = $request->username;
        $user->status = $request->status;
        $user->parent_id = auth()->user()->id;
        $user->password = Hash::make($request->password);
        $user->save();

        $roles = Role::findorFail($request->role);

        $user->assignRole($roles->name);

        $request->session()->flash('message.added', 'success');
        $request->session()->flash('message.content', 'You have successfully created new user');
        return redirect(route('admin.users.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // if (!auth()->check()) {
        //     return redirect('/')->with('error', 'You need to log in to access this page.');
        // }
        
        // if (!auth()->user()->can('edit user')) {
        //     return redirect()->route('admin.dashboard')->with('error', 'You do not have permission to view this page.');
        // }
        $user = User::findorFail($id);
        return view('admin.users.edit',compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        // if (!auth()->check()) {
        //     return redirect('/')->with('error', 'You need to log in to access this page.');
        // }
        
        // if (!auth()->user()->can('update user')) {
        //     return redirect()->route('admin.dashboard')->with('error', 'You do not have permission to view this page.');
        // }

        $user = User::findorFail($id);
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->name = $request->first_name.' '.$request->last_name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->department = $request->department;
        $user->designation = $request->designation;
        $user->country = $request->country;
        $user->city = $request->city;
        $user->username = $request->username;
        $user->status = $request->status;
        $user->parent_id = auth()->user()->id;
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        $user->update();

        $roles = Role::findorFail($request->role);

        $user->assignRole($roles->name);

       // dd($roles->name);


        $request->session()->flash('message.added', 'success');
        $request->session()->flash('message.content', 'You have successfully updated user informations');
        return redirect(route('admin.users.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        // if (!auth()->check()) {
        //     return redirect('/')->with('error', 'You need to log in to access this page.');
        // }
        
        // if (!auth()->user()->can('delete user')) {
        //     return redirect()->route('admin.dashboard')->with('error', 'You do not have permission to view this page.');
        // }
       User::where('id', $id)->delete();
       $request->session()->flash('message.added', 'danger');
       $request->session()->flash('message.content', 'You have successfully deleted a user');
       return redirect(route('admin.users.index'));

    }
}

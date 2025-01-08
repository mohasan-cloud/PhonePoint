<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Modules;
use App\Models\Menu_types;
use App\Models\ModulesData;
use App\Models\Tags;
use App\Models\Menu;
use App\Models\History;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use ZipArchive;
use DataTables;
use PDF;

class ModulesDataController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function index($slug = '')
    {

    if (!auth()->user()->test && !auth()->user()->can('Services Menegment') 
    && !auth()->user()->can('add-contact')
    && !auth()->user()->can('Why Choose Us Menegment')
    && !auth()->user()->can('Financial Recovery Menegment')
    && !auth()->user()->can('Client Testimonial Menegment')
    && !auth()->user()->can('Header Routes Menegment')
    && !auth()->user()->can('counter  Menegment')
    && !auth()->user()->can('Other Service Menegment')
    && !auth()->user()->can('How did you hear about us Menegment')


    ) {
        return redirect()->route('admin.dashboard')->with('error', 'You do not have permission to view this page.');
    }

        $data = [
            'module' => Modules::where('slug', $slug)->firstOrFail(),
        ];

        if ($data['module']->parent_id) {
            $data['parent'] = Modules::findOrFail($data['module']->parent_id);
        }

        return view('admin.modules_data.index')->with($data);
    }

    public function add($slug='passports')
    {
        $data = [
            'module' => Modules::where('slug', $slug)->firstOrFail(),
        ];

        if ($data['module']->parent_id) {

            $categories = ModulesData::where('module_id', $data['module']->parent_id)
                ->where('status', 'active')->get();

            $cate_arr = array();
            if(null!==($categories)){
                foreach ($categories as $key => $value) {
                   $cate_arr[$value->id] = $value->title.' ('.title($value->extra_field_1).')';
                }
            }    
            $data['categories'] = $cate_arr;
        }

        $data['tags'] = dropdown(3);

        return view('modules_data.add')->with($data);
    }

    public function edit($slug, $id)
    {
        $data = [
            'module' => Modules::where('slug', $slug)->firstOrFail(),
            'module_data' => ModulesData::findOrFail($id),
        ];

        if ($data['module']->parent_id) {
            $data['categories'] = ModulesData::where('module_id', $data['module']->parent_id)
                ->where('status', 'active')->pluck('title', 'id')->toArray();
        }

        $data['tags'] = dropdown(3);

        return view('admin.modules_data.edit')->with($data);
    }

    public function filterParties($id)
    {
        $module_data = ModulesData::findOrFail($id);
        echo $module_data->extra_field_4;
    }

    public function preview($slug, $id)
    {
        $data = [
            'module' => Modules::where('slug', $slug)->firstOrFail(),
            'menu_types' => Menu_types::where('status', 'active')->pluck('title', 'id')->toArray(),
            'module_data' => ModulesData::findOrFail($id),
        ];

        return view('admin.modules_data.preview')->with($data);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
        ], [
            'title.required' => 'Title is required.',
        ]);

        $slug = $request->slug;
        $slugs = unique_slug($slug, 'modules_data', 'slug');
        $dynamic_form = $request->input('dynamic_form');

        $data = ModulesData::where('extra_field_2',$request->extra_field_2)->first();
        if($data){
            $data->fill($request->only([
                'title', 'description', 'category', 'sub_category', 'module_id', 'meta_title', 'meta_keywords', 'meta_description', 'image', 'images',
            ]));
        }else{
            $data = new ModulesData($request->only([
                'title', 'description', 'category', 'sub_category', 'module_id', 'meta_title', 'meta_keywords', 'meta_description', 'image', 'images'
            ]));
        }
        

        $data->slug = $slugs;
        $data->category_ids = $data->category_ids?$data->category_ids.','.$request->category_ids:$request->category_ids;
        $data->image = $request->attached_file;

        $this->setExtraFields($data, $request);

        $data->tag_ids = $request->tag_ids ? implode(",", $request->tag_ids) : null;

        $this->saveDynamicForm($data, $dynamic_form);
        //$data->user_id = auth()->user()->id;

        $data->save();
        $module = Modules::findOrFail($data->module_id);
        if($module->is_preview){
            $check = checkCompleteIncomplete($data->id);
            $statusType = $check ? 'active' : 'blocked';
            $data->status = $statusType;
            $data->update();
        }

        $history = new History();
        $history->data_id = $data->id;
        $history->message = 'Front has create this record at '.date('Y-m-d H:i:s');
        $history->save();

        if ($request->ajax()) {
            return response()->json(['id' => $data->id, 'title' => $data->title]);
        }

        $request->session()->flash('message.added', 'success');
        $request->session()->flash('message.content', $request->module_term . ' has been successfully Created!');

        

        return redirect()->back();
    }

    public function update(Request $request)
    {
        //dd($request);
        $this->validate($request, [
            'title' => 'required',
        ], [
            'title.required' => 'Title is required.',
        ]);

        $slug = $request->slug;
        $data = ModulesData::findOrFail($request->id);

        $data->fill($request->only([
            'title', 'description', 'category', 'sub_category', 'module_id', 'meta_title', 'meta_keywords', 'meta_description', 'image', 'images',
        ]));

        $data->slug = $slug;
        $data->category_ids = $request->category_ids ? implode(",", $request->category_ids) : null;
        $data->image = $request->attached_file;

        $this->setExtraFields($data, $request);

        $data->tag_ids = $request->tag_ids ? implode(",", $request->tag_ids) : null;
        $data->final_submit = $request->finalSubmit=='yes' ? 'yes' : 'no';


        $this->saveDynamicForm($data, $request->dynamic_form);

        $data->update();

        $module = Modules::findOrFail($data->module_id);

        if($module->is_preview){
            $check = checkCompleteIncomplete($data->id);
            $statusType = $check ? 'active' : 'blocked';
            $data->status = $statusType;
            $data->update();
        }

        $history = new History();
        $history->data_id = $data->id;
        $history->message = 'Front has update this record at '.date('Y-m-d H:i:s');
        $history->save();

        $request->session()->flash('message.added', 'success');
        $request->session()->flash('message.content', $request->module_term . ' has been successfully Updated!');

        return redirect(route('admin.modules.data', $request->module_slug));
    }

    

    private function setExtraFields($data, $request)
    {
        for ($i = 1; $i <= 25; $i++) {
            $extra_field = 'extra_field_' . $i;
            

            // Check if the field is a file and has been uploaded
            if ($request->hasFile($extra_field) && $request->file($extra_field)->isValid()) {
                $file = $request->file($extra_field);
                $data->$extra_field = $file->getClientOriginalName();
                $file->move(public_path('images'), $file->getClientOriginalName());
            }else{
                if(!empty($request->$extra_field)){
                    $data->$extra_field = $request->$extra_field;
                }
                
            }
        }
    }




    private function saveDynamicForm($data, $dynamic_form)
    {
        if (isset($dynamic_form['dynamic_form']) && $dynamic_form['dynamic_form'] !== null) {
            $data->highlights = json_encode($dynamic_form['dynamic_form']);
        }
    }

    private function saveMenuTypes(Request $request, $data)
    {
        $menu_types = Menu_types::where('status', 'active')->pluck('title', 'id')->toArray();

        if ($menu_types) {
            foreach ($menu_types as $key => $menu_type) {
                $field = 'menu_' . $key;

                if ($request->$field) {
                    $menu = new Menu([
                        'title' => $data->title,
                        'slug' => $data->slug,
                        'menu_type_id' => $key,
                        'post_id' => $data->id,
                        'parent_id' => 0,
                        'order' => Menu::max('order') + 1,
                        'menu_is' => 'internal',
                    ]);

                    $menu->save();
                }
            }
        }
    }

   public function fetchModulesData(Request $request)
    {
        $module = Modules::findOrFail($request->id);
        $modulesDataQuery = ModulesData::where('module_id', $module->id)->orderBy('id','DESC');
        
        $selectcontacts = array();
        if($request->selectcontacts){
            $selectcontacts = explode(',', $request->selectcontacts);
        }
        
        

        $datacolumns = DataTables::of($modulesDataQuery)
            ->filter(function ($query) use ($request, $module) {
                $this->applyFilters($query, $request, $module);
            })
            ->addColumn('image', function ($modulesData) {
                return '<div class="image-container"><img src="' . asset('/images/thumb/' . $modulesData->image) . '" alt=""></div>';
            }) 
           ->addColumn('checkedvals', function ($modulesData) use ($selectcontacts) {
                return '<span><input type="checkbox" name="checkedvals[]" ' . (in_array($modulesData->id, $selectcontacts) ? 'checked' : '') . ' value="' . $modulesData->id . '" placeholder="" class=""></span>';
            })
            ->addColumn('title', function ($modulesData) use ($module){
                  return '<span>' . Str::limit(strip_tags($modulesData->title), 40, '...') . '</span>';  
            })
            ->addColumn('created_date', function ($modulesData) {
                return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $modulesData->created_at);
            })
            ->addColumn('category', function ($modulesData) use ($module) {
                return $this->getCategoryLinks($modulesData, $module);
            })
            ->addColumn('status', function ($modulesData) use ($module) {
                return $this->getStatusBadge($modulesData,$module);
            })
            ->addColumn('action', function ($modulesData) use ($module) {
                return $this->getActionButtons($module, $modulesData);
            })
            ->rawColumns(['title', 'status', 'action', 'image', 'category','checkedvals'])
            ->setRowId(function ($modulesData) {
                return 'countryDtRow' . $modulesData->id;
            });

        $this->addColumnFields($datacolumns, $module);

        return $datacolumns->make(true);
    }

    private function applyFilters($query, $request, $module)
    {
        if ($request->filled('title')) {
            $query->where('title', 'like', "%{$request->get('title') }%");
        }

        if ($request->filled('category')) {
            $query->where(function ($query) use ($request) {
                $query->where('category', '=', $request->get('category'))
                    ->orWhere('category_ids', 'like', "%{$request->get('category') }%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $fields = $module->fields()->get();

        foreach ($fields as $val) {
            $field = $val->field;

            if ($request->filled($field)) {
                $query->where($field, 'like' , "%{$request->$field}%");
            }
        }
    }

    private function getCategoryLinks($modulesData, $module)
    {
        if ($module->multiple_category) {
            $cateIds = explode(",", $modulesData->category_ids);
            $categories = ModulesData::whereIn('id', $cateIds)->get();
            $cateLinks = $categories->map(function ($cat) {
                return $cat->title;
            })->implode(' | ');

            return $cateLinks;
        } else {
            return title($modulesData->category);
        }
    }

    private function getStatusBadge($modulesData,$module)
    {
        $statusType = ($modulesData->status == 'active') ? 'success' : 'danger';
        $statusIcon = ($modulesData->status == 'active') ? 'check-circle' : 'times-circle';
        $statusText = ucfirst($modulesData->status);
      
        $status = '<span class="' . $statusType . '"><i class="fas fa-' . $statusIcon . '"></i>&nbsp;<span style="font-size: 12px;" class="status-text">' . $statusText . '</span></span>';

        return '<a class="waves-effect status waves-light" onclick="update_status(' . $modulesData->id . ');" href="javascript:void(0);" id="sts_' . $modulesData->id . '"> ' . $status . '</a>';
    }



    private function getActionButtons($module, $modulesData)
    {
        $edit = '';
        $delete = '';
        $preview = ($module->is_preview)
            ? '<a target="_blank" href="' . route('admin.modules.data.share.files',[$modulesData->id,$module->id]) . '"><i class="icofont icofont-eye-alt"></i>&nbsp;<i class="fa-solid fa-share"></i></a>&nbsp&nbsp&nbsp'
            : '';
        if (auth()->user()->hasRole('Super Admin')) {
            $edit = '<a class="" href="' . route('admin.modules.data.edit', [$module->slug, $modulesData->id]) . '"><i class="fa-solid fa-pen-to-square"></i></a>&nbsp&nbsp&nbsp';

            $delete = '<a class="" id="delete" href="' . route('admin.modules.data.delete', [$module->slug, $modulesData->id]) . '"><i class="fa-solid fa-trash"></i></a>';
        }else{
            if($module->is_preview && $modulesData->final_submit=='no'){
                $edit = '<a class="" href="' . route('admin.modules.data.edit', [$module->slug, $modulesData->id]) . '"><i class="fa-solid fa-pen-to-square"></i></a>&nbsp&nbsp&nbsp';
            }
        }    
        

        return $preview . $edit . $delete;
    }

    private function addColumnFields($datacolumns, $module)
    {
        $fields = $module->fields()->get();

        foreach ($fields as $val) {
            $field = $val->field;

            $datacolumns->addColumn($field, function ($modulesData) use ($field,$val) {
                $titleField = optional($modulesData)->$field;
                
                if ($titleField !== null) {
                    if ($val->field_type == 'select') {
                        return title($titleField);
                    } elseif ($val->field_type == 'number') {
                        return $titleField?number_format($titleField):'';
                    } else {
                        return $titleField;
                    }
                }

                return '';
            });
        }
    }



    public function destroy(Request $request, $slug, $id)
    {
        $data = ModulesData::findOrFail($id);
        $slug = $data->slug;
        $data->delete();

        $request->session()->flash('message.added', 'success');
        $request->session()->flash('message.content', 'Successfully Deleted!');

        return redirect()->back();
    }

    public function destroyFile(Request $request, $id, $field)
    {
        $data = ModulesData::findOrFail($id);
        $data->$field = null;
        $data->update();

        $request->session()->flash('message.added', 'success');
        $request->session()->flash('message.content', 'Successfully Deleted!');

        return redirect()->back();
    }

    public function update_status($id, $current_status)
    {
        if (empty($id) || empty($current_status)) {
            return response()->json(['error' => 'Invalid data provided.']);
        }

        $new_status = (strtolower($current_status) == 'active') ? 'blocked' : 'active';

        $module = ModulesData::findOrFail($id);
        $module->status = $new_status;
        $module->update();

        echo $new_status;
    }

    public function downloadFiles($id, $moduleId)
    {

        $data = [
            'module' =>  $module = Modules::findOrFail($moduleId),
            'menu_types' => Menu_types::where('status', 'active')->pluck('title', 'id')->toArray(),
            'module_data' => ModulesData::findOrFail($id),
        ];

        //return view('admin.modules_data.preview')->with($data);


        $pdf = PDF::loadView('admin.modules_data.download', $data);
        return $pdf->download($data['module_data']->title.'.pdf');

        // Create a unique zip file name
        $zipFileName = 'files_' . time() . '.zip';

        // Use a temporary directory to create the ZIP file
        $tempZipFilePath = storage_path("temp/" . $zipFileName);

        // Create a new ZipArchive instance
        $zip = new ZipArchive;

        $filesPath = array();

        // Open the zip file for creating
        if ($zip->open($tempZipFilePath, ZipArchive::CREATE) === TRUE) {
            foreach ($fileFields as $key => $fileField) {

                $filePath = public_path("images/" . $module_data->$fileField);
                //dd($filePath);
                if (file_exists($filePath) && !empty($module_data->$fileField)) {
                    $zip->addFile($filePath, basename($module_data->$fileField));
                    $filesPath[] = $filePath;

                }
            }
           // dd($zip);
            // Close the zip file
            sleep(1);
            
            $zip->close();
        }

        // Move the ZIP file to the intended location
        $finalZipFilePath = public_path("images/" . $zipFileName);
        rename($tempZipFilePath, $finalZipFilePath);

        // Set the appropriate content type
        $headers = [
            'Content-Type' => 'application/zip',
            'Content-Disposition' => 'attachment; filename="' . $zipFileName . '"',
        ];

        // Return the response with the zip file content
        return response()->download($finalZipFilePath, null, $headers);
    }


    public function shareFiles($id, $moduleId)
    {
        $module = Modules::findOrFail($moduleId);
        $module_data = ModulesData::findOrFail($id);

        $filePaths = [];

        for ($i = 1; $i <= 25; $i++) {
            $fieldName = "extra_field_type_$i";
            $fieldType = $module->$fieldName;
            $fieldTitle = "extra_field_$i";

            if ($fieldType === 'file') {
                $filePaths[] = asset("images/" . $module_data->$fieldTitle);
            }
        }

        $phoneNumber = '03436193567'; // Get the phone number from the request

        if (!$phoneNumber) {
            return response()->json(['status' => 'error', 'message' => 'Phone number is required'], 400);
        }

        return view('admin.modules_data.share', compact('filePaths', 'phoneNumber'));
    }




}


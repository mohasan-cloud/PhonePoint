<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ModulesData;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use Str;
use Form;
use Html;

class CmsController extends Controller
{
    public function index($slug=''){
        //dd($slug);
        $cms = ModulesData::where('slug',$slug)->first();
        return view('pages.cms')->with('cms',$cms);

    }

    public function import(Request $request){
        $id = $request->id;
        $ids = explode('-', $id);
        $arr = array();
        for ($i=$ids[0]; $i <= $ids[1]; $i++) {
        	$arr[] = $i;
        }

    	$countries = Country::where('lang','en')->whereIn('id',$arr)->get();
    	//dd($countries);
    	foreach ($countries as $key => $value) {
    		$data = new ModulesData();
        	$data->module_id = 11;
        	$data->title = $value->country;
        	$data->extra_field_1 = $value->nationality;
        	$data->extra_field_2 = $value->flag;
        	$data->extra_field_3 = $value->flag2;
        	$data->status = 'active';
        	$data->save();

        	$states = State::where('country_id',$value->country_id)->get();
        	if(null!==($states)){
        		foreach ($states as $key => $val) {
	        		$state = new ModulesData();
		        	$state->module_id = 12;
		        	$state->title = $val->state;
		        	$state->category = $data->id;
		        	$state->status = 'active';
		        	$state->save();

		        	$cities = City::where('state_id',$val->state_id)->get();
		        	if(null!==($cities)){
		        		foreach ($cities as $key => $va) {
			        		$city = new ModulesData();
			        		$city->module_id = 13;
			        		$city->title = $va->city;
			        		$city->category = $state->id;
			        		$city->status = 'active';
			        		$city->save();
			        	}
		        	}

	        	}
        	}

    	}

    }

    public function filterStates(Request $request)
    {
        $country_id = $request->input('country_id');
        $state = $request->input('state');
        $states = ModulesData::select('title', 'id')->where('category',$country_id)->where('status','active')->pluck('title', 'id')->toArray();
        $dd = Form::select('state', ['' => __('Select State')] + $states, $state, array('class' => 'form-control', 'id' => 'state'));
        echo $dd;
    }

    public function filterSubCategories(Request $request)
    {
        $category = $request->input('category');
        $sub_category = $request->input('sub_category');
        if($category){
            $sub_categories = ModulesData::select('title', 'id')->where('category',$category)->where('status','active')->pluck('title', 'id')->toArray();
        }else{
            $sub_categories = array();
        }

        $dd = Html::select('sub_category', ['Select Sub Category'] + $sub_categories, $sub_category)->class('form-control')->id('sub_category')->required();
        echo $dd;
    }

    public function filterSubSubCategories(Request $request)
    {
        $sub_category = $request->input('sub_category');
        $sub_sub_category = $request->input('sub_sub_category');
        if($sub_category){
            $sub_categories = ModulesData::select('title', 'id')->where('category',$sub_category)->where('status','active')->pluck('title', 'id')->toArray();
        }else{
            $sub_categories = array();
        }

        $dd = Form::select('sub_sub_category', ['' => __('Select Sub of Sub Category')] + $sub_categories, $sub_sub_category, array('class' => 'form-control', 'id' => 'sub_sub_category'));
        echo $dd;
    }


    public function filterCoursesPrograms(Request $request)
    {
        $type = $request->input('type');

        if($type=='course'){
             $sub_categories = ModulesData::select('title', 'id')->where('module_id',2)->where('status','active')->pluck('title', 'id')->toArray();

        $ll = Form::label('program_id','Select Course', ['class' => 'font-weight-bold']);

        $dd = $ll.' '.Form::select('program_id', ['' => __('Select Course')] + $sub_categories, null, array('class' => 'form-control', 'id' => 'program_id'));


        echo $dd;


        }else if($type=='program'){
            $sub_categories = ModulesData::select('title', 'id')->where('module_id',30)->where('status','active')->pluck('title', 'id')->toArray();

            $ll = Form::label('program_id','Select Program', ['class' => 'font-weight-bold']);

            $dd = $ll.' '.Form::select('program_id', ['' => __('Select Program')] + $sub_categories, null, array('class' => 'form-control', 'id' => 'program_id'));

            echo $dd;
        }


    }


    public function filterCoursesServices(Request $request)
    {
        $type = $request->input('type');

        if($type=='Course'){
             $sub_categories = ModulesData::select('title', 'id')->where('module_id',2)->where('status','active')->pluck('title', 'id')->toArray();

        if($request->arr){
                $old = explode(',',$request->arr);
        }else{
            $old = array();
        }
        $ll = Form::label('program_id','Select Courses', ['class' => 'font-weight-bold']);

        $dd = $ll.'<div class="row">';

        if(null!==$sub_categories){
            foreach ($sub_categories as $key => $value) {
                $checked = (in_array($key, $old))?'checked':'';
                $dd .= '<div class="col-md-4 all_documents"><div class="form-group border-checkbox-section"><div class="border-checkbox-group border-checkbox-group-success"><input class="border-checkbox" '.$checked.' name="service_courses[]" type="checkbox" id="checkbox'.$key.'" value="'.$key.'">
                    <label class="border-checkbox-label" for="checkbox'.$key.'">'.$value.'</label><input class="form-control" name="service_courses_q[]" type="number" value="" placeholder="Quantity" style="margin-bottom:5px"><input class="form-control" name="service_courses_p[]" type="number" value="" placeholder="Price"></div></div></div>';
            }
        }


        echo $dd.'</div>';


        }else if($type=='Service'){
            $sub_categories = ModulesData::select('title', 'id')->where('module_id',23)->where('status','active')->pluck('title', 'id')->toArray();

            if($request->arr){
                $old = explode(',',$request->arr);
            }else{
                $old = array();
            }

            //dd($old);
            $ll = Form::label('program_id','Select Service', ['class' => 'font-weight-bold']);

            $dd = $ll.'<div class="row">';;

            if(null!==$sub_categories){
            foreach ($sub_categories as $key => $value) {
                $checked = (in_array($key, $old))?'checked':'';
                $dd .= '<div class="col-md-3 all_documents" ><div class="form-group border-checkbox-section"><div class="border-checkbox-group border-checkbox-group-success"><input class="border-checkbox" '.$checked.' name="service_courses[]" type="checkbox" id="checkbox'.$key.'" value="'.$key.'">
                    <label class="border-checkbox-label" for="checkbox'.$key.'">'.$value.'</label><input class="form-control" name="service_courses_q[]" type="number" value="" placeholder="Quantity" style="margin-bottom:5px"><input class="form-control" name="service_courses_p[]" type="number" value="" placeholder="Price"></div></div></div>';
            }
        }


            echo $dd.'</div>';
        }


    }


    public function filterSubCategory(Request $request)
    {
        $category = $request->input('category_id');
        $sub_category = $request->input('sub_category_id');
        if($category){
            $sub_categories = ModulesData::select('title', 'id')->where('category',$category)->where('status','active')->pluck('title', 'id')->toArray();
        }else{
            $sub_categories = array();
        }

        $dd = Form::select('sub_category_id', ['' => __('Select Sub Category')] + $sub_categories, $sub_category, array('class' => 'form-control', 'id' => 'sub_category_id'));
        echo $dd;
    }

    public function filterCourses(Request $request)
    {
        $sub_category = $request->input('sub_category_id');
        $course_id = $request->input('course_id');
        if($sub_category){
            $courses = ModulesData::select('title', 'id')->where('sub_category',$sub_category)->where('status','active')->pluck('title', 'id')->toArray();
        }else{
            $courses = array();
        }

        $dd = Form::select('course_id', ['' => __('Select Course')] + $courses, $course_id, array('class' => 'form-control', 'id' => 'course_id'));
        echo $dd;
    }

    public function filterCities(Request $request)
    {
        $state_id = $request->input('state_id');
        $city = $request->input('city');
        $cities = ModulesData::select('title', 'id')->where('category',$state_id)->where('status','active')->pluck('title', 'id')->toArray();

        $dd = Form::select('city', ['' => 'Select City'] + $cities, $city, array('id' => 'city', 'class' => 'form-control'));
        echo $dd;
    }
}

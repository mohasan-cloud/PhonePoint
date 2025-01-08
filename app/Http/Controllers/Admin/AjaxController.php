<?php



namespace App\Http\Controllers;



use DB;


use App\Models\User;
use Illuminate\Http\Request;



class AjaxController extends Controller

{



    /**

     * Create a new controller instance.

     *

     * @return void

     */

    public function __construct()

    {

        //

    }



    public function checkEmail(Request $request)

    {

        $email = trim($request->email);
        $user = User::where('email',$email)->first();
        if(!empty($user->email)){
            echo 'false';
        }else{
             echo 'true';
        }

    } 

    public function checkUsername(Request $request)

    {

        $user_name = trim($request->user_name);
        $user = User::where('user_name',$user_name)->first();
        if(!empty($user->user_name)){
            echo 'false';
        }else{
             echo 'true';
        }

    }

    public function checkAllowCountry(Request $request)

    {

        $account_type = $request->account_type;
        $country_of_residence = $request->country_of_residence;

        if(null!==($country_of_residence) && !in_array($country_of_residence, activeCountries()) && $account_type !=54358){
            echo 'false';
        }else{
             echo 'true';
        }

    }



}


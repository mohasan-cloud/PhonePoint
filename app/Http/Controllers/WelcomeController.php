<?php

namespace App\Http\Controllers;

use App\Models\TechioMarekting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\ModulesData;
use App\Models\About;
use App\Models\SiteSetting;

class WelcomeController extends Controller
{
    public function index()
    {

        $teams = ModulesData::where('module_id', 22)->where('status','active')->get();

        // Fetch the record with ID 1
        $technology = TechioMarekting::find(1);

        $SiteSetting = SiteSetting::find(8);

        $About = About::find(2);
        // Check if the record exists (optional)
        if (!$technology) {
            return redirect()->back()->with('error', 'Technology not found');
        }
        $uni_id = mt_rand(100000, 999999);
        $services = ModulesData::where('module_id', 3)->where('status', 'active')->get();
        $otherservices = ModulesData::where('module_id', 10)->where('status', 'active')->get();
        $hearabout = ModulesData::where('module_id', 11)->where('status', 'active')->get();
        // Pass the data to the view
        return view('welcome')->with('technology', $technology)->with('uni_id', $uni_id)
            ->with('hearabout', $hearabout)
            ->with('otherservices', $otherservices)
            ->with('About', $About)
            ->with('SiteSetting', $SiteSetting)
            ->with('teams', $teams);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Traffic;
use Illuminate\Http\Request;

class TrafficController extends Controller
{
    public function index()
    {
        $trafficData = Traffic::all();

        return view('admin.traffic.index', compact('trafficData'));
    }
}

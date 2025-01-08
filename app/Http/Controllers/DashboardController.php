<?php

namespace App\Http\Controllers;



use App\Models\Bill;

use App\Models\Contact; // Make sure to import the Contact model

use App\Models\Modules;
use App\Models\Expense;

use App\Models\ModulesData;
use App\Models\Product;
use App\Models\Traffic;

use App\Models\User;

use Carbon\Carbon;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;



class DashboardController extends Controller

{



    public function index()
    {
        // Fetch data for total users, total bills, and total products
        $totalUsers = User::count();
        $totalBills = Bill::count();
        $totalProducts = Product::count();

        // Total earnings (only paid bills)
        $totalEarnings = Bill::where('status', 'paid')->sum('total_price');

        // Today's earnings (only paid bills)
        $todayEarnings = Bill::where('status', 'paid')
            ->whereDate('created_at', Carbon::today())
            ->sum('total_price');

        // Weekly earnings (only paid bills)
        $weeklyEarnings = Bill::where('status', 'paid')
            ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->sum('total_price');

        // Today's bills count
        $todayBills = Bill::where('status', 'paid')
            ->whereDate('created_at', Carbon::today())
            ->count();

        // Weekly bills count
        $weeklyBills = Bill::where('status', 'paid')
            ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->count();

        // Chart Data Preparation
        // Total bills by date (only paid)
        $billsChartData = Bill::where('status', 'paid')
            ->select(DB::raw('DATE(created_at) as date, SUM(total_price) as total_sales'))
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('total_sales', 'date');

        // Today's bills hourly data (only paid)
        $todayBillsData = Bill::where('status', 'paid')
            ->select(DB::raw('HOUR(created_at) as hour, SUM(total_price) as total_sales'))
            ->whereDate('created_at', Carbon::today())
            ->groupBy('hour')
            ->orderBy('hour')
            ->pluck('total_sales', 'hour');

        // Weekly bills (only paid)
        $weeklyBillsData = Bill::where('status', 'paid')
            ->select(DB::raw('DAYOFWEEK(created_at) as day, SUM(total_price) as total_sales'))
            ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->groupBy('day')
            ->orderBy('day')
            ->pluck('total_sales', 'day');

        // Earnings chart data
        $earningsChartData = Bill::where('status', 'paid')
            ->select(DB::raw('DATE(created_at) as date, SUM(total_price) as total_earnings'))
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('total_earnings', 'date');

        // Prepare labels and data for charts
        $billsChartLabels = $billsChartData->keys()->toArray();
        $billsChartData = $billsChartData->values()->toArray();
        $pendingBillsTotal = Bill::where('status', 'pending')->sum('total_price');

        $todayBillsChartLabels = array_map(function ($hour) {
            return "$hour:00";
        }, array_keys($todayBillsData->toArray()));
        $todayBillsChartData = $todayBillsData->values()->toArray();

        $weeklyBillsChartLabels = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];
        $weeklyBillsChartData = $weeklyBillsData->values()->toArray();
 // Total Expenses
 $totalExpenses = Expense::sum('cost');

 // Last Month Expenses
 $lastMonthExpenses = Expense::whereBetween('created_at', [
     Carbon::now()->subMonth()->startOfMonth(),
     Carbon::now()->subMonth()->endOfMonth()
 ])->sum('cost');

 // This Month Expenses
 $thisMonthExpenses = Expense::whereBetween('created_at', [
     Carbon::now()->startOfMonth(),
     Carbon::now()->endOfMonth()
 ])->sum('cost');

 // Today Expenses
 $todayExpenses = Expense::whereDate('created_at', Carbon::today())->sum('cost');
// This Month Earnings
$thisMonthEarnings = Bill::where('status', 'paid')
    ->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])
    ->sum('total_price');

// Last Month Earnings
$lastMonthEarnings = Bill::where('status', 'paid')
    ->whereBetween('created_at', [Carbon::now()->subMonth()->startOfMonth(), Carbon::now()->subMonth()->endOfMonth()])
    ->sum('total_price');
    $thisMonthEarningsData = Bill::where('status', 'paid')
    ->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])
    ->select(DB::raw('DAY(created_at) as day, SUM(total_price) as total_earnings'))
    ->groupBy('day')
    ->orderBy('day')
    ->pluck('total_earnings', 'day');

// Earnings for Last Month (chart data)
$lastMonthEarningsData = Bill::where('status', 'paid')
    ->whereBetween('created_at', [Carbon::now()->subMonth()->startOfMonth(), Carbon::now()->subMonth()->endOfMonth()])
    ->select(DB::raw('DAY(created_at) as day, SUM(total_price) as total_earnings'))
    ->groupBy('day')
    ->orderBy('day')
    ->pluck('total_earnings', 'day');

 // Fetch all expenses
 $expenses = Expense::paginate(10);
        return view('admin.dashboard', compact(
            'totalUsers',
            'totalBills',
            'totalProducts',
            'todayBills',
            'weeklyBills',
            'billsChartData',
            'todayBillsChartData',
            'weeklyBillsChartData',
            'billsChartLabels',
            'todayBillsChartLabels',
            'weeklyBillsChartLabels',
            'totalEarnings',
            'earningsChartData',
            'todayEarnings',
            'weeklyEarnings',
            'pendingBillsTotal',
            'totalExpenses',
            'lastMonthExpenses',
            'thisMonthExpenses',
            'todayExpenses',
            'expenses',
            'thisMonthEarnings'
            ,
            'lastMonthEarnings',
            'thisMonthEarningsData',
            'lastMonthEarningsData',
        ));
    }



    public function getDepartments(Request $request)

    {

        $departments = ModulesData::where('category', $request->industry_id)->get();

        return response()->json($departments);

    }



    public function getCardsData(Request $request)

    {

        $departmentId = $request->department_id;



        // Fetch module data with related category information

        $modulesData = Modules::where('department_id', $departmentId)->get();

        $moduleIds = $modulesData->pluck('module_id');



        // Fetch cards and include category information

        $cards = Modules::where('department_id', $departmentId)

            ->get()

            ->map(function ($card) use ($departmentId) {

                // Assuming 'ModulesData' has a 'category' field corresponding to 'Modules'

                $card->category = ModulesData::where('module_id', $card->id)->value('category');

                return $card;

            });



        $response = [

            'modules' => $modulesData,

            'cards' => $cards,

        ];



        return response()->json($response);

    }





    public function getUserSelection()

    {

        $user = Auth::user();

        $industry = ModulesData::find($user->industry_id);

        $department = ModulesData::find($user->department_id);



        return response()->json([

            'industry_id' => $user->industry_id,

            'industry_name' => $industry ? $industry->title : '',

            'department_id' => $user->department_id,

            'department_name' => $department ? $department->title : ''

        ]);

    }



    public function storeUserSelection(Request $request)

    {

        $user = Auth::user();

        $user->industry_id = $request->industry_id;

        $user->department_id = $request->department_id;

        $user->save();



        return response()->json(['status' => 'success']);

    }



    public function clearUserSelection(Request $request)

    {

        $user = Auth::user();

        $user->industry_id = null;

        $user->department_id = null;

        $user->save();



        return response()->json(['status' => 'success']);

    }



    public function notifyIT(Request $request)

    {

        $username = $request->input('username');

        $website = $request->input('website');

        $reason = $request->input('reason');



        // Email data

        $data = [

            'username' => $username,

            'website' => $website,

            'reason' => $reason,

        ];



        // Send email

        Mail::send('emails.notifyIT', $data, function ($message) {

            $message->to('it@webhut.com')

                ->subject('User Tracking Notification');

        });



        return response()->json(['message' => 'Notification sent successfully.'], 200);

    }

}




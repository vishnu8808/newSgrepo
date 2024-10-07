<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use App\Models\Commision;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Validation\Rules;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class CommisionController extends Controller
{

    public function view()
    {
        $user = Auth::user();
        $total_payout = Commision::where('user_id',$user->id)->sum('com_amount');

        // Check if the user exists
        if (!$user) {
            return redirect()->route('dashboard')->with('error', 'User not found');
        }

        // Return a view with user data
        return view('commision', ['data'=>$user,'total_payout'=>$total_payout]);
    }
    
    
    public function getList(Request $request)
    {
        $user = Auth::user();
        if ($request->ajax()) {
            $data = Commision::with('sales')->where('user_id',$user->id)->latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('created_date', function($row){
                    $date = isset($row->created_at)?date('F j, Y', strtotime($row->created_at)):'';
                    return $date;
                })

                ->addColumn('name', function($row){
                    $name = isset($row->sales->user->name)?$row->sales->user->name:'';
                    return $name;
                })

                ->addColumn('sales_amount', function($row){
                    $sales_amount = isset($row->sales->amount)?$row->sales->amount:'';
                    return $sales_amount;
                })

                ->addColumn('sales_name', function($row){
                    $sales_name = isset($row->sales->ref_name)?$row->sales->ref_name:'';
                    return $sales_name;
                })

                ->addColumn('level_name', function($row){
                    $level_name = isset($row->sales->user->levels->name)?$row->sales->user->levels->name:'';
                    return $level_name;
                })
                
                ->rawColumns(['created_date','name','level_name','sales_amount','sales_name'])
                ->make(true);
        }
    }

    

   

}

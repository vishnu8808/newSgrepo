<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use App\Models\Sales;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Validation\Rules;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class SalesController extends Controller
{
    
    
    public function getList(Request $request)
    {
        $id = $request->input('id'); 
        $childArr=getChildNodes($id);
        $user = Auth::user();
        if ($request->ajax()) {
            $data = Sales::with('user')->whereIn('user_id',$childArr)->latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('created_date', function($row){
                    $date = isset($row->created_at)?date('F j, Y', strtotime($row->created_at)):'';
                    return $date;
                })

                ->addColumn('name', function($row){
                    $name = isset($row->user->name)?$row->user->name:'';
                    return $name;
                })

                ->addColumn('level_name', function($row){
                    $level_name = isset($row->user->levels->name)?$row->user->levels->name:'';
                    return $level_name;
                })
                
                ->rawColumns(['created_date','name','level_name'])
                ->make(true);
        }
    }

     /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        //$users = Auth::user();

        $insertedId = DB::table('sales')->insertGetId([
            'user_id' => $request->user_id,
            'amount' => $request->amount,
            'ref_name'=>$request->ref_name,
            'created_at'=>date('Y-m-d')
        ]);

        $arr=addCommision($request->user_id,$request->amount,$insertedId);

        if ($insertedId) {
            return response()->json(['success' => 'Sale stored successfully!']);
        } else {
            return response()->json(['error' => 'Sale not found'], 404);
        }
    }

   

}

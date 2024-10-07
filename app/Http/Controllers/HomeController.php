<?php

namespace App\Http\Controllers;

use App\Models\User;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Validation\Rules;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function dashboard(Request $request)
    {
        return view('dashboard');
    }

    public function add(Request $request)
    {
        return view('add');
    }
    
    public function getUsers(Request $request)
    {
        $user = Auth::user();
        if ($request->ajax()) {
            $data = User::latest()->where('parent_id',$user->id)->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<a href="' . route('users.view', $row->id) . '" class="edit btn btn-primary btn-sm">View</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $users = Auth::user();
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
        
        $leve_id=$users->level_id;
        if($users->level_id <=5){
            $leve_id=$users->level_id+1;
        }

        $user = User::Insert([
            'name' => $request->name,
            'email' => $request->email,
            'parent_id'=>$users->id,
            'level_id'=>$leve_id,
            'password' => Hash::make($request->password),
        ]);

        return redirect(route('dashboard', absolute: false));
    }

    public function view($id)
    {
        // Fetch the user by ID
        $user = User::with('levels')->find($id);

        //echo "<pre>";print_r($user);die();

        // Check if the user exists
        if (!$user) {
            return redirect()->route('dashboard')->with('error', 'User not found');
        }

        // Return a view with user data
        return view('view', ['data'=>$user]);
    }
}

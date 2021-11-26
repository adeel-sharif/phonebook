<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Admin;
use App\Models\Client;
use App\Models\Contact;
use Hash;
use Validator;
use Auth;
use Carbon\Carbon;

class LoginController extends Controller
{
    public function userDashboard()
    {
        
        $contact_day    = Contact::where('client_id',Auth()->user()->id)->whereDate('created_at', Carbon::today())->count();

        $contact_week   = Contact::where('client_id',Auth()->user()->id)->where('created_at', '>', Carbon::now()->startOfWeek())
     ->where('created_at', '<', Carbon::now()->endOfWeek())->count();
        
        $contact_month  = Contact::where('client_id',Auth()->user()->id)->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->count();
        $contacts       =  array('day'=> $contact_day,'week'=>$contact_week,'month'=>$contact_month);

        return response()->json($contacts , 200);
    }

    public function adminDashboard()
    {
        //$users = Admin::all();

        $contact_day    = Contact::whereDate('created_at', Carbon::today())->count();

        $contact_week   = Contact::where('created_at', '>', Carbon::now()->startOfWeek())
     ->where('created_at', '<', Carbon::now()->endOfWeek())->count();

        $contact_month  = Contact::whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->count();
        $contacts       =  array('day'=> $contact_day,'week'=>$contact_week,'month'=>$contact_month);

        return response()->json($contacts , 200);
    }

    public function userLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['error' => $validator->errors()->all()]);
        }

        if(auth()->guard('client')->attempt(['email' => request('email'), 'password' => request('password')])){

            config(['auth.guards.api.provider' => 'client']);
            
            $user = Client::select('clients.*')->find(auth()->guard('client')->user()->id);
            $success =  $user;
            $success['token'] =  $user->createToken('MyApp',['user'])->accessToken; 

            return response()->json($success, 200);
        }else{ 
            return response()->json(['error' => ['Email and Password are Wrong.']], 200);
        }
    }

    public function adminLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['error' => $validator->errors()->all()]);
        }

        if(auth()->guard('admin')->attempt(['email' => request('email'), 'password' => request('password')])){

            config(['auth.guards.api.provider' => 'admin']);
            
            $admin = Admin::select('admins.*')->find(auth()->guard('admin')->user()->id);
            $success =  $admin;
            $success['token'] =  $admin->createToken('MyApp',['admin'])->accessToken; 

            return response()->json($success, 200);
        }else{ 
            return response()->json(['error' => ['Email and Password are Wrong.']], 200);
        }
    }

    /*public function adminRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['error' => $validator->errors()->all()]);
        }

        // create admin here
        $admin = new Admin;

        $admin->email    =$request->email ;
        $admin->password = Hash::make($request->password);
        $admin->save();
        return response()->json($admin, 200);
    }*/

    


}
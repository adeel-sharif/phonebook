<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use Hash;
use Validator;
use Auth;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
          $client =  Client::all();

         return response()->json($client, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|unique:clients|email',
            'password' => 'required',
        ]);
        if($validator->fails()){
            return response()->json(['error' => $validator->errors()->all()]);
        }
        // create admin here
        $client = new Client;

        $client->email    = $request->email ;
        $client->password = Hash::make($request->password);
        $client->save();
        return response()->json($client, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $clients = Client::find($id);
            if (is_null($clients)) {
                return $this->sendError('Client not found.');
            }
            return response()->json([
            "success" => true,
            "message" => "Client retrieved successfully.",
            "data" => $clients
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input     = $request->all();
        $validator = Validator::make($input, [
            'email'    => "unique:users,email,$id,id",
            //'password' => 'required',
        ]);
        if($validator->fails()){
            return response()->json(['error' => $validator->errors()->all()]);
        }
        $client  = Client::find($id);
        $client->email = $request->email;
        $client->save();
        return response()->json([
        "success" => true,
        "message" => "Client updated successfully.",
        "data" => $client
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

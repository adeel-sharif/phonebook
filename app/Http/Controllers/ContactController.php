<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use Hash;
use Validator;
use Auth;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
          $contacts =  Contact::all();

         return response()->json($contacts, 200);
    }

     public function clients_contacts($client_id)
    {
          $contacts =  Contact::where('client_id',$client_id)->get();

         return response()->json($contacts, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator      = Validator::make($request->all(), [
            'name'      => 'required',
            'email'     => 'required|unique:contacts|email',
            'client_id' => 'required',
            'phone'     => 'required',
        ]);
        if($validator->fails()){
            return response()->json(['error' => $validator->errors()->all()]);
        }
        // create admin here
        $contact = new Contact;

        $contact->name        = $request->name ;
        $contact->email       = $request->email ;
        $contact->client_id   = $request->client_id ;
        $contact->phone       = $request->phone;
        $contact->save();
        return response()->json($contact, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $contact = Contact::find($id);
            if (is_null($contact)) {
                return response()->json(['error'=>'Contact not found.']);
            }
            return response()->json([
            "success" => true,
            "message" => "Contact retrieved successfully.",
            "data" => $contact
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

            'email'     => "unique:contacts,email,$id,id",
            'name'      => 'required',
            'phone'     => 'required',
            //'password' => 'required',
        ]);
        if($validator->fails()){
            return response()->json(['error' => $validator->errors()->all()]);
        }
        $contact              = Contact::find($id);
        $contact->name        = $request->name ;
        $contact->email       = $request->email ;
        $contact->client_id   = $request->client_id ;
        $contact->phone       = $request->phone;
        $contact->save();

        return response()->json([
        "success" => true,
        "message" => "Contact updated successfully.",
        "data" => $contact
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
        $contact = Contact::findOrFail($id);
        $contact->delete();
            return response()->json([
            "success" => true,
            "message" => "Contact deleted successfully.",
            "data" => $contact
            ]);
    }
}

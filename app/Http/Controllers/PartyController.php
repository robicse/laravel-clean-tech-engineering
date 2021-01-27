<?php

namespace App\Http\Controllers;

use App\Imports\CustomersImport;
use App\Party;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CustomersExport;


class PartyController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:party-list|party-create|party-edit|party-delete', ['only' => ['index','show']]);
        $this->middleware('permission:party-create', ['only' => ['create','store']]);
        $this->middleware('permission:party-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:party-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $parties = Party::latest()->get();
        return view('backend.party.index',compact('parties'));
    }


    public function create()
    {
        return view('backend.party.create');
    }
    public function store(Request $request)
    {
        //dd($request->all());
        $this->validate($request, [
            'type'=> 'required',
            'name' => 'required',
            'phone'=> 'required|unique:parties,phone',
            'email'=> '',
        ]);
        $parties = new Party();
        $parties->type = $request->type;
        $parties->name = $request->name;
        $parties->phone = $request->phone;
        $parties->email = $request->email;
        $parties->address = $request->address;
        $parties->status = $request->status;
        //dd($parties);
        $parties->save();

        $insert_id = $parties->id;
        //dd($insert_id);
        if($insert_id  && $request->type == 2){
            $user_data['name'] = $request->name;
            $user_data['email'] = $request->email;
            $user_data['phone'] = $request->phone;
            $user_data['password'] = Hash::make(123456);
            $user_data['party_id'] = $insert_id;
            //$user_data['role_id'] = 3;
            //dd($user_data);
            $user = User::create($user_data);

            $user->assignRole('Customer');
           // dd($user);
        }
        Toastr::success('Party Created Successfully', 'Success');
        return redirect()->route('party.index');

    }


    public function show($id)
    {
        //
    }
    public function edit($id)
    {

        $parties = Party::find($id);
       // dd($parties);
        return view('backend.party.edit',compact('parties'));
    }


    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'type'=> 'required',
            'name'=> 'required',
            'phone'=> 'required',
            'email'=> '',
            'address'=> '',
        ]);

        $parties = Party::find($id);
        $parties->type = $request->type;
        $parties->name = $request->name;
        $parties->phone = $request->phone;
        $parties->email = $request->email;
        $parties->address = $request->address;
        $parties->status = $request->status;
        // dd($parties);
        $parties->save();
        Toastr::success('Party Updtaed Successfully', 'Success');
        return redirect()->route('party.index');
    }


    public function destroy($id)
    {
        $parties = Party::find($id);
        $parties->delete();
        Toastr::success('Party Deleted Successfully Done!');
        return redirect()->route('party.index');
    }
    public function checkPhoneNumber(Request $request ){
        $phone = $request->phone;
        $exist_phone_number = Party::where('phone',$phone)->get();
        if (count($exist_phone_number) >0)
        {
            $check_number = "Found";
        }
        else{
            $check_number = "Not Found";
        }
        return response()->json(['success'=>true,'data'=>$check_number]);
    }

    public function importExportView()
    {
        return view('backend.party.index');
    }

    public function export()
    {
        return Excel::download(new CustomersExport, 'customers.xlsx');

    }

    public function import()
    {
       // dd('ss');
        Excel::import(new CustomersImport,request()->file('file'));

        return back();
    }
}

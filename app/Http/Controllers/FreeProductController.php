<?php

namespace App\Http\Controllers;

use App\FreeProduct;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class FreeProductController extends Controller
{

    public function index()
    {
        $freeprodcuts = FreeProduct::latest()->get();
        return view('backend.FreeProduct.index',compact('freeprodcuts'));

    }


    public function create()
    {
        return view('backend.FreeProduct.create');
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);

        $freeprodcuts = new FreeProduct;
        $freeprodcuts->name = $request->name;
        $freeprodcuts->slug = Str::slug($request->name);
        $freeprodcuts->description = $request->description;
        $freeprodcuts->status = $request->status;
        $image = $request->file('image');
        if (isset($image)) {
            //make unique name for image
            $currentDate = Carbon::now()->toDateString();
            $imagename = $currentDate . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
//            resize image for hospital and upload
            $proImage =Image::make($image)->resize(300, 300)->save($image->getClientOriginalExtension());
            Storage::disk('public')->put('uploads/free-product/'.$imagename, $proImage);


        }else {
            $imagename = "default.png";
        }

        $freeprodcuts->image = $imagename;
        //dd($freeprodcuts->image);
        $freeprodcuts->save();

        Toastr::success('Free Product Created Successfully');
        return redirect()->route('free-products.index');
    }

    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $freeprodcuts = FreeProduct::find($id);
        return view('backend.FreeProduct.edit',compact('freeprodcuts'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);

        $freeprodcuts = FreeProduct::find($id);
        $freeprodcuts->name = $request->name;
        $freeprodcuts->slug = Str::slug($request->name);
        $freeprodcuts->description = $request->description;
        $freeprodcuts->status = $request->status;
        $image = $request->file('image');
        if (isset($image)) {
            //make unique name for image
            $currentDate = Carbon::now()->toDateString();
            $imagename = $currentDate . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
//            resize image for hospital and upload
            $proImage =Image::make($image)->resize(300, 300)->save($image->getClientOriginalExtension());
            Storage::disk('public')->put('uploads/free-product/'.$imagename, $proImage);


        }else {
            $imagename =  $freeprodcuts->image;
        }

        $freeprodcuts->image = $imagename;
        //dd($freeprodcuts->image);
        $freeprodcuts->save();

        Toastr::success('Free Product Edited Successfully');
        return redirect()->route('free-products.index');
    }

    public function destroy($id)
    {
        $freeprodcuts = FreeProduct::find($id);
        $freeprodcuts->delete();
        return redirect()->route('free-products.index');
    }
}

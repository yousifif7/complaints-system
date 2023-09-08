<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\FormType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\myformRequest;
use App\Models\RequestType;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\File; 

class FormController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $myrequest = FormType::all();
        $category = Category::all();
        $requesttype = RequestType::all();
        return view('formsview',compact('myrequest','category','requesttype'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required|max:10|min:10',
            'userfile' => 'mimes:png,jpg,jpeg,pdf|max:10000',
        ]);

        if($request->hasFile('userfile')){
            $path= $request->file('userfile')->store('userFiles','files');

            FormType::create([
                'name' => $request->name,
                'address' => $request->address ,
                'phone' => $request->phone ,
                'content' => $request->content ,
                'file' => $path ,
                'status' => $request->status ,
                'requesttype_id' => $request->formtype,
                'category_id' => $request->category
            ]);
        }else{

            FormType::create([
                'name' => $request->name,
                'address' => $request->address ,
                'phone' => $request->phone ,
                'content' => $request->content ,
                'file' => '' ,
                'status' => $request->status ,
                'requesttype_id' => $request->formtype,
                'category_id' => $request->category
            ]);
        }

        return redirect()->route('category.index')->with('success','Form posted');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $myrequest = FormType::findorFail($id);
        $category = Category::all();
        $requesttype = RequestType::all();
        return view('viewDetails',compact('myrequest','category','requesttype'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $form = FormType::findorFail($id);
        $form->status = $request->status;
        $form->save();
        return redirect()->route('form.index');
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
        $form = FormType::findorFail($id);
        $form->status = $request->status;
        $form->save();
        return redirect()->route('form.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $form = FormType::findorFail($id);
        $image_path = public_path('userFiles/'.$form->file);
        if ($form::exists(public_path($image_path))) {
            File::delete($image_path);        
        }
        $form->delete();
        return redirect()->route('form.index');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteAll(){
            // $form= FormType::file();
            // $image_path = public_path('userFiles/'.$form->file);
            // if ($form::exists(public_path($image_path))) {
            //     File::delete($image_path);        
            // }
        FormType::truncate();
        return redirect()->route('form.index');
    }
    public function deleteCompleted(){
        $form= FormType::where('status','2')->delete();
        return redirect()->route('form.index');
    }
}

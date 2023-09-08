<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\FormType;
use App\Models\RequestType;
use Illuminate\Http\Request;

class CatController extends Controller
{
    
    public function index(){
        $category = Category::all();

        return view('categories.index',compact('category'));
    }
    public function cat($id){
        $cat = Category::findorFail($id);
        $reqtype = RequestType::all();

        return view('layouts.cat',compact('cat','reqtype'));
    }

    public function create(){
        $category = Category::all();
        return view('createcat',compact('category'));
    }

    public function storeCat(Request $request){
        $category = Category::all();
        $this->validate($request,[
            'createdCatName' => 'required',
        ]);
        Category::create([
           'catName' => $request->createdCatName
        ]);

        return redirect()->route('category.create');
    }
     /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::findorFail($id);
        return view('editing.catedit',compact('category'));
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
        $category = Category::findorFail($id);
        $category->catName = $request->createdCatName;
        $category->save();
        return redirect()->route('category.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        $category = Category::findorFail($id);
        $category->catName = $request->createdCatName;
        $category->save();
        return redirect()->route('category.create');
    }
    
     /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        $category_id = $id;
        $category = Category::findorFail($id)->delete();
        return redirect()->route('category.create');
    }

   
}

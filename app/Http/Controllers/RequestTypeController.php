<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\RequestType;
use Illuminate\Http\Request;

class RequestTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = Category::all();
        $requesttype = RequestType::all();
        return view('createreq_type',compact('category','requesttype'));
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
            'createdRequest' => 'required',
        ]);
        RequestType::create([
            'request_name' => $request->createdRequest,
            'category_id' => $request->formCat
        ]);
        
        return redirect()->route('requesttype.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $reqtype = RequestType::findorFail($id);
        $reqtype->request_name = $request->createdRequest;
        $reqtype->category_id =$request->formCat;
        $reqtype->save();
        return redirect()->route('requesttype.create');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $reqtype = RequestType::findorFail($id);
        $category = Category::all();
        return view('editing.reqtype_edit',compact('reqtype','category'));
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
        $reqtype = RequestType::findorFail($id);
        $reqtype->catName = $request->createdRequest;
        $reqtype->category_id =$request->formCat;
        $reqtype->save();
        return redirect()->route('requesttype.create');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $requesttype = RequestType::findorFail($id)->delete();
        return redirect()->route('requesttype.create');
    }
}

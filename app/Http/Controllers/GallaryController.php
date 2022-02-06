<?php

namespace App\Http\Controllers;

use App\Models\Gallary;
use App\Models\Image;
use Illuminate\Http\Request;

class GallaryController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         // $this->middleware('permission:gallary-list|gallary-create|gallary-edit|gallary-delete', ['only' => ['index','show']]);
         // $this->middleware('permission:gallary-create', ['only' => ['create','store']]);
         // $this->middleware('permission:gallary-edit', ['only' => ['edit','update']]);
         // $this->middleware('permission:gallary-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $gallary = gallary::latest()->paginate(5);
        return view('gallary.index',compact('gallary'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('gallary.create');
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'name' => 'required',
        ]);
    
        gallary::create($request->all());
    
        return redirect()->route('gallary.index')
                        ->with('success','gallary created successfully.');
    }
    
    /**
     * Display the specified resource.
     *
     * @param  \App\gallary  $gallary
     * @return \Illuminate\Http\Response
     */
    public function show(gallary $gallary)
    {
        $gallary_id = $gallary->id;
        $images = Image::select("*")
                        ->where("g_id", "=", '1')
                        ->get();
        //dd($images);
        return view('gallary.show',['images'=>$images,'gallary'=>$gallary]);
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\gallary  $gallary
     * @return \Illuminate\Http\Response
     */
    public function edit(gallary $gallary)
    {
        return view('gallary.edit',compact('gallary'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\gallary  $gallary
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, gallary $gallary)
    {
         request()->validate([
            'name' => 'required',
            
        ]);
    
        $gallary->update($request->all());
    
        return redirect()->route('gallary.index')
                        ->with('success','gallary updated successfully');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\gallary  $gallary
     * @return \Illuminate\Http\Response
     */
    public function destroy(gallary $gallary)
    {
        $gallary->delete();
    
        return redirect()->route('gallary.index')
                        ->with('success','gallary deleted successfully');
    }
    public function upload_image(Request $request){
        $this->validate($request, [
            'title' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);


        $input['image'] = time().'.'.$request->image->getClientOriginalExtension();
        $request->image->move(public_path('images'), $input['image']);


        $input['title'] = $request->title;
        $input['g_id'] = $request->g_id;
        //dd($input);
        Image::create($input);


        return back()
            ->with('success','Image Uploaded successfully.');
    }
    public function delete_image($id){
        Image::find($id)->delete();
        return back()
            ->with('success','Image removed successfully.');
    }
}

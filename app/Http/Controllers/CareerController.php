<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Career;
use Auth;
use Purifier;
use Crypt;

class CareerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // check if auth
        if(!Auth::check())  return redirect()->route('welcome');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // check if auth
        if(!Auth::check())  return redirect()->route('welcome');
        
        // check role and permission
        if(!Auth::user()->hasAnyDirectPermission(['Create Career']) && !Auth::user()->hasAnyRole(['Administrator', 'Developer', 'Super Admin'])) return redirect()->route('careers.career-list')->with(['err-msg' => 'Access Denied!!!']);

        return view('backend.careers.new');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // check if auth
        if(!Auth::check())  return redirect()->route('welcome');
        
        // check role and permission
        if(!Auth::user()->hasAnyDirectPermission(['Create Career']) && !Auth::user()->hasAnyRole(['Administrator', 'Developer', 'Super Admin'])) return redirect()->route('careers.career-list')->with(['err-msg' => 'Access Denied!!!']);

        $this->validate($request, [
            'position' => 'required|min:3',
            'description' => 'required|min:10',
            'salary_range' => 'nullable|min:10',
            'location' => 'nullable|min:2',
            'close_date' => 'nullable|date',
            'publish' => 'nullable|boolean',
        ]);
        $career = new Career();
        if($request->publish) {
            $career->publish = $request->publish;
        }else{
            $career->publish = false;
        }
        $career->position = $request->position;
        $career->salary_range = $request->salary_range;
        $career->location = $request->location;
        $career->close_date = $request->close_date;
        $career->description = Purifier::clean($request->description);
        $career->author = auth()->user()->id;
        if($career->save()){
            $message = 'Career post added successfully';
            return redirect()->route('careers.show', Crypt::encrypt($career->id));
        }
        $message = 'Error adding post';
        return redirect()->back()->with('error-message', $message);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // check if auth
        if(!Auth::check())  return redirect()->route('welcome');
        
        // check role and permission
        if(!Auth::user()->hasAnyDirectPermission(['Edit Career', 'Manage Career']) && !Auth::user()->hasAnyRole(['Administrator', 'Developer', 'Super Admin'])) return redirect()->route('careers.career-list')->with(['err-msg' => 'Access Denied!!!']);
        $id = Crypt::decrypt($id);
        if(!Career::find($id)) return redirect()->route('careers.career-list')->with(['err-msg' => 'Invalid Request!!!']);

        $career = Career::find($id);
        if(!$career) return redirect()->back();
        return view('backend.careers.edit', compact([
            'career', Career::find($id),
        ]));
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
        // check if auth
        if(!Auth::check())  return redirect()->route('welcome');
        
        // check role and permission
        if(!Auth::user()->hasAnyDirectPermission(['Edit Career', 'Manage Career']) && !Auth::user()->hasAnyRole(['Administrator', 'Developer', 'Super Admin'])) return redirect()->route('careers.career-list')->with(['err-msg' => 'Access Denied!!!']);
        
        if(!Career::find($id)) return redirect()->route('careers.career-list')->with(['err-msg' => 'Invalid Request!!!']);
              
        $this->validate($request, [
            'position' => 'required|min:3',
            'description' => 'required|min:10',
            'salary_range' => 'nullable|min:10',
            'location' => 'nullable|min:2',
            'close_date' => 'nullable|date',
            'publish' => 'nullable|boolean',
        ]);
        $career = Career::find($id);
        if($career){
            if($request->publish) {
                $career->publish = $request->publish;
            }else{
                $career->publish = false;
            }
            $career->position = $request->position;
            $career->salary_range = $request->salary_range;
            $career->location = $request->location;
            $career->close_date = $request->close_date;
            $career->description = Purifier::clean($request->description);
            $career->author = auth()->user()->id;
            if($career->save()){
                $message = 'Career post added successfully';
                return redirect()->route('careers.show-career', Crypt::encrypt($career->id));
            }
            return redirect()->route('careers.career-list');
        }
        $message = 'Error adding post';
        return redirect()->back()->with('error-message', $message);
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

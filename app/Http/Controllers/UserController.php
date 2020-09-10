<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Section;
use App\User;
use App\UserSection;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = User::orderBy("id", "DESC")->paginate(10);

        return view('user.list', ['result' => $result]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
  
        return view('user.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required'],
            'email' => ['required', 'unique:users'],
            'password' => ['required', 'min:6']
        ]);
        

        $data = new User;
        $data->name = $request['name'];
        $data->email = $request['email'];
        $data->password = Hash::make($request['password']);
        $data->save();
        

        return redirect()->route('users.create');
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
        $result = User::find($id)->toArray();
        
        return view('user.form', ['result' => $result]);
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
        $validatedData = $request->validate([
            'name' => ['required'],
            'email' => ['required',Rule::unique('users')->ignore($id)],
            'password' => ['required', 'min:6']
        ]);

        
        $data = User::find($id);
        
        $data->name = $request['name'];
        $data->email = $request['email'];
        $data->password = Hash::make($request['password']);
        $data->save();
        

        return redirect('/users');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        UserSection::where('user_id',$id)->delete();
        $data = User::find($id);
        $data->delete();
        return redirect('/users');
    }
}

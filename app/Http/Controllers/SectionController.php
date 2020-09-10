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

class SectionController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $result = Section::orderBy("id", "DESC")->paginate(4);

        return view('section.list', ['result' => $result]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $user = User::get()->toArray();

        return view('section.form', ['user' => $user]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $validatedData = $request->validate([
            'name' => ['required'],
            'description' => ['required'],
            'users' => ['required'],
            'file' => ['file', 'mimes:jpeg,jpg,png', 'required'],
        ]);
        
        

        $data = new Section;
        $mytime = new Carbon;
        $year = str_replace('-', '_', $mytime->now()->toDateString());
        $time = str_replace(':', '_', $mytime->now()->toTimeString());
        $rand = Str::random(4);
        $ext = $request->file('file')->extension();
        $filename = $year . "_" . $time . '_' . $rand . '.' . $ext;
        $image = $request->file('file')->storeAs('/logo', $filename);
        $request->file('file')->move('storage/logo', $filename);
        $data->name = $request['name'];
        $data->description = $request['description'];
        $data->logo = $image;
        $data->save();
        $id = $data->id;
        $users = $request->users;
        foreach ($users as $value){
            DB::table("users_sections")->insert([
                'section_id' => $id,
                'user_id' => $value
            ]);

        }

        return redirect()->route('sections.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $result = Section::find($id)->toArray();
        $user = User::get()->toArray();
        $checked_user = UserSection::where("section_id",$id)->get()->toArray();
        $checked_users_arr = [];
        foreach ($checked_user as $key => $value){
            $checked_users_arr[$value['user_id']] = $value;
        }
        return view('section.form', ['result' => $result,'user' => $user,'checked_users_arr' => $checked_users_arr]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $validatedData = $request->validate([
            'name' => ['required'],
            'description' => ['required'],
            'users' => ['required'],
            'file' => ['file', 'mimes:jpeg,jpg,png'],
        ]);
        
        
        UserSection::where("section_id",$id)->delete();
        
        $data = Section::find($id);
        if ($request->file('file')) {
            Storage::delete($data->logo);
            File::delete("storage/" . $data->logo);
            $mytime = new Carbon;
            $year = str_replace('-', '_', $mytime->now()->toDateString());
            $time = str_replace(':', '_', $mytime->now()->toTimeString());
            $rand = Str::random(4);
            $ext = $request->file('file')->extension();
            $filename = $year . "_" . $time . '_' . $rand . '.' . $ext;
            $image = $request->file('file')->storeAs('/logo', $filename);
            $request->file('file')->move('storage/logo', $filename);
            $data->logo = $image;
        }
        $data->name = $request['name'];
        $data->description = $request['description'];
        $data->save();
        
        $users = $request->users;
        foreach ($users as $value){
            DB::table("users_sections")->insert([
                'section_id' => $id,
                'user_id' => $value
            ]);

        }
        

        return redirect('/sections');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        UserSection::where('section_id',$id)->delete();
        $data = Section::find($id);
        Storage::delete($data->logo);
        File::delete("storage/" . $data->logo);
        $data->delete();
        return redirect('/sections');
    }

}

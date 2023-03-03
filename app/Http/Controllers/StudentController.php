<?php

namespace App\Http\Controllers;
use App\Models\Stud;
use Illuminate\Http\Request;


class StudentController extends Controller
{ 
    public function home(Request $request) {
        $students = Stud::all();
        
        $value = $request->session()->get('id');
        $log = Stud::findOrFail($value);
        return view('home',['students' => $students , 'name' => $log]);
    }

    public function view($id,Request $request) {
        $student = Stud::findOrFail($id);
        $request->session()->put('id',$id);
        
        return view('view',['stud' => $student]);
    }

    public function add() {
        return view('add');
    }

    public function save(Request $request) {
        // dd($request->post('title'));
        $validatedData = $request->validate(
            ["roll_no"=> ['required'],
            "name"=> ['required','max:250'],
            "course"=> ['required','max:122']
        ]);
        Stud::create($validatedData);

        return redirect('/');
    }

    public function delete($id) {
        $student = Stud::findOrFail($id);
        $student->delete();
        return redirect('/');

    }

    public function edit($id) {
        $student = Stud::findOrFail($id);
        return view('update', ['stud'=> $student]);

    }

    public function update(Request $request,$id) {
        // dd($request->post('title'));
        $validatedData = $request->validate(
            ["roll_no"=> ['required'],
            "name"=> ['required','max:250'],
            "course"=> ['required','max:122']
        ]);
        $student = Stud::findOrFail($id);
        $student->update($validatedData);

        return redirect('/');
    }

}

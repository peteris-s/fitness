<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use Illuminate\Http\Request;

class ExerciseController extends Controller
{
    public function index()
    {
        return view('exercises.index', ['exercises'=>Exercise::paginate(20)]);
    }

    public function create()
    {
        return view('exercises.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate(['name'=>'required|string|max:255','description'=>'nullable|string|max:1000','category'=>'required|string|max:100','difficulty'=>'required|in:beginner,intermediate,advanced']);
        Exercise::create($data);
        return redirect()->route('exercises.index')->with('success','Exercise added!');
    }

    public function show(Exercise $exercise)
    {
        return view('exercises.show', ['exercise'=>$exercise,'workoutCount'=>$exercise->workouts()->count()]);
    }

    public function edit(Exercise $exercise)
    {
        return view('exercises.edit', ['exercise'=>$exercise]);
    }

    public function update(Request $request, Exercise $exercise)
    {
        $data = $request->validate(['name'=>'required|string|max:255','description'=>'nullable|string|max:1000','category'=>'required|string|max:100','difficulty'=>'required|in:beginner,intermediate,advanced']);
        $exercise->update($data);
        return redirect()->route('exercises.show',$exercise)->with('success','Exercise updated!');
    }

    public function destroy(Exercise $exercise)
    {
        $exercise->delete();
        return redirect()->route('exercises.index')->with('success','Exercise deleted!');
    }
}

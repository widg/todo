<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;

class TasksApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $todo = Todo::All();
        return response()->json($todo);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $this->validate($request, ['title' => 'required']);

        $newTask = Todo::create([
            'title' => $request->get('title'),
        ]);

        return response()->json($newTask);
    }

    /**
     * Display the specified resource.
     */
    public function show(Todo $todo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Todo $todo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Todo $todo, $id)
{
    $todo = Todo::findOrFail($id);
    $todo->title = $request->input('title');
    $todo->description = $request->input('description');
    $todo->is_completed = $request->input('is_completed');
    $todo->save();

    return response()->json($todo);
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $todo = Todo::findOrFail($id);
        $todo->delete();
    }
}

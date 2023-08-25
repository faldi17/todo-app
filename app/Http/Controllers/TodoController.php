<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    public function index()
    {
        $todos = Todo::all();
        return view('welcome', [
            'todos' => $todos
        ]);
    }

    public function store()
    {
        $attributes = request()->validate([
            'title' => 'required',
            'description' => 'nullable'
        ]);
        Todo::create($attributes);
        return redirect('/');
    }

    public function complete(Todo $todo)
    {
        $todo->update(['isDone' => true]);
        return redirect('/');
    }

    public function destroy(Todo $todo)
    {
        $todo->delete();
        return redirect('/');
    }

    public function edit(Todo $todo)
    {
        return view('edit', [
            'todo' => $todo
        ]);
    }

    public function updateTodo(int $id, Request $req)
    {
        $todo = Todo::find($id);

        $todo->update([
            'title'  => $req->title,
            'description'  => $req->description,
        ]);

        return redirect('/');
    }
}

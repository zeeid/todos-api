<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TodoController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        return Todo::where('user_id', $user->id)->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string'
        ]);

        $todo = Todo::create([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => auth()->id()
        ]);

        return response()->json($todo, 201);
    }

    public function update(Request $request, $id)
    {
        $todo = Todo::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        $todo->update($request->all());
        return $todo;
    }

    public function destroy($id)
    {
        $todo = Todo::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        $todo->delete();
        return response()->json(['message' => 'Deleted']);
    }
}

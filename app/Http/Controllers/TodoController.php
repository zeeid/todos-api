<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    public function index()
    {
        return Todo::where('user_id', auth()->id())->get();
    }

    public function store(Request $request)
    {
        return Todo::create([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => auth()->id()
        ]);
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

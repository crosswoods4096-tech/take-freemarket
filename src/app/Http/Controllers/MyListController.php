<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MyListController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $likes = Like::where('user_id', $user->id)
            ->with('product')
            ->get();

        return view('mylist.index', compact('likes'));
    }
}

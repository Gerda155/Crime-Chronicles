<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    public function index()
    {
        $genres = Genre::whereNull('deleted_at')->where('status', 'active')->paginate(10);
        return view('genres.index', compact('genres'));
    }
}

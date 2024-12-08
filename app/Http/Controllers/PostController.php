<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth:sanctum')->except(['index', 'show']);
    // }
    public function __construct()
    {
        $this->middleware('auth:sanctum');  // Semua metode di controller ini memerlukan autentikasi
    }

    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     return Post::all();
    // }
    public function index(Request $request)
    {
        // Mengambil post milik user yang sedang login
        $posts = $request->user()->posts;

        // Mengembalikan data post dalam format JSON
        return response()->json($posts);
        
    }

    // public function index(Request $request)
    // {
    //     // Ambil user yang sedang login
    //     $userId = auth()->id();

    //     // Filter kontak berdasarkan user yang sedang login
    //     $posts = Post::where('user_id', $userId)->get();

    //     return response()->json($posts);
    // }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
           'name' => 'required|max:255',
            'phone'=> 'required',
            'address' => 'required',
        ]);

        $post = $request->user()->posts()->create($fields);

        return['post' => $post];
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return $post;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        Gate::authorize('modify', $post);
        $fields = $request->validate([
            'name' => 'required|max:255',
            'phone'=> 'required',
            'address' => 'required'
        ]);

        $post->update($fields);

        return $post;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        Gate::authorize('modify', $post);

        $post->delete();

        return ['message' => 'Contact deleted'];
    }
}

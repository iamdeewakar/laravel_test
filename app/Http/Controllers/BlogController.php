<?php

namespace App\Http\Controllers;

use App\Mail\BlogShareMail;
use App\Models\Blog;
use Illuminate\Http\Request;
use App\Models\Tag;
use Auth;
use Illuminate\Support\Facades\Mail;

class BlogController extends Controller
{
    //

    public function index()
    {
        $blogs = Blog::with('user', 'tags')->paginate(5);
        return view('blogs.index', compact('blogs'));
    }

    public function show($id)
    {
        $blog = Blog::with('user', 'tags', 'comments')->findOrFail($id);
        return view('blogs.show', compact('blog'));
    }

    public function create()
    {
        $tags = Tag::all();
        return view('blogs.create', compact('tags'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'tags' => 'array',
        ]);

        $blog = Blog::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'content' => $request->content,
        ]);

        $blog->tags()->attach($request->tags);

        return redirect()->route('blogs.index');
    }

    public function edit($id)
    {
        $blog = Blog::findOrFail($id);
        $tags = Tag::all();
        return view('blogs.edit', compact('blog', 'tags'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'tags' => 'array',
        ]);

        $blog = Blog::findOrFail($id);
        $blog->update($request->only('title', 'content'));
        $blog->tags()->sync($request->tags);

        return redirect()->route('blogs.index');
    }

    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);
        $blog->delete();

        return redirect()->route('blogs.index');
    }

    public function searchByTag(Request $request)
{
    $request->validate([
        'tag' => 'required|string',
    ]);

    $tag = Tag::where('name', $request->tag)->first();
    $blogs = $tag ? $tag->blogs()->paginate(5) : collect();

    return view('blogs.index', compact('blogs'));
}

public function search(Request $request)
{
    $request->validate([
        'query' => 'required|string',
    ]);

    $blogs = Blog::where('title', 'LIKE', '%' . $request->query . '%')
                ->orWhere('content', 'LIKE', '%' . $request->query . '%')
                ->paginate(5);

    return view('blogs.index', compact('blogs'));
}


public function share($id, Request $request)
{
    $request->validate([
        'email' => 'required|email',
    ]);

    $blog = Blog::findOrFail($id);
    Mail::to($request->email)->send(new BlogShareMail($blog));

    return redirect()->route('blogs.show', $id)->with('success', 'Blog shared successfully');
}


}

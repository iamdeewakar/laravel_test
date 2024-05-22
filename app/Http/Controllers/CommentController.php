<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommentController extends Controller
{
    //

    public function store(Request $request, $blogId)
    {
        $request->validate([
            'content' => 'required',
        ]);

        Comment::create([
            'blog_id' => $blogId,
            'user_id' => Auth::id(),
            'content' => $request->content,
        ]);

        return redirect()->route('blogs.show', $blogId);
    }

    public function like($commentId)
    {
        $comment = Comment::findOrFail($commentId);
        $comment->likes_count += 1;
        $comment->save();

        return redirect()->back();
    }
}

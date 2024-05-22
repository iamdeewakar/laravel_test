<!-- resources/views/blogs/show.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $blog->title }}</h1>
        <p>{{ $blog->content }}</p>
        <hr>
        <h3>Comments</h3>
        @foreach ($blog->comments as $comment)
            <div class="card mb-3">
                <div class="card-body">
                    <p>{{ $comment->content }}</p>
                    <p>Likes: {{ $comment->likes_count }}</p>
                </div>
            </div>
        @endforeach
    </div>
@endsection

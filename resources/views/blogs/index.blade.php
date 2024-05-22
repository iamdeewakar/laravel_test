<!-- resources/views/blogs/index.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Blogs</h1>
        @foreach ($blogs as $blog)
            <div class="card mb-3">
                <div class="card-body">
                    <h2>{{ $blog->title }}</h2>
                    <p>{{ Str::limit($blog->content, 150) }}</p>
                    <a href="{{ route('blogs.show', $blog->id) }}" class="btn btn-primary">Read More</a>
                </div>
            </div>
        @endforeach
        {{ $blogs->links() }}
    </div>
@endsection

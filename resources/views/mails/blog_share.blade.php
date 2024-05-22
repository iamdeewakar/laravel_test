<!-- resources/views/emails/blog_share.blade.php -->
<p>Hi,</p>
<p>Check out this blog: <a href="{{ route('blogs.show', $blog->id) }}">{{ $blog->title }}</a></p>
<p>{{ $blog->content }}</p>

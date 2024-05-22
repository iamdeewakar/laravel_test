<!-- resources/views/blogs/show.blade.php -->
<form action="{{ route('blogs.share', $blog->id) }}" method="POST">
    @csrf
    <div class="form-group">
        <label for="email">Share via Email</label>
        <input type="email" name="email" id="email" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Share</button>
</form>

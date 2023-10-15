<div>
    <div class="input-group mb-3">
        <input type="text"  class="form-control commentForm" placeholder="Add a Comment"  aria-describedby="postComment">
        <span  class="btn  postComment btn-primary">Post</span>
      </div>
</div>
<div>
    @forelse ($comments as $comment)
    <div class="bg-dark-subtle p-2">
        <a class="text-decoration-none">{{$comment->user->name}}</a>
        <div class="my-2">{!!$comment->body!!}</div>
        <div class="text-body-secondary text-end">{{ $comment->created_at->format('Y-m-d H:i:s') }}</div>
    </div>
    @empty
        <p class="text-center text-muted">Be your first comment</p>
    @endforelse

</div>

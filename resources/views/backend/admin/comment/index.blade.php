<?php $count_item = 1; ?>
<table class="table">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Feed Back Title</th>
        <th scope="col">User Name</th>
        <th scope="col">Comment</th>
        <th scope="col">Action</th>
      </tr>
    </thead>
    <tbody class="table-group-divider">
    <?php $count_index=1 ?>

    @foreach ($comments as $comment)
        <tr class="comment{{$comment->id}}">
            <th scope="row">{{$count_index}}</th>
            <td>{{$comment->feedback->title}}</td>
            <td>{{$comment->user->name}}</td>
            <td>{!!$comment->body!!}</td>
            <td>
                <a href="" class="btn btn-danger delete-comment" data-id-comment="{{$comment->id}}" >Delete</a>
                <a href="" class="btn btn-warning update-comment" data-id-comment="{{$comment->id}}"   data-comment="{!!$comment->body!!}">Update</a>
            </td>
        </tr>
        <?php ++$count_index?>
    @endforeach

    </tbody>
  </table>

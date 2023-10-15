<table class="table">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Title</th>
        <th scope="col">Description</th>
        <th scope="col">Category</th>
        <th scope="col">Image</th>
        <th scope="col">User Name</th>
        <th scope="col">Action</th>
      </tr>
    </thead>
    <tbody class="table-group-divider">
    <?php $count_index=1 ?>
    @foreach ($feedbacks as $feedback)
        <tr class="feedBack{{$feedback->id}}">
            <th scope="row">{{$count_index}}</th>
            <td>{{$feedback->title}}</td>
            <td>{{$feedback->description}}</td>
            <td>{{$feedback->category->body}}</td>
            <td><img src="@isset($feedback->image) {{asset($feedback->image)}} @else{{asset('images/loader/no image.jpg')}} @endisset" alt="" style="width: 88px;"></td>
            <td>{{$feedback->user->name}}</td>
            <td>
                <a  class="btn btn-danger" onclick="deleteFeedBack(this);event.preventDefault();" data-feedback-id={{$feedback->id}}>Delete</a>
                <a  class="btn btn-warning feed-update" type="button" data-bs-toggle="modal" data-bs-target="#feedBackModal" data-title="{{$feedback->title}}" data-description="{{$feedback->description}}" data-feedback-id="{{$feedback->id}}" data-category="{{$feedback->category->id}}" >Update</a>
            </td>
        </tr>
    <?php $count_index++ ?>

    @endforeach

    </tbody>
  </table>

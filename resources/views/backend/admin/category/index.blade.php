<table class="table">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Category Name</th>
        <th scope="col">Action</th>
      </tr>
    </thead>
    <tbody class="table-group-divider ">
    <?php $count_index=1 ?>
        @foreach ($categories as $category)
            <tr class="category{{$category->id}}">
                <th scope="row">{{$count_index}}</th>
                <td>{{$category->body}}</td>
                <td>
                    <a  class="btn btn-danger delete-category" onclick="deleteCategory(this); event.preventDefault();" data-category-id={{$category->id}}>Delete</a>
                    <a href="#" class="btn btn-warning update-category" data-category-id={{$category->id}} data-category="{{$category->body}}" >Update</a>
                </td>
            </tr>
    <?php $count_index++ ?>

        @endforeach
    </tbody>
  </table>



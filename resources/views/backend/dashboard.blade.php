@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-2">

        <div class="list-group" id="list-tab" role="tablist">
            <a class="list-group-item list-group-item-action active" id="list-comment-list" data-bs-toggle="list" href="#list-comment" role="tab" aria-controls="list-comment">Comments Management</a>
            <a class="list-group-item list-group-item-action" id="list-profile-list" data-bs-toggle="list" href="#list-profile" role="tab" aria-controls="list-profile">Feedback Lists</a>
            <a class="list-group-item list-group-item-action" id="list-category-list" data-bs-toggle="list" href="#list-category" role="tab" aria-controls="list-category">Category Management</a>
        </div>

        </div>
        <div class="col-10">
            <div class="tab-content" id="nav-tabContent">
                <p><button class="btn btn-primary d-none" type="button" id="commentbtn" data-bs-toggle="modal" data-bs-target="#commentModal">Add Category</button></p>
                <div class="tab-pane fade show active" id="list-comment" role="tabpanel" aria-labelledby="list-comment-list">
                    @include('backend.admin.comment.index')
                </div>

                <div class="tab-pane fade" id="list-profile" role="tabpanel" aria-labelledby="list-profile-list">
                    <div id="feeBackTable">
                        @include('backend.admin.feedback.index')
                    </div>
                </div>

                <div class="tab-pane fade" id="list-category" role="tabpanel" aria-labelledby="list-category-list">
                    <p><button class="btn btn-primary" type="button" onclick="$('.error-tag').addClass('d-none')" data-bs-toggle="modal" data-bs-target="#categoryModal">Add Category</button></p>
                    <div id="categoryTable">
                        @include('backend.admin.category.index')
                   </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal for Add category  --}}
<div class="modal fade " id="categoryModal" tabindex="-1" aria-labelledby="categoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="categoryModalLabel">Add Category</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form id="categoryForm" name="categoryName">
                <div class="input-group mb-3">
                    <span class="input-group-text fw-bold" id="basic-addon1">Category</span>
                    <input type="text" class="form-control" name="body" placeholder="Category" aria-label="Username" aria-describedby="basic-addon1">
                </div>
                <p class="text-danger fw-bold mb-2 body error-tag d-none">Invalid Title</p>
                <div>
                    <input type="submit" value="Add Category" id="add-category" class="btn btn-primary">
                </div>
            </form>
        </div>
      </div>
    </div>
  </div>

  {{-- comment --}}
  <div class="modal fade " id="commentModal" tabindex="-1" aria-labelledby="commentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="commentModalLabel">Update Comment</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form id="commentForm" name="commentName">
                <div class="input-group mb-3">
                    <span class="input-group-text fw-bold cc-name" id="basic-addon1">Comment</span>
                    <input type="text" class="form-control" id="comment_input" name="comment" placeholder="comment" aria-label="Username" aria-describedby="basic-addon1">
                    <input type="text" name="commentId" id="commentId" class="d-none">
                </div>
                <p class="text-danger fw-bold mb-2 comment error-tag d-none">Invalid Title</p>
                <div>
                    <input type="submit" value="Update Comment" id="add-comment" class="btn btn-primary">
                </div>
            </form>
        </div>
      </div>
    </div>
  </div>



  <!-- Modal feedBack Updation -->
  <div class="modal fade" id="feedBackModal" tabindex="-1" aria-labelledby="feedBackModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content" style="width: 121%;">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="feedBackModalLabel">Modal title</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            @include('partials.feedback.form',['btnValue'=>"Update Data"])
        </div>
      </div>
    </div>
  </div>
@endsection

@section('javaScript')

<script>


    // Category Management
    $(document).ready(function(){
        $(document).on('click','#add-category',function(e){
            e.preventDefault();
            var seriArray = $("#categoryForm").serializeArray();
            var categoryData = array_to_object(seriArray);

            $.ajax({
                    url: '{{route("store.category")}}',
                    method: 'POST',
                    data: categoryData,
                    success: function(data) {
                        toaster_on(data.category);
                        setTimeout(function(){
                            toaster_off(),
                            show_category();
                        },1500);

                        $('#categoryForm').trigger('reset');

                    },
                    error: function(data) {
                        $(".error-tag").addClass("d-none");
                        $.each(data.responseJSON, function(key, value) {
                        $('.'+ key).removeClass("d-none").empty().html(value[0]);
                        });
                    }
            });
        })
    });

    // Deleting Category
    function deleteCategory(deleteCategory)
    {
            var deleteId = $(deleteCategory).attr('data-category-id');
            loader_on();
            $.ajax({
                    url: '{{route("delete.category")}}',
                    method: 'delete',
                    data: {
                        categoryId:deleteId
                    },
                    success: function(data) {
                        $('.category'+deleteId).remove();
                        loader_off();
                    },

                    error: function(data) {
                        $(".error-tag").addClass("d-none");
                        $.each(data.responseJSON, function(key, value) {
                        $('.'+ key).removeClass("d-none").empty().html(value[0]);
                        });
                    }
            });
    }


    // update Category

    $(document).ready(function(){
       $(document).on('click','.update-category',function(e){
            e.preventDefault();
            var categoryUpdate =$(this).attr('data-category');
            var categorytid =  $(this).attr('data-category-id');
            var updateComment = reverseFormatComments(categoryUpdate);

            $('#comment_input').val(updateComment).attr('name','category');
            $('#commentId').val(categorytid).attr('name','categoryId');

            $('#commentModalLabel').html("Update Category");
            $('.cc-name').html('Category');
            $('#add-comment').val('Update Category');
            $('#add-comment').attr('id','update-Category');

            $('#commentbtn').click();
       });
    });

    // Update Category
    $(document).ready(function(){
        $(document).on('click','#update-Category',function(e){
            e.preventDefault();
            var seriArray = $('#commentForm').serializeArray();
            var commentData = array_to_object(seriArray);
            loader_on();
            $.ajax({
                    url: '{{route("update.category")}}',
                    method: 'patch',
                    data: commentData,
                    success: function(data) {
                        loader_off();
                        $('.btn-close').click();
                        $('#categoryTable').empty().html(data);
                    },

                    error: function(data) {
                        $(".error-tag").addClass("d-none");
                        $.each(data.responseJSON, function(key, value) {
                        $('.'+ key).removeClass("d-none").empty().html(value[0]);
                        });
                    }
            });

        })
    });


    function show_category(){
        $.ajax({
            type:"GET",
            url:"{{ route('show.category') }}",
            success:function(data)
            {
                $('#categoryTable').empty().html(data);
            },
            error:function(data)
            {

            }
        });
    }

    // Comment Management
    $(document).ready(function(){
       $(document).on('click','.update-comment',function(e){
            e.preventDefault();
            var commentUpdate = $(this).attr('data-comment');
            var commentid = $(this).attr('data-id-comment');
            var updateComment = reverseFormatComments(commentUpdate);
            $('#comment_input').val(updateComment);
            $('#commentId').val(commentid);
            $('#commentbtn').click();
       })
    });

    // Updatin The record
    $(document).ready(function(){
        $(document).on('click','#add-comment',function(e){
            e.preventDefault();
            var seriArray = $('#commentForm').serializeArray();
            var commentData = array_to_object(seriArray);
            commentData.comment = formatComments(commentData.comment);
            loader_on();
            $.ajax({
                    url: '{{route("update.comment")}}',
                    method: 'patch',
                    data: commentData,
                    success: function(data) {
                        loader_off();
                        $('.btn-close').click();
                        $('#list-comment').empty().html(data);
                    },

                    error: function(data) {
                        $(".error-tag").addClass("d-none");
                        $.each(data.responseJSON, function(key, value) {
                        $('.'+ key).removeClass("d-none").empty().html(value[0]);
                        });
                    }
            });

        })
    });

    // For Deleting The Record
    $(document).ready(function(){
        $(document).on('click','.delete-comment',function(e){
            e.preventDefault();
            var commentId = $(this).attr('data-id-comment');
            loader_on();
            $.ajax({
                    url: '{{route("delete.comment")}}',
                    method: 'delete',
                    data: {
                        deleteCommentId:commentId
                    },
                    success: function(data) {
                        loader_off();
                        $('.comment'+commentId).remove();
                        $('.btn-close').click();
                    },

                    error: function(data) {
                        $(".error-tag").addClass("d-none");
                        $.each(data.responseJSON, function(key, value) {
                        $('.'+ key).removeClass("d-none").empty().html(value[0]);
                        });
                    }
            });
        });
    })
    // feed Back Management
    // Showing Update items
    $(document).ready(function(){
        $(document).on('click','.feed-update',function(){
                $('.error-tag').addClass('d-none');
                var title = $(this).attr('data-title');
                var description = $(this).attr('data-description');
                var category = $(this).attr('data-category');
                var feedback_id = $(this).attr('data-feedback-id');
                var feedBackInput = $(`<input type="text" title="u_feedback_id" name="feedback_id" value=${feedback_id}>`);
                $('#title').append(feedBackInput);
                $('#description').html(description);
                $('#title').val(title);
                $(`#categoryOption option[value=${category}]`).attr("selected", "selected");
        })
    })

    // updating feedback
    $(document).ready(function(){
        $(document).on('click','#submit-report',function(e){
            e.preventDefault();


                var form = $('#myForm')[0];
                var formData = new FormData(form);

                var type = "POST";
                var ajaxurl = "{{ route('update.feed') }}";

                $.ajax({
                    type: type,
                    url: ajaxurl,
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        // toaster_on(data.message);
                        // const myTimeout = setTimeout(toaster_off,1500);

                        $('.btn-close').click();
                        $("#myForm").trigger("reset");
                        $('.error-tag').addClass('d-none');
                        $('#feeBackTable').empty().html(data);
                    },

                    error: function(data) {
                        $(".error-tag").addClass("d-none");
                        $.each(data.responseJSON, function(key, value) {
                        $('.'+ key).removeClass("d-none").empty().html(value[0]);
                        });
                    }
                });
        })
    })
    // Deleting The Record
    function deleteFeedBack(deleFeedBack)
    {
        var deleteId = $(deleFeedBack).attr('data-feedback-id');
        loader_on();
        $.ajax({
                url: '{{route("feed.delete")}}',
                method: 'delete',
                data: {
                    feedBackId:deleteId
                },
                success: function(data) {
                    $('.feedBack'+deleteId).remove();
                    loader_off();
                },

                error: function(data) {
                    $(".error-tag").addClass("d-none");
                    $.each(data.responseJSON, function(key, value) {
                    $('.'+ key).removeClass("d-none").empty().html(value[0]);
                    });
                }
        });
    }
</script>

@endsection

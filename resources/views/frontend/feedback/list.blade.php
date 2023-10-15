@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <form action="" id="filter" name="filter">
            <div class="row justify-content-center">
                <div class="col-3">
                        <div class="input-group mb-3">
                            <label class="input-group-text" for="inputGroupSelect01">Sorting</label>
                            <select class="form-select" name="sort" id="inputGroupSelect01">
                            <option value="" >Choose...</option>
                            <option value="asc" {{ old('asc') == 'asc' ? 'selected' : '' }}>Ascending Order</option>
                            <option value="desc" {{ old('desc') == 'asc' ? 'selected' : '' }}>Descending Order</option>
                            </select>
                        </div>
                </div>
                <div class="col-3">
                    <div class="input-group mb-3">
                        <label class="input-group-text" for="inputGroupSelect01">Category</label>
                        <select class="form-select" name="category_id" id="inputGroupSelect01">
                            <option value="" >Choose...</option>
                            @foreach ($categories as $category)
                                <option value="{{$category->id}}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{$category->body}}</option>
                            @endforeach>
                        </select>
                    </div>
                </div>
                <div class="col-1">
                    <button class="btn btn-primary" id="filter-btn">Filter</button>
                </div>
            </div>
        </form>

        <div id="feedList">
            @include('frontend.feedback.partials.list')
        </div>

    </div>
@endsection

@section('javaScript')
   <script>
     // for showing comment

     function showComment(showComment)
     {
            var feedback_id = $(showComment).attr('data-feedbackid');
            var commentIndex = $('.commentIcon').index(showComment);

            $('.commentShow').addClass('d-none');
            loader_on();
            // For getting comment pages
            $.ajax({
                    type:"GET",
                    url: "{{route('show.comment')}}",
                    data : {
                        feedback_id: feedback_id
                    },
                    success:function(data)
                    {
                        loader_off();
                        $('.commentShow').eq(commentIndex).empty().removeClass('d-none').html(data);
                        $('.postComment').attr('feedback_id',feedback_id);
                        $('.postComment').attr('PostIndex',commentIndex);
                    }
            });
     }


    // Posting the  Comment

    $(document).ready(function(){
        $(document).on('click','.postComment',function(){

            var postIndex = $(this).attr('PostIndex');
            var postComment =  $('.postComment').index(this);

            var feedback_id = $(this).attr('feedback_id');
            var commentInput = $('.commentForm').eq(postComment).val();

            var markdownComment = formatComments(commentInput);
            var commentobject = {
                body : markdownComment,
                feedback_id : feedback_id
            };
            loader_on();
            $.ajax({
                    url: '{{route("store.comment")}}',
                    method: 'POST',
                    data: commentobject,
                    success: function(data) {
                        loader_off();
                        $('.commentShow').eq(postIndex).empty().removeClass('d-none').html(data);
                        $('.postComment').attr('feedback_id',feedback_id);
                        $('.postComment').attr('PostIndex',postIndex);
                    },
                    error: function(error) {
                        toaster_on(error.responseJSON);
                    }
            });
        });
    })

    // Vote Management

    function voteCount(voteCount)
    {
        var thumbVote = $(voteCount).attr('data-value');
            var feedback_id = $(voteCount).attr('data-feedbackid');
            var feedback_id_count = $(voteCount).attr('data-feeedbackidcount');
            var postData= {
                currentVote: thumbVote,
                feedBackId: feedback_id
            };

            $.ajax({
                type: "POST",
                url: "{{route('store.vote')}}",
                data: postData,
                success: function(data) {
                    var t_index = (data.voteId.value==1) ? 0 : 1;
                    var feedback_id = data.voteId.feedback_id
                    // for counting vote
                    $('.voteCount').eq(feedback_id_count).removeClass('d-none').html(data.voteCount);
                    $(".feedback"+feedback_id).find(".thumb").eq(t_index).removeClass('text-light').addClass('text-dark');
                },
                error: function(error) {
                    toaster_on(error.responseJSON.message);
                    setTimeout(toaster_off,1500);
                }
            });
    }



    function voteMark()
    {
        $.ajax({
                url: '{{route("feed.list")}}',
                method: 'GET',
                success: function(data) {

                    loader_off();
                },
                error: function(error) {
                    loader_off();
                    $('#feedList').empty().html(`<div class="text-center display-1 fw-bold m-5">${error.responseJSON.category}</div>`);
                }
            });
    }

    // filter Management

    $(document).ready(function(){
        $(document).on('click','#filter-btn',function(e){
            e.preventDefault();

           var seriArray = $("#filter").serializeArray();
           var filterData = array_to_object(seriArray);
           loader_on();
            $.ajax({
                    url: '{{route("feed.list")}}',
                    method: 'GET',
                    data: filterData,
                    success: function(data) {
                        $('#feedList').empty().html(data);
                        loader_off();
                    },
                    error: function(error) {
                        loader_off();
                        $('#feedList').empty().html(`<div class="text-center display-1 fw-bold m-5">${error.responseJSON.category}</div>`);
                    }
            });
        });
    });


   </script>

@endsection



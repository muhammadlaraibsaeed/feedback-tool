@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-2">
        <div class="list-group" id="list-tab" role="tablist">
            <a class="list-group-item list-group-item-action active" id="list-home-list" data-bs-toggle="list" href="#list-home" role="tab" aria-controls="list-home">Profile</a>
            <a class="list-group-item list-group-item-action" id="list-profile-list" data-bs-toggle="list" href="#list-profile" role="tab" aria-controls="list-profile">Feedback Lists</a>
        </div>
        </div>
        <div class="col-10">
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="list-home" role="tabpanel" aria-labelledby="list-home-list">
                <p><button class="btn btn-primary" type="button"  data-bs-toggle="modal" data-bs-target="#exampleModal" id="profileEdit">Edit Profile</button></p>
                @include('frontend.user.partials.profile')
            </div>
            <div class="tab-pane fade" id="list-profile" role="tabpanel" aria-labelledby="list-profile-list">
                <div class="postNot"></div>
                @include('frontend.user.partials.feedbacklist')
            </div>
        </div>
        </div>
    </div>
</div>

{{-- for showing Profile data --}}
<!-- Button trigger modal -->

<!-- Modal -->
<div class="modal fade modal-dialog modal-dialog-centered" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Update Profile Info</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form  id="profile">
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">Name</span>
                <input type="text" class="form-control" placeholder="Username" name="name" value="{{Auth::user()->name}}" aria-label="Username" aria-describedby="basic-addon1">
            </div>

            <p class="text-danger fw-bold mb-2 error-tag name d-none"></p>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">Email</span>
                <input type="email" class="form-control" placeholder="Email" name="email" value="{{Auth::user()->email}}" aria-label="Username" aria-describedby="basic-addon1">
            </div>
            <p class="text-danger fw-bold mb-2 error-tag email d-none"></p>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">New Password</span>
                <input type="Password" class="form-control" placeholder="Password"  name="password" aria-describedby="basic-addon1">
            </div>
                <p class="text-danger fw-bold mb-2 error-tag password"></p>

        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="profile-update">Update Record</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('javaScript')

<script>

 // Edit Profile

 $(document).ready(function(){
            $(document).on('click','#profile-update',function(e){
                e.preventDefault();
                var seriArray = $('#profile').serializeArray();
                var profileData = array_to_object(seriArray);
                loader_on();
                $.ajax({
                        url: '{{route("update.user")}}',
                        method: 'post',
                        data: profileData,
                        success: function(data) {
                            loader_off();
                            $('.btn-close').click();
                            location.reload();
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




// Comment and likes and Dislike management

function showComment(showComment) {
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

$(document).ready(function () {
    $(document).on("click", ".postComment", function () {
        var postIndex = $(this).attr("PostIndex");
        var postComment = $(".postComment").index(this);

        var feedback_id = $(this).attr("feedback_id");
        var commentInput = $(".commentForm").eq(postComment).val();

        var markdownComment = formatComments(commentInput);
        var commentobject = {
            body: markdownComment,
            feedback_id: feedback_id,
        };
        loader_on();
        $.ajax({
            url: '{{route("store.comment")}}',
            method: "POST",
            data: commentobject,
            success: function (data) {
                loader_off();
                $(".commentShow")
                    .eq(postIndex)
                    .empty()
                    .html(data);
                $(".postComment").attr("feedback_id", feedback_id);
                $(".postComment").attr("PostIndex", postIndex);
            },
            error: function (error) {
                toaster_on(error.responseJSON);
            },
        });
    });
});

// Vote Management


function voteCount(voteCount) {
    var thumbVote = $(voteCount).attr("data-value");
    var feedback_id = $(voteCount).attr("data-feedbackid");
    var feedback_id_count = $(voteCount).attr('data-feeedbackidcount');

    var postData = {
        currentVote: thumbVote,
        feedBackId: feedback_id,
    };

    $.ajax({
        type: "POST",
        url: "{{route('store.vote')}}",
        data: postData,
        success: function (data) {
            var t_index = data.voteId.value == 1 ? 0 : 1;
            var feedback_id = data.voteId.feedback_id;
            // for counting vote

            $(".voteCount")
                .eq(feedback_id_count)
                .removeClass("d-none")
                .html(data.voteCount);
            $(".feedback" + feedback_id)
                .find(".thumb")
                .eq(t_index)
                .removeClass("text-light")
                .addClass("text-dark");
        },
        error: function (error) {
            toaster_on(error.responseJSON.message);
            setTimeout(toaster_off, 1500);
        },
    });
}

function voteMark() {
    $.ajax({
        url: '{{route("feed.list")}}',
        method: "GET",
        success: function (data) {
            loader_off();
        },
        error: function (error) {
            loader_off();
            $("#feedList")
                .empty()
                .html(
                    `<div class="text-center display-1 fw-bold m-5">${error.responseJSON.category}</div>`
                );
        },
    });
}

</script>

@endsection

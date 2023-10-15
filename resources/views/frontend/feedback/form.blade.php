@extends('layouts.app')

@section('content')
    <div class="container">
        @include('partials.feedback.form',['btnValue'=>'Submit Report'])
        <p class="text-end"><a href="{{route('feed.list')}}" class="text-decoration-none">View Feedback list</a></p>
    </div>
@endsection

@section('javaScript')
    <script>
        $(document).ready(function () {
            $("#submit-report").click(function (e) {
                e.preventDefault();

                var form = $('#myForm')[0];
                var formData = new FormData(form);

                var state = $('#btn-save').val();
                var type = "POST";
                var ajaxurl = "{{ route('feed.store') }}";

                $.ajax({
                    type: type,
                    url: ajaxurl,
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        toaster_on(data.message);
                        const myTimeout = setTimeout(toaster_off,1500);
                        $("#myForm").trigger("reset");
                        $('.error-tag').addClass('d-none');
                    },

                    error: function(data) {
                        $(".error-tag").addClass("d-none");
                        $.each(data.responseJSON, function(key, value) {
                        $('.'+ key).removeClass("d-none").empty().html(value[0]);
                        });
                    }
                });
            });
        });
    </script>
@endsection

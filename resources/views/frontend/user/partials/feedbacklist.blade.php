<div class="row justify-content-center">
    <?php
        $feedback_count = 0;
        $value_index = 0;
    ?>
        <div class="col-6 mt-3">
        @forelse ($feedBacks as $feedBack)
                <div class="card mt-3">
                    <div class="card-body px-1 py-1 ">
                        <h5 class="card-title">{{$feedBack->title}}</h5>
                        <p class="card-text">{{$feedBack->description}}</p>
                        <div class="d-flex justify-content-around bg-info rounded my-1">
                            <div>Submit BY</div>
                            <div>{{$feedBack->user->name}}</div>
                        </div>
                            @isset($feedBack->image)
                                    <img src="{{ asset($feedBack->image)}}" class="card-img-bottom" alt="...">
                            @endisset
                        {{-- Total votes --}}
                        <div class="d-flex justify-content-between bg-info p-2 rounded m-1 fw-bold">
                            <div>
                                Category
                            </div>
                            <div >
                                {{$feedBack->category->body}}
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary position-relative my-3">
                            Total Votes
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill voteCount bg-danger @if ($feedBack->votes_count == 0) d-none @endif" >
                                {{$feedBack->votes_count}}
                            </span>
                        </button>

                        <div class="rounded my-2 p-2 bg-info d-flex justify-content-around feedback{{$feedBack->id}} ">
                            <div>

                                <i class="bi bi-hand-thumbs-up-fill
                                @isset($co_votes)
                                    @foreach($co_votes as $co_vote)
                                        @if($co_vote->value == 1 && $feedBack->id == $co_vote->feedback_id )
                                            text-dark
                                        @endif
                                    @endforeach
                                @endisset text-light thumb" onclick="voteCount(this)" data-feeedbackidcount={{$feedback_count}} data-value="1" data-feedbackid="{{$feedBack->id}}" style="cursor: pointer;"></i>
                            </div>
                            <div class="commentIcon" onclick="showComment(this)" data-feedbackid="{{$feedBack->id}}">
                                <i class="bi bi-chat-fill text-white"    style="cursor: pointer;"></i>
                            </div>
                            <div>
                                <i class="bi bi-hand-thumbs-down-fill
                                @isset($co_votes)
                                    @foreach($co_votes as $co_vote)
                                        @if($co_vote->value == 2 && $feedBack->id == $co_vote->feedback_id )
                                            text-dark
                                        @endif
                                    @endforeach
                                @endisset text-light thumb" onclick="voteCount(this)" data-feeedbackidcount={{$feedback_count}} data-value="2" data-feedbackid="{{$feedBack->id}}" style="cursor: pointer;"></i>
                            </div>
                        </div>

                        {{-- comment section --}}
                        <div class="commentShow">
                        </div>
                    </div>
                </div>
        <?php ++$feedback_count ?>

                @empty
                <h1 class="text-center">Don't Post Yet</h1>
        @endforelse
            </div>
</div>


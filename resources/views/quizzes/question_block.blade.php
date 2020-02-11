@foreach($questions as $index => $question)
<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-content" style="background-color:#dbe0d6;border-radius:5px">

                <form class="wizard-big added" method="POST" action="{{ route('quizzes.questions.update', ['quiz' => $question->quiz_id, 'question' => $question->id]) }}">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    <fieldset>
                    <div class="row" style="
                        position: absolute;
                        right: 4%;
                    ">
                        <a href="{{ route('quizzes.questions.edit', ['quiz' => $question->quiz_id, 'question' => $question->id]) }}" class="btn btn-sm btn-warning edit" type="button" style="display:none;">Edit</a>
                    </div>
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="form-group">
                                    <label>Question {{ ++$index }}</label>
                                    <input readonly value="{{ $question->question }}" id="question" name="question" type="text" class="form-control required">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>
                                        <div class="i-checks">
                                            <label>
                                                <input disabled type="radio" value="0" name="correct" data-option="0"
                                                    @if($question->answers[0]->is_right == 1) checked @endif
                                                >
                                                <i>

                                                </i>
                                            </label>
                                        </div>
                                        First Option *
                                    </label>
                                    <input readonly id="name" name="answers[0][answer]" type="text" class="form-control required">
                                </div>
                                <div class="form-group">
                                    <label>
                                        <div class="i-checks">
                                            <label>
                                                <input disabled type="radio" value="2" name="correct" data-option="1"
                                                    @if(isset($question->answers[2]) && $question->answers[2]->is_right == 1) checked @endif
                                                >
                                                <i>
                                                </i>
                                            </label>
                                        </div>
                                        Third Option *
                                    </label>
                                    <input readonly id="surname" name="answers[2][answer]" type="text" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>
                                        <div class="i-checks">
                                            <label>
                                                <input disabled type="radio" value="1" name="correct" data-option="2"
                                                    @if($question->answers[1]->is_right == 1) checked @endif
                                                >
                                                <i>

                                                </i>
                                            </label>
                                        </div>
                                        Second Option *
                                    </label>
                                    <input readonly id="email" name="answers[1][answer]" type="text" class="form-control required">
                                </div>
                                <div class="form-group">
                                    <label>
                                        <div class="i-checks">
                                            <label>
                                                <input disabled type="radio" value="3" name="correct" data-option="3"
                                                    @if(isset($question->answers[3]) && $question->answers[3]->is_right == 1) checked @endif
                                                >
                                                <i>

                                                </i>
                                            </label>
                                        </div>
                                        Fourth Option *
                                    </label>
                                    <input readonly id="address" name="answers[3][answer]" type="text" class="form-control">
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>

</div>
@endforeach
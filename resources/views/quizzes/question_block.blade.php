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
                        <button class="btn btn-sm btn-warning edit" type="button" style="display:none;">Edit</button>
                    </div>
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="form-group">
                                    <label>Question {{ ++$index }}</label>
                                    <input value="{{ $question->question }}" id="question" name="question" type="text" class="form-control required">
                                </div>
                            </div>
                        </div>
                        <div class="alert alert-danger alert-dismissable pace-inactive">
                            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                            Please select correct answer.
                        </div>
                        <small>Please mark the circle with the correct option</small>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>
                                        <div class="i-checks">
                                            <label>
                                                <input type="radio" value="0" name="correct" data-option="0">
                                                <i>

                                                </i>
                                            </label>
                                        </div>
                                        First Option *
                                    </label>
                                    <input id="name" name="answers[0][answer]" type="text" class="form-control required">
                                </div>
                                <div class="form-group">
                                    <label>
                                        <div class="i-checks">
                                            <label>
                                                <input type="radio" value="2" name="correct" data-option="1">
                                                <i>
                                                </i>
                                            </label>
                                        </div>
                                        Third Option *
                                    </label>
                                    <input id="surname" name="answers[2][answer]" type="text" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>
                                        <div class="i-checks">
                                            <label>
                                                <input type="radio" value="1" name="correct" data-option="2">
                                                <i>

                                                </i>
                                            </label>
                                        </div>
                                        Second Option *
                                    </label>
                                    <input id="email" name="answers[1][answer]" type="text" class="form-control required">
                                </div>
                                <div class="form-group">
                                    <label>
                                        <div class="i-checks">
                                            <label>
                                                <input type="radio" value="3" name="correct" data-option="3">
                                                <i>

                                                </i>
                                            </label>
                                        </div>
                                        Fourth Option *
                                    </label>
                                    <input id="address" name="answers[3][answer]" type="text" class="form-control">
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <button type="submit" class="btn btn-primary" style="display:none">Update</button>
                </form>
            </div>
        </div>
    </div>

</div>
@endforeach
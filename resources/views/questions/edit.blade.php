@extends('layouts.app')

@section('title') Add Question @endsection

@section('css')

<link href="{{ url('css/plugins/iCheck/custom.css') }}" rel="stylesheet">
<link href="{{ url('css/plugins/steps/jquery.steps.css') }}" rel="stylesheet">
<link href="{{ url('/css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css') }}" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/css/bootstrap-multiselect.css" type="text/css"/>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <a href="javascript:history.go(-1)" class="btn btn-primary">Go Back</a>
        <h2>Update Question Details</h2>
        <div class="ibox">
            <div class="ibox-content" style="background-color:#dbe0d6;border-radius:5px">
                <form id="form" class="wizard-big" method="POST" action="{{ route('questions.update', ['question' => $question->id]) }}">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    <h1>Question</h1>
                    <fieldset>
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="form-group @error('question_category_id') has-error @enderror">
                                    <label>Category</label>
                                    <select multiple="multiple" class="multiselect form-control" name="question_category_id[]">
                                        <option value="">Select Categories</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}"
                                                    @if($question->category_ids->search($category->id) !== false) selected @endif>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('question_category_id')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="form-group">
                                    <label>Question *</label>
                                    <input id="question" name="question" type="text" class="form-control required" value="{{ $question->question }}">
                                </div>
                            </div>
                        </div>
                    <h1>Answers</h1>
                        <h2>Answers Information</h2>
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
                                                <input type="radio" value="0" name="correct" data-option="0"
                                                    @if($question->answers[0]->is_right == 1) checked @endif
                                                >
                                                <i>

                                                </i>
                                            </label>
                                        </div>
                                        First Option *
                                    </label>
                                    <input type="hidden" name="answers[0][answer_id]" value=@if(isset($question->answers[0])){{ $question->answers[0]->id }} @endif>
                                    <input id="name" name="answers[0][answer]" type="text" class="form-control required"
                                        value="{{ $question->answers[0]->answer }}"
                                    >
                                </div>
                                <div class="form-group">
                                    <label>
                                        <div class="i-checks">
                                            <label>
                                                <input type="radio" value="2" name="correct" data-option="1"
                                                @if(isset($question->answers[2]) && $question->answers[2]->is_right == 1) checked @endif
                                                >
                                                <i>
                                                </i>
                                            </label>
                                        </div>
                                        Third Option *
                                    </label>
                                    <input type="hidden" name="answers[2][answer_id]" value=@if(isset($question->answers[2])){{ $question->answers[2]->id }} @endif>
                                    <input id="surname" name="answers[2][answer]" type="text" class="form-control"
                                         value=@if(isset($question->answers[2])){{ $question->answers[2]->answer }} @endif
                                    >
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>
                                        <div class="i-checks">
                                            <label>
                                                <input type="radio" value="1" name="correct" data-option="2"
                                                @if($question->answers[1]->is_right == 1) checked @endif
                                                >
                                                <i>

                                                </i>
                                            </label>
                                        </div>
                                        Second Option *
                                    </label>
                                    <input type="hidden" name="answers[1][answer_id]" value=@if(isset($question->answers[1])){{ $question->answers[1]->id }} @endif>
                                    <input id="email" name="answers[1][answer]" type="text" class="form-control required"
                                        value="{{ $question->answers[1]->answer }}"
                                    >
                                </div>
                                <div class="form-group">
                                    <label>
                                        <div class="i-checks">
                                            <label>
                                                <input type="radio" value="3" name="correct" data-option="3"
                                                @if(isset($question->answers[3]) && $question->answers[3]->is_right == 1) checked @endif
                                                >
                                                <i>

                                                </i>
                                            </label>
                                        </div>
                                        Fourth Option *
                                    </label>
                                    <input type="hidden" name="answers[3][answer_id]" value=@if(isset($question->answers[3])){{ $question->answers[3]->id }} @endif>
                                    <input id="address" name="answers[3][answer]" type="text" class="form-control"
                                    value=@if(isset($question->answers[3])){{ $question->answers[3]->answer }} @endif
                                    >
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>

</div>
</div>
@endsection

@section('script_files')

<!-- Mainly scripts -->
<script src="{{ url('js/jquery-2.1.1.js') }}"></script>
<script src="{{ url('js/bootstrap.min.js') }}"></script>
<script src="{{ url('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
<script src="{{ url('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

<!-- Custom and plugin javascript -->
<script src="{{ url('js/inspinia.js') }}"></script>
<script src="{{ url('js/plugins/pace/pace.min.js') }}"></script>

<!-- Steps -->
<script src="{{ url('js/plugins/staps/jquery.steps.min.js') }}"></script>

<!-- Jquery Validate -->
<script src="{{ url('js/plugins/validate/jquery.validate.min.js') }}"></script>
<!-- iCheck -->
<script src="{{ url('/js/plugins/iCheck/icheck.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/js/bootstrap-multiselect.min.js"></script>
@endsection
@section('script_code')


<script>
    $(document).ready(function() {
        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        });
        $('.multiselect').multiselect();
    });
</script>
@endsection

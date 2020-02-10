@extends('layouts.app')

@section('title') Categories @endsection

@section('css')
<link href="{{ url('css/plugins/dataTables/datatables.min.css') }}" rel="stylesheet">
@endsection

@section('content')

<div class="row">
    <a href="{{ route('quizzes.index') }}" class="btn btn-success btn-lg">All Quizzes</a>
    <h1>All Questions</h1>
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover dataTables-example dataTable" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info" role="grid">
            <thead>
                <tr role="row">
                    <th>ID</th>
                    <th>Question</th>
                    <th>Is Active?</th>
                    <th>Number of Options</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($questions as $question)
                <tr class="gradeA">
                    <td>{{ $question->id }}</td>
                    <td>{{ $question->question }}</td>
                    <td>{{ $question->is_active === 1 ? 'Yes' : 'No' }}</td>
                    <td>{{ $question->answers_count }}</td>
                    <td class="center">
                        <a href="{{ route('quizzes.questions.create', [ 'quiz' => $quiz->id ]) }}" class="btn btn-primary dim" >
                            <i class="fa fa-edit"></i>
                        </a>
                        
                        <form id="delete_form" action="{{ route('quizzes.questions.destroy', [ 'quiz' => $quiz->id, 'question' => $question->id ]) }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                        </form>
                        <a class="btn btn-danger dim" onclick="event.preventDefault(); document.getElementById('delete_form').submit();">
                            <i class="fa fa-trash"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection

@section('script_files')

<!-- Mainly scripts -->
<script src="{{ url('/js/jquery-2.1.1.js') }}"></script>
<script src="{{ url('/js/bootstrap.min.js') }}"></script>
<script src="{{ url('/js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
<script src="{{ url('/js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
<script src="{{ url('/js/plugins/jeditable/jquery.jeditable.js') }}"></script>

<script src="{{ url('/js/plugins/dataTables/datatables.min.js') }}"></script>

<!-- Custom and plugin javascript -->
<script src="{{ url('/js/inspinia.js') }}"></script>
<script src="{{ url('/js/plugins/pace/pace.min.js') }}"></script>

@endsection

@section('script_code')

<script>
    $(document).ready(function() {
        $('#DataTables_Table_0').DataTable({
            dom: '<"html5buttons"B>lTfgitp',
            buttons: [{
                    extend: 'copy'
                },
                {
                    extend: 'excel',
                    title: 'Categories'
                },
                {
                    extend: 'pdf',
                    title: 'Categories'
                },
                {
                    extend: 'print',
                    customize: function(win) {
                        $(win.document.body).addClass('white-bg');
                        $(win.document.body).css('font-size', '10px');

                        $(win.document.body).find('table')
                            .addClass('compact')
                            .css('font-size', 'inherit');
                    }
                }
            ]

        });


    });
</script>
@endsection
</body>

</html>

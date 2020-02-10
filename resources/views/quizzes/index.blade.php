@extends('layouts.app')

@section('title') Quizzes @endsection

@section('css')
<link href="css/plugins/dataTables/datatables.min.css" rel="stylesheet">
<link href="{{ url('css/plugins/sweetalert/sweetalert.css')  }}" rel="stylesheet">
@endsection

@section('content')

<div class="row">
    <a href="{{ route('quizzes.create') }}" class="btn btn-success btn-lg">Add New Quiz</a>
    <h1>All Quizzes</h1>
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover dataTables-example dataTable" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info" role="grid">
            <thead>
                <tr role="row">
                    <th>ID</th>
                    <th>Name</th>
                    <th>Total Questions</th>
                    <th>Questions Added</th>
                    <th>Is Active?</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($quizzes as $quiz)
                <tr class="gradeA">
                    <td>{{ $quiz->id }}</td>
                    <td>{{ $quiz->name }}</td>
                    <td>{{ $quiz->no_of_questions }}</td>
                    <td>{{ $quiz->questions_count }}</td>
                    <td>{{ $quiz->is_active === 1 ? 'Yes' : 'No' }}</td>
                    <td class="center">
                        @if($quiz->questions_count < $quiz->no_of_questions)
                        <a data-toggle="tooltip" data-placement="left" title="Add Questions" data-original-title="Tooltip on left" href="{{ route('quizzes.questions.create', [ 'quiz' => $quiz->id ]) }}" class="btn btn-success dim" >
                            <i class="fa fa-plus"></i>
                        </a>
                        @endif
                        <a data-toggle="tooltip" data-placement="left" title="View Questions" data-original-title="Tooltip on left" href="{{ route('quizzes.questions.index', [ 'quiz' => $quiz->id ]) }}" class="btn btn-info dim" >
                            <i class="fa fa-eye"></i>
                        </a>
                        <a href="{{ route('quizzes.edit', [ 'quiz' => $quiz->id ]) }}" class="btn btn-warning dim" >
                            <i class="fa fa-edit"></i>
                        </a>
                        
                        <form id="delete_form_{{ $quiz->id }}" action="{{ route('quizzes.destroy', ['quiz' => $quiz->id]) }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                        </form>
                        <a class="btn btn-danger dim" onclick="event.preventDefault(); onDelete(document.getElementById(`{{ 'delete_form_' . $quiz->id }}`))">
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
<script src="js/jquery-2.1.1.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="js/plugins/jeditable/jquery.jeditable.js"></script>

<script src="js/plugins/dataTables/datatables.min.js"></script>

<!-- Custom and plugin javascript -->
<script src="js/inspinia.js"></script>
<script src="js/plugins/pace/pace.min.js"></script>
<script src="js/plugins/sweetalert/sweetalert.min.js"></script>
<script src="js/custom.js"></script>

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

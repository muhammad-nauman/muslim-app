@extends('layouts.app')

@section('title') Weekly Reminders @endsection

@section('css')
<link href="{{ url('css/plugins/dataTables/datatables.min.css') }}" rel="stylesheet">
<link href="{{ url('css/plugins/sweetalert/sweetalert.css')  }}" rel="stylesheet">
@endsection

@section('content')

<div class="row">
    <a href="{{ route('weekly_reminders.create') }}" class="btn btn-primary">Add New Reminder</a>
    <h1>All Weekly Reminders</h1>
    <div class="btn-group">
        <a class="btn @if(request('filter')['status'] == 0) btn-primary @else btn-white @endif btn-rounded" href="{{ route('weekly_reminders.index', ['filter[status]'=> 0]) }}">Pending</a>
        <a class="btn @if(request('filter')['status'] == 1) btn-primary @else btn-white @endif btn-rounded" href="{{ route('weekly_reminders.index', ['filter[status]'=> 1]) }}">Published</a>
{{--        <button class="btn btn-white btn-rounded" type="button">Expired</button>--}}
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover dataTables-example dataTable" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info" role="grid">
            <thead>
                <tr role="row">
                    <th>ID</th>
                    <th>Name</th>
                    <th>Author / Speaker</th>
                    <th>Type</th>
                    <th>Published Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($weeklyReminders as $weeklyReminder)
                <tr class="gradeA">
                    <td>{{ $weeklyReminder->id }}</td>
                    <td>{{ $weeklyReminder->title }}</td>
                    <td>{{ $weeklyReminder->author_name }}</td>
                    <td>{{ $weeklyReminder->type }}</td>
                    <td>{{ $weeklyReminder->publishing_timestamp }}</td>
                    <td class="center">
                        <a href="{{ route('weekly_reminders.edit', [ 'weekly_reminder' => $weeklyReminder->id ]) }}" class="btn btn-primary dim" >
                            <i class="fa fa-edit"></i>
                        </a>
                        <form id="{{ 'delete_form_' . $weeklyReminder->id }}" action=" {{ route('weekly_reminders.destroy', [ 'weekly_reminder' => $weeklyReminder->id ])   }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                        </form>
                        <a class="btn btn-danger dim" onclick="event.preventDefault(); onDelete(document.getElementById(`{{ 'delete_form_' . $weeklyReminder->id }}`));">
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

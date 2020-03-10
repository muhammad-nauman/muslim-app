<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element"> <span>
                        <img alt="image" class="img-circle" src="https://ui-avatars.com/api/?background=0D8ABC&color=fff&name={{ auth()->user()->name }}" />
                    </span>
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">{{ auth()->user()->name }}</strong>
                            </span> <span class="text-muted text-xs block">{{ auth()->user()->email }}<b class="caret"></b></span> </span> </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></li>
                    </ul>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </div>
                <div class="logo-element">
                    MA+
                </div>
            </li>
            <li>
                <a href="{{ route('dashboard') }}"><i class="fa fa-area-chart"></i> <span class="nav-label">Dashboard</span></a>
            </li>
            <li>
                <a href="{{ route('headings.index') }}"><i class="fa fa-header"></i> <span class="nav-label">Headings</span></a>
            </li>
            <li>
                <a href="{{ route('categories.index') }}"><i class="fa fa-list-ul"></i> <span class="nav-label">Categories</span></a>
            </li>
            <li>
                <a href="#"><i class="fa fa-question-circle"></i> <span class="nav-label">Questions Management</span><span class="fa arrow"></a>
                <ul class="nav nav-second-level collapse">
                    <li><a href="{{ route('questions.index') }}"><i class="fa fa-list"></i>All Questions</a></li>
                    <li><a href="{{ route('questions.create') }}"><i class="fa fa-plus-circle"></i>Add New</a></li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-th-large"></i> <span class="nav-label">Content Management</span><span class="fa arrow"></a>
                <ul class="nav nav-second-level collapse">
                    <li><a href="{{ route('contents.index') }}"><i class="fa fa-list"></i>Content History</a></li>
                    <li><a href="{{ route('contents.create') }}"><i class="fa fa-plus-circle"></i>Add New</a></li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-clock-o"></i> <span class="nav-label">Weekly Reminders</span><span class="fa arrow"></a>
                <ul class="nav nav-second-level collapse">
                    <li><a href="{{ route('weekly_reminders.index', ['filter[status]' => 0]) }}"><i class="fa fa-list"></i>All Weekly Reminders</a></li>
                    <li><a href="{{ route('weekly_reminders.create') }}"><i class="fa fa-plus-circle"></i>Add New</a></li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-users"></i> <span class="nav-label">Users Management</span><span class="fa arrow"></a>
                <ul class="nav nav-second-level collapse">
                    <li><a href="{{ route('users.index') }}"><i class="fa fa-list"></i>All Users</a></li>
                    <li><a href="{{ route('users.create') }}"><i class="fa fa-plus-circle"></i>Add New</a></li>
                </ul>
            </li>
        </ul>
    </div>
</nav>

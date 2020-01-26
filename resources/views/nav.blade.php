<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element"> <span>
                        <img alt="image" class="img-circle" src="{{ url('/img/profile_small.jpg') }}" />
                    </span>
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">David Williams</strong>
                            </span> <span class="text-muted text-xs block">Art Director <b class="caret"></b></span> </span> </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a href="">Profile</a></li>
                        <li class="divider"></li>
                        <li><a href="">Logout</a></li>
                    </ul>
                </div>
                <div class="logo-element">
                    IN+
                </div>
            </li>
            <li>
                <a href="layouts.html"><i class="fa fa-area-chart"></i> <span class="nav-label">Dashboard</span></a>
            </li>
            <li>
                <a href="{{ route('categories.index') }}"><i class="fa fa-clock-o"></i> <span class="nav-label">Categories</span></a>
            </li>
            <li>
                <a href="#"><i class="fa fa-question-circle"></i> <span class="nav-label">Quiz Management</span><span class="fa arrow"></a>
                <ul class="nav nav-second-level collapse">
                    <li><a href="{{ route('questions.index') }}"><i class="fa fa-list"></i>All Questions</a></li>
                    <li><a href="{{ route('questions.create') }}"><i class="fa fa-plus-circle"></i>Add New</a></li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-edit"></i> <span class="nav-label">Content Management</span><span class="fa arrow"></a>
                <ul class="nav nav-second-level collapse">
                    <li><a href="graph_flot.html"><i class="fa fa-list"></i>Content History</a></li>
                    <li><a href="graph_morris.html"><i class="fa fa-plus-circle"></i>Add New</a></li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-users"></i> <span class="nav-label">Users Management</span><span class="fa arrow"></a>
                <ul class="nav nav-second-level collapse">
                    <li><a href="graph_flot.html"><i class="fa fa-list"></i>All Users</a></li>
                    <li><a href="graph_morris.html"><i class="fa fa-plus-circle"></i>Add New</a></li>
                </ul>
            </li>
        </ul>

    </div>
</nav>
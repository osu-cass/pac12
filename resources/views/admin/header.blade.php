<div class="row">
    <div class="navbar navbar-inverse">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ URL::to('admin') }}">Admin</a>
        </div>
        <div class="navbar-collapse collapse">
            @if (!$single_language)
                <ul class="nav navbar-nav navbar-left">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{ $active_language->name }} <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            @foreach ($language_drop as $id=>$language)
                                <li><a href="{{ URL::to('admin/languages/make-active/' . $id) }}">{{ $language }}</a></li>
                            @endforeach
                        </ul>
                    </li>
                </ul>
            @endif
            <ul class="nav navbar-nav navbar-right">
                @if (Session::get('superadmin'))
                    <li{{ $active_page == 'pages' ? ' class="active"' : '' }}><a href="{{ URL::to('admin/pages') }}">Pages</a></li>
                    <li{{ $active_page == 'menus' ? ' class="active"' : '' }}><a href="{{ URL::to('admin/menus') }}">Menus</a></li>
                    <li{{ $active_page == 'users' ? ' class="active"' : '' }}><a href="{{ URL::to('admin/users') }}">Users</a></li>
                    <li{{ $active_page == 'schools' ? ' class="active"' : '' }}><a href="{{ URL::to('admin/schools') }}">Schools</a></li>
                    <li{{ $active_page == 'badges' ? ' class="active"' : '' }}><a href="{{ URL::to('admin/badges') }}">Badges</a></li>
                    <li{{ $active_page == 'reports' ? ' class="active"' : '' }}><a href="{{ URL::to('admin/reports') }}">Reports</a></li>
                    <li{{ $active_page == 'challenges' ? ' class="active"' : '' }}><a href="{{ URL::to('admin/challenges') }}">Challenges</a></li>
                    <li{{ $active_page == 'sponsors' ? ' class="active"' : '' }}><a href="{{ URL::to('admin/sponsors') }}">Sponsors</a></li>
                    <li{{ $active_page == 'languages' ? ' class="active"' : '' }}><a href="{{ URL::to('admin/languages') }}">Languages</a></li>
                @endif
                <li><a href="{{ URL::to('signout') }}">Sign Out</a></li>
            </ul>
        </div>
    </div>
</div><!-- Header Row -->
<div class="header navbar">
    <div class="header-container">
        <ul class="nav-left">
            <li><a id="sidebar-toggle" class="sidebar-toggle" href="javascript:void(0);"><i class="ti-menu"></i></a>
            </li>
            {{-- <li>
                <a href="#" data-toggle="modal" data-target="#modalChange" data-id="{{ Auth::id() }}"><i class="ti-settings mR-10"></i><span>Change Password</span></a>
            </li> --}}
        </ul>
        <ul class="nav-right">
            <li class="dropdown">
                <a href="" class="dropdown-toggle no-after peers fxw-nw ai-c lh-1" data-toggle="dropdown" aria-haspopup="true" id="dropdownMenuButton">
                    <div class="peer mR-10">
                        <img class="w-2r bdrs-50p" src="{{ Auth::user()->image != NULL ? asset("storage/images/original").'/'.Auth::user()->image  : asset('images/noimage.svg') }}" alt="">
                    </div>
                        <div class="peer"><span class="fsz-sm c-grey-900">{{ Auth::user()->name }} </span>
                    </div>
                </a>
                <ul class="dropdown-menu fsz-sm">
                    <li><a href="#" class="d-b td-n pY-5 bgcH-grey-100 c-grey-700" data-toggle="modal" data-target="#modalChange" data-id="{{ Auth::id() }}"><i class="ti-settings mR-10"></i><span>Change Password</span></a>
                    </li>
                    <li><a href="/backend/user/{{ Auth::id() }}/edit" class="d-b td-n pY-5 bgcH-grey-100 c-grey-700" data-id="{{ Auth::id() }}"><i class="ti-user mR-10"></i><span>Edit Profile</span></a>
                    </li>
                    <li role="separator" class="divider"></li>
                    <li><a href="{{ route('logout') }}" class="d-b td-n pY-5 bgcH-grey-100 c-grey-700"><i class="ti-power-off mR-10"></i> <span>Logout</span></a>
                    </li>
                </ul>
            </li>

        </ul>
    </div>
</div>
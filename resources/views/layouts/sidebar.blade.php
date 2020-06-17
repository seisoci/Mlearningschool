<div class="sidebar">
    <div class="sidebar-inner">
        <div class="sidebar-logo">
            <div class="peers ai-c fxw-nw">
                <div class="peer peer-greed">
                    <a class="sidebar-link td-n" href="index.html">
                        <div class="peers ai-c fxw-nw">
                            <div class="peer">
                                <div class="logo">
                                    <img src="assets/static/images/logo.png" alt="">
                                </div>
                            </div>
                            <div class="peer peer-greed">
                                <h5 class="lh-1 mB-0 logo-text">SMA 99 BANDAR LAMPUNG</h5>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="peer">
                    <div class="mobile-toggle sidebar-toggle"><a href="" class="td-n"><i class="ti-arrow-circle-left"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <ul class="sidebar-menu scrollable pos-r">
            <li class="nav-item mT-30 actived"><a class="sidebar-link" href="/backend/dashboard"><span class="icon-holder"><i class="c-blue-500 ti-home"></i> </span><span class="title">Dashboard</span></a>
            </li>
            @if(Auth::user()->role == 'admin')
            <li class="nav-item"><a class="sidebar-link" href="/backend/user"><span class="icon-holder"><i class="c-deep-orange-500 ti-user"></i> </span><span class="title">User</span></a>
            </li>
            <li class="nav-item"><a class="sidebar-link" href="/backend/kelas"><span class="icon-holder"><i class="c-brown-500 ti-layout"></i> </span><span class="title">Kelas</span></a>
            </li>
            <li class="nav-item"><a class="sidebar-link" href="/backend/matapelajaran"><span class="icon-holder"><i class="c-red-500 ti-bookmark-alt"></i> </span><span class="title">Matapelajaran</span></a>
            </li>
            <li class="nav-item"><a class="sidebar-link" href="/backend/mlearning"><span class="icon-holder"><i class="c-green-500 ti-book"></i> </span><span class="title">M-Learning</span></a>
            </li>
            @else
            <li class="nav-item"><a class="sidebar-link" href="/backend/user"><span class="icon-holder"><i class="c-deep-orange-500 ti-user"></i> </span><span class="title">User</span></a>
            </li>
            <li class="nav-item"><a class="sidebar-link" href="/backend/mlearning"><span class="icon-holder"><i class="c-green-500 ti-book"></i> </span><span class="title">M-Learning</span></a>
            </li>
            @endif
        </ul>
    </div>
</div>
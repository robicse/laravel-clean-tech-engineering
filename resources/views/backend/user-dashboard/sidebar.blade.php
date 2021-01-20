
<div class="c-sidebar-menu collapse  text-center p-3" style="padding: 10px">
{{--    <div class="image">--}}
{{--        <img width="100" height="100" src="{{asset('uploads/propic/'.Auth::user()->image)}}" style="border-radius: 50%" alt="">--}}
{{--    </div>--}}
    <div class="name"><h3><strong>{{Auth::user()->name}}</strong></h3></div>
    <div class="badge badge-primary">{{Auth::user()->email}} <br></div>
</div>
<ul class="c-sidebar-menu collapse" id="sidebar-menu-1">
    <li class="c-dropdown c-open">
        <a href="javascript:;" class="c-toggler"><strong>Menus</strong><span class="c-arrow"></span></a>
        <ul class="c-dropdown-menu">
            @if (Auth::user()->role_id == 2)
                <li class="{{Request::is('caregivers/dashboard*') ? 'c-active' : ''}}">
                    <a href="">My Dashbord</a>
                </li>
                <li class="{{Request::is('caregivers/edit-profile*') ? 'c-active' : ''}}">
                    <a href="">View Profile</a>
                </li>
                <li class="{{Request::is('caregivers/change-password*') ? 'c-active' : ''}}">
                    <a href="">Edit Password</a>
                </li>
                <li class="{{Request::is('caregivers/order-history*') ? 'c-active' : ''}}">
                    <a href="">Order History</a>
                </li>
                <li class="{{Request::is('caregivers/order-from-admin*') ? 'c-active' : ''}}">
                    <a href="">Order From Admin</a>
                </li>
                <li class="">
                    <a href="#" class="dropdown-item" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                   document.getElementById('logout-form').submit();">
                        <i class="fa fa-sign-out mr-2"></i> Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>

            @endif
        </ul>
    </li>
</ul>
<!-- END: LAYOUT/SIDEBARS/SHOP-SIDEBAR-DASHBOARD -->
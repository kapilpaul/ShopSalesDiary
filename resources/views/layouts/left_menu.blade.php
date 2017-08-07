<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{env('APP_URL')}}/img/user2-160x160.jpg" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">

                <p> @if(Sentinel::check())
                        {{ Sentinel::getUser()->name }}
                    @else
                        Alex
                    @endif</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search...">
                <span class="input-group-btn">
                    <button type="submit" name="search" id="search-btn" class="btn btn-flat">
                      <i class="fa fa-search"></i>
                    </button>
                  </span>
            </div>
        </form>
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MAIN NAVIGATION</li>
            <li class="{{ isActiveRoute('home') }}">
                <a href="{{ route('home') }}"> <i class="fa fa-dashboard"></i> <span>Dashboard</span></a>
            </li>
            <li class="{{ isActiveRoute('category.index') }}">
                <a href="{{ route('category.index') }}"> <i class="fa fa-dashboard"></i> <span>Category</span></a>
            </li>
            <li class="{{ isActiveRoute('brands.index') }}">
                <a href="{{ route('brands.index') }}"> <i class="fa fa-dashboard"></i> <span>Brands</span></a>
            </li>
            <li class="treeview {{ areActiveRoutes(['stocks.index', 'stocks.create', 'availableStock']) }}">
                <a href="#">
                    <i class="fa fa-files-o"></i>
                    <span>Stocks</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ isActiveRoute('stocks.create') }}"><a href="{{ route('stocks.create') }}"><i class="fa fa-circle-o"></i> New</a></li>
                    <li class="{{ isActiveRoute('stocks.index') }}"><a href="{{ route('stocks.index') }}"><i class="fa fa-circle-o"></i> View</a></li>
                    <li class="{{ isActiveRoute('availableStock') }}"><a href="{{ route('availableStock') }}"><i class="fa fa-circle-o"></i> Available
                            Stocks</a></li>
                </ul>
            </li>
            <li class="treeview {{ areActiveRoutes(['sells.search', 'sells.index', 'currentmonth.sell', 'searchMonthRange.sell']) }}">
                <a href="#">
                    <i class="fa fa-pie-chart"></i>
                    <span>Sells</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ isActiveRoute('sells.search') }}"><a href="{{ route('sells.search') }}"><i class="fa fa-circle-o"></i> New Sell</a></li>
                    <li class="{{ isActiveRoute('sells.index') }}"><a href="{{ route('sells.index') }}"><i class="fa fa-circle-o"></i> View All Sales</a></li>
                    <li class="{{ isActiveRoute('currentmonth.sell') }}"><a href="{{ route('currentmonth.sell') }}"><i class="fa fa-circle-o"></i> Current Month Sales</a></li>
                    <li class="{{ isActiveRoute('searchMonthRange.sell') }}"><a href="{{ route('searchMonthRange.sell') }}"><i class="fa fa-circle-o"></i> Search Monthly Sale</a></li>
                </ul>
            </li>
            <li class="{{ isActiveRoute('suppliers.index') }}">
                <a href="{{ route('suppliers.index') }}"> <i class="fa fa-laptop"></i> <span>Suppliers</span></a>
            </li>
            <li class="treeview {{ areActiveRoutes(['products.create', 'products.index', ]) }}">
                <a href="#">
                    <i class="fa fa-edit"></i> <span>Products</span>
                    <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ isActiveRoute('products.create') }}"><a href="{{ route('products.create') }}"><i class="fa fa-circle-o"></i> New</a></li>
                    <li class="{{ isActiveRoute('products.index') }}"><a href="{{ route('products.index') }}"><i class="fa fa-circle-o"></i> View</a></li>
                </ul>
            </li>
            <li class="treeview {{ areActiveRoutes(['users.create', 'users.index', ]) }}">
                <a href="#">
                    <i class="fa fa-table"></i> <span>Users</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ isActiveRoute('users.create') }}"><a href="{{ route('users.create') }}"><i class="fa fa-circle-o"></i>
                            New</a></li>
                    <li class="{{ isActiveRoute('users.index') }}"><a href="{{ route('users.index') }}"><i class="fa fa-circle-o"></i> All Users</a></li>
                </ul>
            </li>



            {{--<li>--}}
                {{--<a href="pages/calendar.html">--}}
                    {{--<i class="fa fa-calendar"></i> <span>Calendar</span>--}}
                    {{--<span class="pull-right-container">--}}
                  {{--<small class="label pull-right bg-red">3</small>--}}
                  {{--<small class="label pull-right bg-blue">17</small>--}}
                {{--</span>--}}
                {{--</a>--}}
            {{--</li>--}}
            {{--<li>--}}
                {{--<a href="pages/mailbox/mailbox.html">--}}
                    {{--<i class="fa fa-envelope"></i> <span>Mailbox</span>--}}
                    {{--<span class="pull-right-container">--}}
                  {{--<small class="label pull-right bg-yellow">12</small>--}}
                  {{--<small class="label pull-right bg-green">16</small>--}}
                  {{--<small class="label pull-right bg-red">5</small>--}}
                {{--</span>--}}
                {{--</a>--}}
            {{--</li>--}}
            {{--<li class="treeview">--}}
                {{--<a href="#">--}}
                    {{--<i class="fa fa-folder"></i> <span>Examples</span>--}}
                    {{--<span class="pull-right-container">--}}
                  {{--<i class="fa fa-angle-left pull-right"></i>--}}
                {{--</span>--}}
                {{--</a>--}}
                {{--<ul class="treeview-menu">--}}
                    {{--<li><a href="pages/examples/invoice.html"><i class="fa fa-circle-o"></i> Invoice</a></li>--}}
                    {{--<li><a href="pages/examples/profile.html"><i class="fa fa-circle-o"></i> Profile</a></li>--}}
                    {{--<li><a href="pages/examples/login.html"><i class="fa fa-circle-o"></i> Login</a></li>--}}
                    {{--<li><a href="pages/examples/register.html"><i class="fa fa-circle-o"></i> Register</a></li>--}}
                    {{--<li><a href="pages/examples/lockscreen.html"><i class="fa fa-circle-o"></i> Lockscreen</a></li>--}}
                    {{--<li><a href="pages/examples/404.html"><i class="fa fa-circle-o"></i> 404 Error</a></li>--}}
                    {{--<li><a href="pages/examples/500.html"><i class="fa fa-circle-o"></i> 500 Error</a></li>--}}
                    {{--<li><a href="pages/examples/blank.html"><i class="fa fa-circle-o"></i> Blank Page</a></li>--}}
                    {{--<li><a href="pages/examples/pace.html"><i class="fa fa-circle-o"></i> Pace Page</a></li>--}}
                {{--</ul>--}}
            {{--</li>--}}
            {{--<li class="treeview">--}}
                {{--<a href="#">--}}
                    {{--<i class="fa fa-share"></i> <span>Multilevel</span>--}}
                    {{--<span class="pull-right-container">--}}
                  {{--<i class="fa fa-angle-left pull-right"></i>--}}
                {{--</span>--}}
                {{--</a>--}}
                {{--<ul class="treeview-menu">--}}
                    {{--<li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>--}}
                    {{--<li class="treeview">--}}
                        {{--<a href="#"><i class="fa fa-circle-o"></i> Level One--}}
                            {{--<span class="pull-right-container">--}}
                      {{--<i class="fa fa-angle-left pull-right"></i>--}}
                    {{--</span>--}}
                        {{--</a>--}}
                        {{--<ul class="treeview-menu">--}}
                            {{--<li><a href="#"><i class="fa fa-circle-o"></i> Level Two</a></li>--}}
                            {{--<li class="treeview">--}}
                                {{--<a href="#"><i class="fa fa-circle-o"></i> Level Two--}}
                                    {{--<span class="pull-right-container">--}}
                          {{--<i class="fa fa-angle-left pull-right"></i>--}}
                        {{--</span>--}}
                                {{--</a>--}}
                                {{--<ul class="treeview-menu">--}}
                                    {{--<li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>--}}
                                    {{--<li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>--}}
                                {{--</ul>--}}
                            {{--</li>--}}
                        {{--</ul>--}}
                    {{--</li>--}}
                    {{--<li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>--}}
                {{--</ul>--}}
            {{--</li>--}}
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
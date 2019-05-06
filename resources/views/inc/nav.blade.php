{{--<div class="sidebar-offcanvas-desktop">--}}
<aside id="nav_id" class="main-sidebar fixed offcanvas shadow no-refresh">
    <section id="visible-sidebar" class="sidebar">
        {{--<div class="w-40px mt-3 mb-3 ml-3">
            <img src="{{url('/storage/logo/edgesight.ico')}}" alt="">
        </div>--}}
        <div class="relative">

            <div class="user-panel p-3 light mb-2">
                <div>
                    <div class="float-left image">
                        <img class="user_avatar" src="{{url('/storage/'.Auth::user()->image)}}" alt="User Image">
                    </div>
                    <div class="float-left info">
                        <h6 class="font-weight-light mt-2 mb-1">{{Auth::user()->first_name}} {{Auth::user()->last_name}}</h6>
                        <a href="javascript:void(0)"><i class="icon-circle text-primary blink"></i> Online</a>
                    </div>
                </div>
                <div class="clearfix"></div>

                <div class="collapse multi-collapse" id="userSettingsCollapse">
                    <div class="list-group mt-3 shadow">
                        <a href="{{url('/user/update/'.Auth::user()->id)}}" class="list-group-item list-group-item-action ">
                            <i class="mr-2 icon-umbrella text-blue"></i>Profile
                        </a>
                        <a href="{{url('/user/update/'.Auth::user()->id)}}" class="list-group-item list-group-item-action"><i
                                    class="mr-2 icon-cogs text-yellow"></i>Settings</a>

                    </div>
                </div>
            </div>
        </div>

        <ul class="sidebar-menu" style="background-color: #ffffff">
            {{--<li class="header"><strong>MAIN NAVIGATION</strong></li>--}}

            {{--Permssion Start--}}
            @if(config('global.view_dashboard')==1)
                <li class="treeview no-active0"><a href="{{url('/dashboard')}}">
                        <i class="icon icon {{config('global.dashboard_icon')}} nav-icon-cl s-21 "></i>
                        <span>Dashboard</span>
                        {{--  <i class="icon icon-angle-left s-21 pull-right"></i>--}}
                    </a>
                </li>
            @endif

            @if(config('global.view_customer'))
                <li class="treeview no-active2"><a href="#">
                        <i class="icon icon {{config('global.cus_icon')}} nav-icon-cl s-21"></i>
                        <i class="icon icon-angle-left s-15 pull-right"></i>
                        Customers
                        {{--<i class="icon icon-angle-left s-21 pull-right"></i>--}}
                    </a>
                    <ul class="treeview-menu">
                        {{--Permssion Start--}}
                        @if(config('global.view_customer'))
                            <li class="no-active2-1"><a href="{{url('/customers')}}">All Customers</a></li>
                        @endif
                        {{--  <li><a href="{{url('/customer/gold')}}">Gold</a>
                          </li>
                          <li><a href="{{url('/customer/silver')}}">Silver</a>
                          </li>--}}
                        @if(config('global.add_customer'))
                            <li class="no-active2-2"><a href="{{url('/customer/create')}}">Add Customer</a></li>
                        @endif

                        @if(config('global.add_customer'))
                            <li class="no-active2-3"><a href="{{url('/vehicle-models')}}">Vehicle Models</a></li>
                        @endif
                        {{--                    <li class="no-active2-4"><a href="{{url('/vehicle-brands')}}">Vehicle Brands</a></li>--}}
                        @if(config('global.add_customer'))
                            <li class="no-active2-5"><a href="{{url('/vehicle-colors')}}">Vehicle Colors</a></li>
                        @endif
                        {{--Permssion End--}}
                    </ul>
                </li>
            @endif
            {{--Permssion End--}}

            {{--Permission Start--}}
            @if(config('global.view_purchase'))
                <li class="treeview no-active7"><a href="#">
                        <i class="icon {{config('global.purchase_icon')}} nav-icon-cl nav-icon-sell s-21"></i>
                        <i class="icon icon-angle-left s-15 pull-right"></i>
                        <span>Purchases</span>
                        {{--<i class="icon icon-angle-left s-21 pull-right"></i>--}}
                    </a>
                    <ul class="treeview-menu">
                        @if(config('global.view_purchase'))
                            <li class="no-active7-1"><a href="{{url('/purchases')}}">All Purchases</a></li>
                        @endif
                        @if(config('global.add_purchase'))
                            <li class="no-active7-2"><a href="{{url('/purchases/create')}}">Add Purchase</a></li>
                        @endif
                        @if(config('global.add_purchase'))
                            <li class="no-active7-3"><a href="{{url('/suppliers')}}">Suppliers</a></li>
                        @endif
                    </ul>
                </li>
            @endif
            {{--Permission End--}}

            {{--Permission Start--}}
            @if(config('global.view_sell'))
                <li class="treeview no-active3"><a href="#">
                        <i class="icon {{config('global.sell_icon')}} nav-icon-cl nav-icon-sell s-21"></i>
                        <i class="icon icon-angle-left s-15 pull-right"></i>
                        <span>Invoices</span>
                        {{--<i class="icon icon-angle-left s-21 pull-right"></i>--}}
                    </a>
                    <ul class="treeview-menu">
                        {{--Permssion Start--}}
                        @if(config('global.view_sell'))
                            <li class="no-active3-1"><a href="{{url('/invoices')}}">All Invoices</a></li>
                        @endif

                        @if(config('global.add_sell'))
                            <li class="no-active3-2"><a href="{{url('/invoice/create')}}">Add Invoice</a></li>
                        @endif
                        {{--Permission End--}}
                    </ul>
                </li>
            @endif

            @if(config('global.view_product'))
                <li class="treeview no-active4"><a href="#">
                        <i class="icon icon {{config('global.pro_icon')}} nav-icon-cl s-21"></i>
                        <i class="icon icon-angle-left s-15 pull-right"></i>
                        <span>Products</span>
                        {{--<i class="icon icon-angle-left s-21 pull-right"></i>--}}
                    </a>
                    <ul class="treeview-menu ">
                        {{--Permssion Start--}}
                        @if(config('global.view_product'))
                            <li class="no-active4-1"><a href="{{url('/products')}}">All Products</a></li>
                        @endif

                        @if(config('global.add_product'))
                            <li class="no-active4-2"><a href="{{url('/product/create')}}">Add Product</a></li>
                        @endif

                        @if(config('global.add_product'))
                            <li class="no-active4-3"><a href="{{url('/product-models')}}">Product Models</a></li>
                        @endif

                        @if(config('global.add_product'))
                            <li class="no-active4-5"><a href="{{url('/product-use-for')}}">Product Use For</a></li>
                        @endif
                        {{--Permssion End--}}
                    </ul>
                </li>
            @endif
            {{--Permssion End--}}


            {{--Permssion Start--}}
            @if(config('global.view_expense'))
                <li class="treeview no-active5"><a href="#">
                        <i class="icon {{config('global.expense_icon')}} nav-icon-cl s-21"></i>
                        <i class="icon icon-angle-left s-15 pull-right"></i>
                        <span>Expenses</span>
                        {{--<i class="icon icon-angle-left s-21 pull-right"></i>--}}
                    </a>
                    <ul class="treeview-menu">
                        {{-- <li><a href="{{url('/income')}}">All income</a>
                         </li>--}}
                        {{--Permssion Start--}}
                        @if(config('global.view_expense'))
                            <li class="no-active5-1"><a href="{{url('/expenses')}}">All Expenses</a></li>
                        @endif

                        @if(config('global.add_expense'))
                            <li class="no-active5-2"><a href="{{url('/expense/create')}}">Add Expense</a></li>
                        @endif

                        @if(config('global.add_expense'))
                            <li class="no-active5-3"><a href="{{url('/expense-categories')}}">Expense Categories</a></li>
                        @endif
                        {{--Permssion End--}}
                    </ul>
                </li>
            @endif
            {{--Permssion End--}}


            {{--Permssion Start--}}
            @if(config('global.view_expense'))
                <li class="treeview no-active5"><a href="#">
                        <i class="icon {{config('global.expense_icon')}} nav-icon-cl s-21"></i>
                        <i class="icon icon-angle-left s-15 pull-right"></i>
                        <span>Application Setup</span>
                        {{--<i class="icon icon-angle-left s-21 pull-right"></i>--}}
                    </a>
                    <ul class="treeview-menu">
                        {{-- <li><a href="{{url('/income')}}">All income</a>
                         </li>--}}
                        {{--Permssion Start--}}

                        @if(config('global.add_expense'))
                            <li class="no-active5-2"><a href="{{url('/expense/create')}}">Language</a></li>
                        @endif

                        @if(config('global.add_expense'))
                            <li class="no-active5-3"><a href="{{url('/expense-categories')}}">Holiday Setup</a></li>
                        @endif

                        @if(config('global.view_expense'))
                            <li class="no-active5-1"><a href="{{url('/expenses')}}">Country Setup</a></li>
                        @endif

                        @if(config('global.add_expense'))
                            <li class="no-active5-3"><a href="{{url('/expense-categories')}}">Province</a></li>
                        @endif

                        @if(config('global.add_expense'))
                            <li class="no-active5-3"><a href="{{url('/expense-categories')}}">District</a></li>
                        @endif

                        @if(config('global.add_expense'))
                            <li class="no-active5-3"><a href="{{url('/expense-categories')}}">Commune</a></li>
                        @endif

                        @if(config('global.add_expense'))
                            <li class="no-active5-3"><a href="{{url('/expense-categories')}}">Village</a></li>
                        @endif
                        {{--Permssion End--}}
                    </ul>
                </li>
            @endif
            {{--Permssion End--}}


            <li class="treeview no-active6"><a href="#">
                    <i class="icon {{config('global.report_icon')}} nav-icon-cl s-21"></i>
                    <i class="icon icon-angle-left s-15 pull-right"></i>
                    <span>Reports</span>
                    {{--<i class="icon icon-angle-left s-21 pull-right"></i>--}}
                </a>
                <ul class="treeview-menu">
                    {{-- <li><a href="{{url('/income')}}">All income</a>
                     </li>--}}
                    <li class="no-active6-4"><a href="{{url('/invoices-report')}}">Invoice Report</a></li>
                    <li class="no-active6-1"><a href="{{url('/stock-report')}}">Stock Report</a></li>
                    <li class="no-active6-2"><a href="{{url('/expense-report')}}">Expense Report</a></li>
                    {{--<li class="no-active6-3"><a href="{{url('/customer-report')}}">Customer Report</a></li>--}}
                    <li class="no-active6-3"><a href="{{url('/out_stock-report')}}">Out Stock Report</a></li>


                </ul>
            </li>

        </ul>

    </section>
</aside>

<!--Sidebar End-->
{{--Right Top Bar--}}
<div class="has-sidebar-left ">

    {{-- <div class="pos-f-t">
         <div class="collapse" id="navbarToggleExternalContent">
             <div class="bg-dark pt-2 pb-2 pl-4 pr-2">
                 <div class="search-bar">
                     <input class="transparent s-24 text-white b-0 font-weight-lighter w-128 height-50" type="text"
                            placeholder="start typing...">
                 </div>
                 <a href="#" data-toggle="collapse" data-target="#navbarToggleExternalContent" aria-expanded="false"
                    aria-label="Toggle navigation" class="paper-nav-toggle paper-nav-white active "><i></i></a>
             </div>
         </div>
     </div>--}}
    <div class="sticky no-refresh">
        <div class="navbar navbar-expand navbar-dark d-flex justify-content-between bd-navbar blue accent-3 ">
            <div class="relative ">
                {{-- <a href="#" data-toggle="offcanvas" >
                     <h4 class="white-text no-mg-b"> <i class="{{config('global.icon_content_title')}}"></i> {{config('global.text_content_title')}}</h4>
                 </a>--}}
                <ol class="breadcrumb">
                    @if(config('global.text_content_title')!='Dashboard')
                        @if(config('global.view_dashboard'))
                            <li class="breadcrumb-item">
                                <a href="{{url('/dashboard')}}"><i class="icon {{config('global.dashboard_icon')}} "></i>Dashboard</a>
                            </li>
                        @endif
                    @endif

                    {{--If Create or Update not show icon--}}
                    @if(!empty(config('global.index_link'))&&!empty(config('global.parent_text_content_title')))
                        <li class="breadcrumb-item">
                            <a href="{{url(config('global.index_link'))}}"><i class="icon {{config('global.icon_content_title')}} "></i>{{config('global.parent_text_content_title')}}</a>
                        </li>
                        <li data-toggle="offcanvas" class="breadcrumb-item active">{{config('global.text_content_title')}}</li>
                    @else
                        {{--If Index--}}
                        <li data-toggle="offcanvas" class="breadcrumb-item active"><i class="icon {{config('global.icon_content_title')}} "></i>{{config('global.text_content_title')}}</li>
                    @endif


                </ol>

            </div>


            <!--Top Menu Start -->
            <div class="navbar-custom-menu p-t-10 ">
                <ul class="nav navbar-nav">
                    <li>
                        <div class="row" style="padding-top: 8px;padding-right: 5px">
                            <a href="javascript:void(0)" data-toggle="offcanvas"><i class="btn-refresh-top icon icon-web_asset"></i></a>
                            {{-- @if(!empty(config('global.index_link'))&&empty(config('global.parent_text_content_title')))
                                 <a href="javascript:void(0)" onclick="master('{{ route(config('global.index_link')) }}')"><i class="btn-refresh-top icon icon-refresh2"></i></a>
                             @endif--}}
                        </div>
                    </li>

                    {{--Permission Start--}}
                    @if(config('global.notification'))
                        <notification v-bind:notifications="notifications"></notification>
                @endif

                <!-- User Account-->


                    <li class="dropdown custom-dropdown user user-menu" >
                        <a id="user-r" href="#" class="nav-link mg-b-user-image" data-toggle="dropdown">
                            <img src="{{url('/storage/'.Auth::user()->image)}}" class="user-image" alt="">
                            <i class="icon-more_vert "></i>
                        </a>

                        <div class="dropdown-menu p-4">


                            <div class="row box justify-content-between my-4">

                                {{--Permission Start--}}
                                @if(config('global.view_user'))
                                    <div class="col">
                                        <a href="{{url('/users')}}">
                                            <i class="icon-user-circle-o text-blue avatar  r-5"></i>
                                            <div class="pt-1 nav-r-cl">All Users</div>
                                        </a>
                                    </div>
                                @endif
                                {{--Permission End--}}

                                {{--Permission Start--}}
                                @if(config('global.add_user'))
                                    <div class="col">
                                        <a href="{{url('/roles')}}">
                                            <i class="icon-combination-lock2 text-blue avatar  r-5"></i>
                                            <div class="pt-1 nav-r-cl">Roles</div>
                                        </a>
                                    </div>
                                @endif
                                {{--Permission End--}}

                                <div class="col">
                                    <a href="{{url('/logout')}}">
                                        <i class="icon-key4 text-red avatar  r-5"></i>
                                        <div class="pt-1 nav-r-cl">Logout</div>
                                    </a>
                                </div>
                            </div>

                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
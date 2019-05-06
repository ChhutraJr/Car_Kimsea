@extends('master')
@section('content')
    <div class="page has-sidebar-left">

        <div class="container-fluid animatedParent animateOnce my-3">

            {{--Filter Start--}}
            <div class="animated fadeInUpShort shadow" style="margin-bottom: 8px">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body no-pd-t no-pd-b">
                                <div class="row">
                                    <div class="col-md-12 no-padding-lr">

                                        <ul class="accordion no-mg-b">
                                            <li>
                                                <a class="toggle" href="javascript:void(0);"><i class="icon icon-filter"></i> Filters</a>
                                                <ul class="inner show" style="display: block">
                                                    <li>
                                                        <div class="row">

                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="brand">User</label>
                                                                    <select class="custom-select select2 tags input7" name="users" id="filter-user">
                                                                        <option value="all_users">All Users</option>
                                                                        @foreach($users as $u)
                                                                            <option value="{{$u->id}}">{{$u->first_name}} {{$u->last_name}}</option>
                                                                        @endforeach
                                                                    </select>

                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="brand">Seller</label>
                                                                    <select class="custom-select select2 tags input7" name="sellers" id="filter-seller">
                                                                        <option value="all_sellers">All Sellers</option>
                                                                        @foreach($sellers as $s)
                                                                            <option value="{{$s->id}}">{{$s->first_name}} {{$s->last_name}}</option>
                                                                        @endforeach
                                                                    </select>

                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label for="Type"><h6>Date Range:</h6></label>
                                                                <div class="date-range-custom" id="date-range" >
                                                                    <i class="icon icon-calendar"></i>&nbsp;
                                                                    <span></span> <i class="icon icon-caret-down"></i>
                                                                </div>
                                                            </div>
                                                           {{-- <div class="col-md-4">
                                                                <button class=" btn btn-primary pull-right mg-t-29 btn-round" type="button" id="btn-apply">Apply</button>
                                                            </div>--}}
                                                        </div>

                                                    </li>

                                                </ul>
                                            </li>

                                        </ul>

                                    </div>

                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
            {{--Filter End--}}
            {{--Total Grand Start--}}
            <div class="animated fadeInUpShort shadow" style="margin-bottom: 8px">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body no-pd-t no-pd-b" style="background: rgb(248, 249, 250)">
                                <div class="row no-gutters bg-light ">
                                    <div class="col-md-3 b-r p-3">
                                        <h5>Total Cost</h5>
                                        <span id="cost-in-stock-filter" >{{Liseng::cost_in_stock(config('current_page_date'),config('current_page_date'))}} </span>   <span style="margin-left: 5px;color: #86939e">(In Stock)</span><br>
                                        <span id="cost-out-stock-filter">{{Liseng::cost_out_stock(config('current_page_date'),config('current_page_date'))}} </span>   <span style="margin-left: 5px;color: #86939e">(Out Stock)</span>
                                    </div>
                                    <div class="col-md-3 b-r p-3">
                                        <div class="">
                                            <h5>Total Amount</h5> {{--<span class="amber-text">+87.4</span></h5>--}}
                                            <span id="total-amount-filter">{{Liseng::total_amount(config('current_page_date'),config('current_page_date'))}}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-3 b-r p-3">
                                        <div class="">
                                            <h5>Total Paid</h5>
                                            <span id="total-paid-filter">{{Liseng::total_paid(config('current_page_date'),config('current_page_date'))}}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-3 p-3">
                                        <div class="">
                                            <h5>Total Credit</h5>
                                            <span id="total-remain-filter">{{Liseng::total_remain(config('current_page_date'),config('current_page_date'))}}</span>
                                        </div>
                                    </div>

                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
            {{--Total Grand End--}}

            <div class="animated fadeInUpShort shadow">
                <div class="row">
                    <div class="col-md-12">

                            <div class="table-responsive">
                                <div class="card">
                                    <div class="card-body2">

                                        <table id="master-table" class="table table-striped table-bordered" cellspacing="0" width="100%" data-options='{"searching":true}'>

                                            <thead>
                                            <tr>
                                                <th>Invoice Date</th>
                                                <th>Invoice No</th>
                                                <th>Customer</th>
                                                <th>Payment Status</th>
                                                <th>Total Cost (In Stock)</th>
                                                <th>Total Cost (Out Stock)</th>
                                                <th>Total Amount</th>
                                                <th>Total Paid</th>
                                                <th>Total Credit</th>
                                            </tr>
                                            </thead>

                                            <tfoot>
                                            <tr>
                                                <th colspan="4" style="text-align:right"><b>Total:</b></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>

                                            </tr>
                                            </tfoot>

                                        </table>

                                        {{--Pagination Start--}}
                                        <div class="show_pag">
                                            <div class="filters-row filters-row-layout border-top-none">
                                                <div class="pull-right col-xs-12 col-sm-12 col-md-12 text-right">
                                                    <div class="filters-row__pagination">
                                                        <ul id="pagination" class="pagination text-right">
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        {{--Pagination End--}}
                                    </div>
                                </div>
                            </div>

                    </div>
                </div>
            </div>

            {{--Detail Start--}}

            {{--List Master Data--}}
            <div id="view" class="modal modal-xxl">
                <div class="row">
                    <div class="col-md-12">
                        <h3>Invoice Details (Invoice No: <span id="d-invoice"></span>)</h3>

                        <hr>
                    </div>

                    <div class="col-md-4">
                        Invoice No: <b><span id="d-invoice-no"></span></b>
                    </div>
                    <div class="col-md-4">
                        Customer: <b> <span id="d-cus"></span></b>
                    </div>
                    <div class="col-md-4">
                        Date: <b> <span id="d-date"></span></b>
                    </div>


                    <div class="col-md-4">
                        Payment Status: <b><span id="d-payment"></span></b>
                    </div>

                    <div class="col-md-4">
                        Customer ID: <b> <span id="d-cus-id"></span></b>
                    </div>

                    <div class="col-md-4">
                        SA: <b><span id="d-sa"></span></b>
                    </div>
                    <div class="col-md-4">

                        Mechanic: <b><span id="d-mechanic"></span></b>
                    </div>
                    <div class="col-md-4">

                        Plate No: <b><span id="d-plate-no"></span></b>
                    </div>
                    <div class="col-md-4">

                        Seller: <b><span id="d-seller"></span></b>
                    </div>
                    <div class="col-md-4">
                        KM: <b><span id="d-km"></span></b>

                    </div>
                    <div class="col-md-4">

                        Contact Number: <b><span id="d-contact-num"></span></b>
                    </div>
                    <div class="col-md-4">
                        RO: <b><span id="d-ro"></span></b>
                    </div>
                    <div class="col-md-4">
                        Note: <b><span id="d-note"></span></b>
                    </div>
                </div>

                {{--Detail Data--}}
                <div class="row">
                    <div class="col-md-12 no-padding-lr" >
                        <div class="card-body2 pd-t-20 slimScroll" data-height="100%">
                            <div class="table-responsive">
                                <table id="detail-table" class="table table-striped table-bordered" cellspacing="0" width="100%" data-options='{"searching":true}' >

                                    <thead>
                                    <tr>
                                        <th>Description</th>
                                        <th>Qty</th>
                                        <th>Cost Price</th>
                                        <th>Sell Price</th>
                                        <th>Total</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    {{-- <tfoot>
                                     <tr>
                                         <th colspan="3" style="text-align:right"><b>Grand Total:</b></th>
                                         <th></th>
                                     </tr>
                                     </tfoot>--}}
                                </table>
                            </div>
                        </div>
                    </div>

                </div>

                {{--Grand total--}}
                <div class="row">
                    <div class="col-md-9 hidden-xs">
                    </div>
                    <div class="col-md-3 col-xs-12">

                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                <tr>
                                    <td></td>
                                    <th width="205px">Grand Total:</th>
                                    <td><b><span id="grand-total">$0.00</span></b></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <th width="205px">Discount:</th>
                                    <td><b><span id="discount">0%</span></b></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <th width="205px">Total Payable:</th>
                                    <td><b><span id="total-payable">$0.00</span></b></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <th width="205px">Total Paid:</th>
                                    <td><b><span id="total-paid">$0.00</span></b></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <th width="205px">Total Credit:</th>
                                    <td><b><span id="total-credit">$0.00</span></b></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {{--<a href="#" class="btn btn-danger" rel="modal:close"><i class="icon-close"></i> Close</a>--}}

            </div>
            {{--List Master Data End--}}

            {{--List Payment Start--}}
            <div id="view2" class="modal modal-xl">
                <div class="row">
                    <div class="col-md-12">
                        <h3>View Payments (Invoice No: <span id="p-invoice"></span>)</h3>

                        <hr>

                    </div>

                    <div class="col-md-4">
                        Invoice No: <b><span id="p-invoice-no"></span></b>
                    </div>
                    <div class="col-md-4">
                        Customer: <b> <span id="p-cus"></span></b>
                    </div>
                    <div class="col-md-4">
                        Date: <b> <span id="p-date"></span></b>
                    </div>


                    <div class="col-md-4">
                        Payment Status: <b><span id="p-payment"></span></b>
                    </div>

                    <div class="col-md-4">
                        Customer ID: <b> <span id="p-cus-id"></span></b>
                    </div>

                    <div class="col-md-4">
                        SA: <b><span id="p-sa"></span></b>
                    </div>
                    <div class="col-md-4">

                        Mechanic: <b><span id="p-mechanic"></span></b>
                    </div>
                    <div class="col-md-4">

                        Plate No: <b><span id="p-plate-no"></span></b>
                    </div>
                    <div class="col-md-4">

                        Seller: <b><span id="p-seller"></span></b>
                    </div>
                    <div class="col-md-4">
                        KM: <b><span id="p-km"></span></b>

                    </div>
                    <div class="col-md-4">

                        Contact Number: <b><span id="p-contact-num"></span></b>
                    </div>
                    <div class="col-md-4">
                        RO: <b><span id="p-ro"></span></b>
                    </div>
                    <div class="col-md-4">
                        Note: <b><span id="p-note"></span></b>
                    </div>
                </div>
                {{--Table Start--}}
                <div class="row">
                    <div class="col-md-12 no-padding-lr" >
                        <div class="card-body2 slimScroll" data-height="100%">
                            <div class="table-responsive">
                                <table id="detail2-table" class="table table-striped table-bordered" cellspacing="0" width="100%" data-options='{"searching":true}' >
                                    <thead>
                                    <tr class="" style="border-bottom: none !important;">
                                        <th class="">Date</th>
                                        <th class="">Amount</th>
                                        <th class="">Payment Note</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>

                            </div>


                        </div>
                    </div>
                </div>
                {{--Table End--}}

            </div>
            {{--List Payment End--}}

            {{--Detail End--}}
        </div>

    </div>



    <input type="hidden" id="delete_id">
    <input type="hidden" id="start-date">
    <input type="hidden" id="end-date">
    <input type="hidden" id="apply" value="false">
@endsection


@section('data')
    <script type="text/javascript">

        //on load display all data
        $(document).ready(function() {

            //add filter date with first master date
            filter_date_invoice_report(moment('{{config('current_page_date')}}'),moment('{{config('current_page_date')}}'));
            //get current number page
/*            var page = window.location.hash.replace('#','');
            if (page==''){
                page=1;
            }
            //update pagination
            update_page(page);*/

            //display master table server side
            {{--master('{{ route(config('global.index_link')) }}','{{config('current_page_date')}}','{{config('current_page_date')}}',$('#filter-user').val(),$('#filter-seller').val());--}}

            //add active on nav bar
            $('.no-active6').removeClass('no-active6').addClass('active');
            $('.no-active6-4').removeClass('no-active6-3').addClass('active');
        });

        function filter_date_invoice_report(start_date,end_date) {
            $('#date-range').daterangepicker({
                "showDropdowns": true,
                "autoApply": true,
                startDate: start_date,
                endDate: end_date,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                    'This Year': [moment().startOf('year'), moment().endOf('year')]

                }

            }, cb);

            cb(start_date, end_date);
        }

        //on change datepicker
        function cb(start, end) {
            $('#date-range span').html(start.format('D MMM, YYYY') + ' - ' + end.format('D MMM, YYYY'));

            var start=start.format('YYYY-MM-DD');
            var end=end.format('YYYY-MM-DD');


            $('#start-date').val(start);
            $('#end-date').val(end);

            refresh_data_apply();
            //            $('.show_pag').hide();

            //set click apply to true
            if ($('#start-date').val()!='{{config('current_page_date')}}'){
                $('#apply').val('true');
            }

            var page = window.location.hash.replace('#','');
            if (page==''){
                page=1;
            }
            //update pagination
            update_page(page);

        }

        //Refresh data
        //Use to refresh datatable with one date sort
/*        function refresh_data() {
            master('{ route(config('global.index_link')) }}',$('#start-date').val(),$('#end-date').val());

            var page = window.location.hash.replace('#','');
            if (page==''){
                page=1;
            }
            update_page(page);
        }*/

        //Refresh datatable
        //Use to refresh datatable with apply click
        function refresh_data_apply(){
            master('{{ route(config('global.index_link')) }}',$('#start-date').val(),$('#end-date').val(),$('#filter-user').val(),$('#filter-seller').val());

           /* alert($('#filter-user').val());
            alert($('#filter-seller').val());*/
            $.ajax({
                type: 'post',
                url: "{{route('invoice.get_data_by_date')}}",
                data: {
                    "_token": "<?=csrf_token()?>",
                    'start': $('#start-date').val(),
                    'end': $('#end-date').val(),
                    'user': $('#filter-user').val(),
                    'seller': $('#filter-seller').val()
                },
                success: function (data) {
                    console.log(data);
                    $('#cost-in-stock-filter').html(data.cost_in_stock);
                    $('#cost-out-stock-filter').html(data.cost_out_stock);
                    $('#total-amount-filter').html(data.total_amount);
                    $('#total-paid-filter').html(data.total_paid);
                    $('#total-remain-filter').html(data.total_remain);
                }
            });
        }

        //Pagination Start
        $(document).on('click','.pagination a', function(e){
            e.preventDefault();
//            alert($(this).attr('href'));
            var page = $(this).attr('href').split('page=')[1];

            // console.log(page);
            // getProducts(page);
            location.hash = page;
        });
        $(window).on('hashchange',function(){
            page = window.location.hash.replace('#','');

            filter_date_invoice_report(moment($('#start-date').val()),moment($('#end-date').val()));
            update_page(page);

        });

        function update_page(page) {
            $.ajax({
                url: '/invoice/pagination/' + page,
                type: "get",
                dataType: 'json'
            }).done(function(data){
//                console.log(data);

                var next_page='/invoices?page='+(data.current_page*1+1);
                var pre_page='/invoices?page='+(data.current_page*1-1);



                {{--master('{{ route(config('global.index_link')) }}',data.master_pag.data[0],data.master_pag.data[0],$('#filter-user').val(),$('#filter-seller').val());--}}


{{--                $('#cost-in-stock-filter').html(data.cost_in_stock);
                $('#cost-out-stock-filter').html(data.cost_out_stock);
                $('#total-amount-filter').html(data.total_amount);
                $('#total-paid-filter').html(data.total_paid);
                $('#total-remain-filter').html(data.total_remain);--}}



                $('#start-date').val(data.date);
                $('#end-date').val(data.date);

                //filter_date_invoice_report(moment(data.date),moment(data.date));

                pagination(data.total,data.current_page,next_page,data.has_more_pages,pre_page,1);
                scroll_to_top();
            });


        }

        function pagination(total,current_page,next_page,has_more_pages,previous_page,per_page) {
            var page=0;
            page=Math.ceil(total/per_page);
            var active_page="";
            var numbers='';
            var previous='';
            var next='';

            for(var p=1;p<=page;p++){
                if (p==current_page){
                    active_page="page-item active";
                }else{
                    active_page="page-item";
                }

                numbers+='<li class="'+active_page+'"><a class="page-link" href="invoices/pagination?page='+p+'">'+p+'</a></li>';
            }

            if (has_more_pages==false){
                next='<li class="page-item disabled" ><a class="page-link"  href="'+next_page+'">Next</a></li>';
            }else{
                next='<li class="page-item" ><a class="page-link"  href="'+next_page+'">Next</a></li>';
            }
            if (current_page==1){
                previous='<li class="page-item disabled"><a class="page-link"  href="'+previous_page+'">Previous</a></li>';
            }else{
                previous='<li class="page-item"><a class="page-link"  href="'+previous_page+'">Previous</a></li>';
            }

            /*  <li ><a href="">&gt;</a></li>*/
            var pag='<ul id="pagination" class="pagination text-right"> '+previous+' '+numbers+' '+next+' </ul>';


            $('#pagination').html(pag);

        }

        //Pagination End

        //on change User
        $('#filter-user').on("change",function () {

            //refresh_data_apply();

            var start= $('#date-range').data('daterangepicker').startDate.format('YYYY-MM-DD');
            var end=  $('#date-range').data('daterangepicker').endDate.format('YYYY-MM-DD');

            filter_date_invoice_report(moment(start),moment(end));

        });

        //on change Seller
        $('#filter-seller').on("change",function () {

            var start= $('#date-range').data('daterangepicker').startDate.format('YYYY-MM-DD');
            var end=  $('#date-range').data('daterangepicker').endDate.format('YYYY-MM-DD');

            filter_date_invoice_report(moment(start),moment(end));

        });

        //Display master table with route
        function master(route,data1,data2,data3,data4) {
            $('#master-table').dataTable({
                "bPaginate": false,
                "bLengthChange": false,
                "bInfo": false,
                "paging": false,
                "bDestroy": true,
                "order": [],
                "processing": true,
                "serverSide": true,
                "footerCallback": function ( row, data, start, end, display ) {
                    var api = this.api(), data;
//                    grand_total_amount=data.grand_total_amount;

//                    console.log(row);
                    // Remove the formatting to get integer data for summation
                    var intVal = function ( i ) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '')*1 :
                            typeof i === 'number' ?
                                i : 0;
                    };

                    // Total over this page
                    cost_in_stock = api
                        .column( 4, { page: 'current'} )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );

                    cost_out_stock = api
                        .column( 5, { page: 'current'} )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );

                    total_amount = api
                        .column( 6, { page: 'current'} )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );

                    total_paid = api
                        .column( 7, { page: 'current'} )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );

                    total_ramaining = api
                        .column( 8, { page: 'current'} )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );

                    // Update footer
                    $( api.column( 4 ).footer() ).html(
                        '<b>$'+parseFloat(cost_in_stock).format(2) +'</b>'
                    );

                    $( api.column( 5).footer() ).html(
                        '<b>$'+parseFloat(cost_out_stock).format(2) +'</b>'
                    );
                    $( api.column( 6 ).footer() ).html(
                        '<b>$'+parseFloat(total_amount).format(2) +'</b>'
                    );

                    $( api.column( 7 ).footer() ).html(
                        '<b>$'+parseFloat(total_paid).format(2) +'</b>'
                    );

                    $( api.column( 8 ).footer() ).html(
                        '<b>$'+parseFloat(total_ramaining).format(2) +'</b>'
                    );

                },
                "ajax": {
                    "url": route,
                    "type": "POST",
                    "data":{
                        "_token":"<?=csrf_token()?>",
                        "data1":data1,
                        "data2":data2,
                        "data3":data3,
                        "data4":data4
                    }
                },
                "columns": [
                    { "data": "date","render":function (data) {
                        return '<i class="icon icon-timer"></i> '+data+'';
                    }},
                    {"data": "invoice_no","render":function (data) {
                        return '<a class="link-color" href="javascript:void(0)" > '+data+' </a>';
                    }},
                    {"data": "cus", name: "c.name"},
                    { "data": "payment_status","render":function (data) {
                        if (data=='Paid'){
                            var type='<span class="badge badge-success r-3">'+data+'</span>';
                        }else if(data=='Credit'){
                            var type='<span class="badge badge-danger r-3">'+data+'</span>';
                        }else{
                            var type='<span class="badge badge-primary r-3">'+data+'</span>';
                        }

                        return '<a href="javascript:void(0)" > '+type+' </a>';
                    }},
                    { "data": "in_stock_cost"},
                    { "data": "out_stock_cost"},
                    {"data": "total_amount"},
                    {"data": "total_paid"},
                    {"data": "total_remaining"}

                ],
                fixedColumns: true,
                responsive: true
            });

        }

        //on click table single row
        $(document).ready(function() {

            $('#master-table tbody').on('click', 'tr', function (evt) {
                var table = $('#master-table').DataTable();
//                console.log(table.row(this).data());

                //     table.rows( $('#master-table tr.active') ).remove().draw();

                //List detail Start
                var invoice_no=show_na_empty(table.row(this).data().invoice_no);
                var cus=show_na_empty(table.row(this).data().cus);
                var cus_id=show_na_empty(table.row(this).data().cus_id_number);
                var con_num=show_na_empty(table.row(this).data().tel);
                var plate_no=show_na_empty(table.row(this).data().plate_no);
                var date=show_na_empty(table.row(this).data().date);
                var payment=show_na_empty(table.row(this).data().payment_status);
                var sa=show_na_empty(table.row(this).data().sa);
                var mechanic=show_na_empty(table.row(this).data().mechanic);
                var seller=show_na_empty(table.row(this).data().seller);
                var km=show_na_empty(table.row(this).data().km);
                var ro=show_na_empty(table.row(this).data().ro);
                var note=show_na_empty(table.row(this).data().note);

                //display master data start
                $('#d-invoice').html(invoice_no);
                $('#d-invoice-no').html(invoice_no);
                $('#d-cus').html(cus);
                $('#d-cus-id').html(cus_id);
                $('#d-contact-num').html(con_num);
                $('#d-plate-no').html(plate_no);
                $('#d-date').html(date);
                $('#d-payment').html(payment);
                $('#d-sa').html(sa);
                $('#d-mechanic').html(mechanic);
                $('#d-seller').html(seller);
                $('#d-km').html(km);
                $('#d-ro').html(ro);
                $('#d-note').html(note);


                //table start
                detail('{{route('invoice_detail.get_data')}}',table.row(this).data().id);
                //table start

                //display grand total
                var amount=show_na_empty(table.row(this).data().amount);
                var total_payable=show_na_empty(table.row(this).data().total_amount);
                var total_paid=show_na_empty(table.row(this).data().total_paid);
                var total_credit=show_na_empty(table.row(this).data().total_remaining);

                if (table.row(this).data().dis_type=='fixed'){
                    $('#discount').html('$'+parseFloat(table.row(this).data().dis_amount).format(2));
                }else if(table.row(this).data().dis_type=='percentage'){
                    $('#discount').html(table.row(this).data().dis_amount+'%');
                }else{
                    $('#discount').html('0%');
                }

                if (amount=='NaN'||amount==''){
                    $('#grand-total').html('$0.00');
                }else{
                    $('#grand-total').html(amount);
                }

                if (total_payable=='NaN'||total_payable==''){
                    $('#total-payable').html('$0.00');
                }else{
                    $('#total-payable').html(total_payable);
                }

                if (total_paid=='NaN'||total_paid==''){
                    $('#total-paid').html('$0.00');
                }else{
                    $('#total-paid').html(total_paid);
                }

                if (total_credit=='NaN'||total_credit==''){
                    $('#total-credit').html('$0.00');
                }else{
                    $('#total-credit').html(total_credit);
                }

                var $cell=$(evt.target).closest('td');
                if( $cell.index()==1){
                    $('#view').modal('show');
                }

                if ($cell.index()==3){
                    //list payment start
                    //display master data
                    $('#p-invoice').html(invoice_no);
                    $('#p-invoice-no').html(invoice_no);
                    $('#p-cus').html(cus);
                    $('#p-cus-id').html(cus_id);
                    $('#p-plate-no').html(plate_no);
                    $('#p-contact-num').html(con_num);
                    $('#p-date').html(date);
                    $('#p-payment').html(payment);
                    $('#p-sa').html(sa);
                    $('#p-mechanic').html(mechanic);
                    $('#p-seller').html(seller);
                    $('#p-km').html(km);
                    $('#p-ro').html(ro);
                    $('#p-note').html(note);
                    //list payment end

                    detail2('{{route('invoice_payment.get_data')}}',table.row(this).data().id);
                    $('#view2').modal('show');
                }

                //List detail End

            });
        });

        //Display detail start
        function detail(route,data1,data2) {
            $('#detail-table').dataTable({
                "searching": false,
                "bPaginate": false,
                "bLengthChange": false,
                "bFilter": true,
                "bInfo": false,
                "bAutoWidth": false,
                "paging": false,
                "bDestroy": true,
                "order": [],
                "processing": true,
                "serverSide": true,
                "footerCallback": function ( row, data, start, end, display ) {
                    var api = this.api(), data;
//                    grand_total_amount=data.grand_total_amount;

//                    console.log(row);
                    // Remove the formatting to get integer data for summation
                    var intVal = function ( i ) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '')*1 :
                            typeof i === 'number' ?
                                i : 0;
                    };

                    // Total over this page
                    grand_total = api
                        .column( 3, { page: 'current'} )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );

                    // Update footer
                    $( api.column( 3 ).footer() ).html(
                        '<b>$'+parseFloat(grand_total).format(2) +'</b>'
                    );

                },
                "ajax": {
                    "url": route,
                    "type": "POST",
                    "data":{
                        "_token":"<?=csrf_token()?>",
                        "data1":data1,
                        "data2":data2
                    }
                },
                "columns": [
                    { "data": "des", "render":function (data,type,all) {
                        if (all.type=='product'){
                            return '<span class="font-btb">'+data+' ('+all.code_part+')';+'</span>';
                        }else{
                            return '<span class="font-btb">'+data+'</span>';
                        }
                    }},
                    { "data": "qty"},
                    { "data": "cost_price"},
                    { "data": "price"},
                    { "data": "total"}
                ],
                fixedColumns: true,
                responsive: true
            });
        }
        //Display detail end

        //Display payment table with route start
        function detail2(route,data1,data2) {
            $('#detail2-table').dataTable({
                "searching": false,
                "bPaginate": false,
                "bLengthChange": false,
                "bFilter": true,
                "bInfo": false,
                "bAutoWidth": false,
                "paging": false,
                "bDestroy": true,
                "order": [],
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": route,
                    "type": "POST",
                    "data":{
                        "_token":"<?=csrf_token()?>",
                        "data1":data1,
                        "data2":data2
                    }
                },
                "columns": [
                    { "data": "date","render":function (data) {
                        return '<i class="icon icon-timer"></i> '+data+'';
                    }},
                    { "data": "amount"},
                    { "data": "note"}
                ],
                fixedColumns: true,
                responsive: true
            });
        }
        //Display payment table with route end

        //on click apply filters
/*        $('#btn-apply').click(function () {
            var type=$('#filter-type').val();
            var start=$('#date-range').data('daterangepicker').startDate.format('YYYY-MM-DD');
            var end=$('#date-range').data('daterangepicker').endDate.format('YYYY-MM-DD');

            master('{ route(config('global.index_link')) }}',start,end,type);
        });*/

        //on change data on table scroll to top
        $('#master-table').on('draw.dt', function() {
            scroll_to_top(55);
        });
    </script>
@endsection
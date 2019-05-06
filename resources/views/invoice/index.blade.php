@extends('master')
@section('content')

{{--    <style>

        .dropdown-menu.show{
            /*left: -29% !important;*/
        }

        .select2-container--default .select2-results>.select2-results__options{
            max-height: 212px !important;
        }

    </style>--}}

    <div class="page has-sidebar-left " >

        <div class="container-fluid animatedParent animateOnce my-3 ">

            @if(!$master->isEmpty())
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

                                                                <div class="col-md-4">
                                                                    <label for="Type"><h6>Date Range:</h6></label>
                                                                    <div class="date-range-custom" id="date-range" >
                                                                        <i class="icon icon-calendar"></i>&nbsp;
                                                                        <span></span> <i class="icon icon-caret-down"></i>
                                                                    </div>
                                                                </div>
                                                                {{--<div class="col-md-4">
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

                {{--Display Master Start--}}
                <div class="animated fadeInUpShort shadow">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <div class="card">
                                    <div class="card-body2">

                                        <table id="master-table" class="table table-striped table-bordered" cellspacing="0" width="100%" data-options='{"searching":true}' style="cursor: pointer">

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
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <th colspan="4" style="text-align:right"><b>Total:</b></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th colspan="2"></th>

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
                {{--Display Master End--}}
            @endif

            {{--If no master Start--}}
            <div class="animated fadeInUpShort ">
                <div class="row">
                    <div class="col-md-12">
                        @if($master->isEmpty())
                            <div class="container-fluid pt-5">
                                <div class="text-center p-5">
                                    <i class="icon-note-important s-64 text-primary"></i>
                                    <h4 class="my-3">{{config('global.no_data_title')}}</h4>
                                    <p>{{config('global.no_data_text')}}</p>
                                    <a href="{{url(config('global.add_new_link'))}}" class="btn btn-primary shadow btn-lg"><i class="icon-plus-circle mr-2 "></i>{{config('global.no_data_btn')}}</a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            {{--If no master End--}}
        </div>

        @if (config('global.add_sell'))
        <!--Add New Button-->
        <a href="{{url(config('global.add_new_link'))}}" class="btn-fab btn-fab-md fab-right fab-right-bottom-fixed shadow btn-primary"><i
                    class="icon-add"></i></a>
        @endif

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
                                <th>Note</th>
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

    {{--Add Payment Start--}}
    <div id="view3" class="modal modal-xl modal-add-payment">
        <div class="row">
            <div class="col-md-12">
                <h3>Add or edit payment</h3>
                <hr>
            </div>


            <div class="col-md-4">
                Invoice No: <b><span id="p-invoice-no2"></span></b>
            </div>
            <div class="col-md-4">
                Customer: <b> <span id="p-cus2"></span></b>
            </div>
            <div class="col-md-4">
                Date: <b> <span id="p-date2"></span></b>
            </div>


            <div class="col-md-4">
                Payment Status: <b><span id="p-payment2"></span></b>
            </div>
            <div class="col-md-4">
                Customer ID: <b> <span id="p-cus2-id"></span></b>
            </div>
            <div class="col-md-4">
                SA: <b><span id="p-sa2"></span></b>
            </div>
            <div class="col-md-4">

                Mechanic: <b><span id="p-mechanic2"></span></b>
            </div>
            <div class="col-md-4">

                Plate No: <b><span id="p-plate-no2"></span></b>
            </div>
            <div class="col-md-4">

                Seller: <b><span id="p-seller2"></span></b>
            </div>
            <div class="col-md-4">
                KM: <b><span id="p-km2"></span></b>

            </div>
            <div class="col-md-4">

                Contact Number: <b><span id="p-contact-num2"></span></b>
            </div>
            <div class="col-md-4">
                RO: <b><span id="p-ro2"></span></b>
            </div>
            <div class="col-md-4">
                Note: <b><span id="p-note2"></span></b>
            </div>
        </div>
        {{--Table Start--}}
        <div class="row">
            <div class="col-md-12" >
                <div class="card-body2 slimScroll pd-t-20" data-height="100%">
                    <div class="table-responsive">
                        <table id="payment-table" class="table table-striped table-bordered" cellspacing="0" width="100%" data-options='{"searching":true}'>
                            <thead>
                            <tr class="" style="border-bottom: none !important;">
                                <th style="display: none"></th>
                                <th width="4%"><a href='javascript:void(0)'><i id="add-new" class='icon icon-add add-icon'></i></a></th>
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

                <hr>

                <div style="text-align: right">
                    <button type="button" class="btn btn-primary btn-lg" style="margin: 0px 0px 15px 0px;" id="btn-save-pa" ><i class="icon-save mr-2"></i>Save</button>
                </div>
            </div>
        </div>
        {{--Table End--}}

    </div>
    {{--Add Payment End--}}

    {{--For delete--}}
    <input type="hidden" id="delete_id">
    <input type="hidden" id="start-date">
    <input type="hidden" id="end-date">
    <input type="hidden" id="apply" value="false">
@endsection

@section('data')
    <script type="text/javascript">
//        window.location.href='/invoices';

        //on load display all data
        $(document).ready(function() {

//            window.location.hash='';
//            page=window.location.hash.replace('#','?page=');
//            page = window.location.hash.split('#')[1];

            //location.hash = page;


//            alert(page);
            //add filter date with first master date
            {{--filter_date_invoice(moment('{{config('current_page_date')}}'),moment('{{config('current_page_date')}}'));--}}
            //get current number page
            var page = window.location.hash.replace('#','');
            if (page==''){
                page=1;
            }
            //update pagination
            update_page(page);
            //display master table server side
            {{--master('{{ route(config('global.index_link')) }}','{{config('current_page_date')}}','{{config('current_page_date')}}');--}}

            //add active on nav bar
            $('.no-active3').removeClass('no-active3').addClass('active');
            $('.no-active3-1').removeClass('no-active3-1').addClass('active');
        });


        //on change date range picker
/*        $(function() {
            //Mon Aug 13 2018 18:31:11 GMT+0700
            // anlert(momet());
            $('#date-range').on('apply.daterangepicker', function(ev, picker) {
//                console.log(picker.startDate.format('YYYY-MM-DD'));
//                console.log(picker.endDate.format('YYYY-MM-DD'));

                $('#start-date').val(picker.startDate.format('YYYY-MM-DD'));
                $('#end-date').val(picker.endDate.format('YYYY-MM-DD'));
            });

        });*/
        //Display master table with route
        function master(route,data1,data2,data3) {
            $('#master-table').dataTable({
                "bPaginate": false,
                "bLengthChange": false,
                "bInfo": false,
                "paging": false,
                "bDestroy": true,
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
                        "data3":data3
                    }
                },
                "columns": [
                    { "data": "date","render":function (data) {
                        return '<i class="icon icon-timer"></i> '+data+'';
                    }},
                    {"data": "invoice_no"},
                    {"data": "cus", name: "c.name"},
                    { "data": "payment_status","render":function (data) {
                        if (data=='Paid'){
                            var type='<span class="badge badge-success r-3">'+data+'</span>';
                        }else if(data=='Credit'){
                            var type='<span class="badge badge-danger r-3">'+data+'</span>';
                        }else{
                            var type='<span class="badge badge-primary r-3">'+data+'</span>';
                        }

                        return type;
                    }},
                    { "data": "in_stock_cost"},
                    { "data": "out_stock_cost"},
                    {"data": "total_amount"},
                    {"data": "total_paid"},
                    {"data": "total_remaining"},
                    {"data": "id", "render": function (data)
                    {

                        var view='<a class="dropdown-item" href="#view" rel="modal:open"> <i class="icon icon-eye mg-r3"></i>View</a>';
                        var edit='';
                        var del='';
                        var add_payment='';

                        //Permission Start

                        @if (config('global.update_sell'))
                        edit='<a class="dropdown-item" href="{{url(config('global.update_link'))}}'+'/'+data+'"><i class="icon icon-pencil mg-r3"></i> Edit</a>';
                        @endif
                        //Permission End

                        //Permission Start

                        @if (config('global.delete_sell'))
                        del='<a  class="master-delete dropdown-item" href="javascript:void(0)" data-toggle="modal" data-target="#delete"><i class="icon icon-trash icon-delete-action mg-r4"></i> Delete</a>';
                        @endif
                        //Permission End

                        var print='<a target="_blank" class="dropdown-item" href="{{url('invoices/print/')}}'+'/'+data+'" > <i class="icon icon-print mg-r6" ></i>Print Invoice</a>';
                        var print_management='<a target="_blank" class="dropdown-item" href="{{url('invoices/print-management/')}}'+'/'+data+'" > <i class="icon icon-print mg-r6" ></i>Print Management</a>';

                        var excel='<a class="dropdown-item" target="_blank" href="{{url('/invoice/export')}}'+'/'+data+'"> <i class="icon icon-file-excel-o excel-icon mg-r3"></i>Export Invoice</a>';

                        //Permission Start

                        @if (config('global.add_sell'))
                            add_payment='<a class="dropdown-item" href="#view3" rel="modal:open"> <i class="icon icon-money mg-r6" ></i>Add or edit Payment</a>';
                        @endif
                        //Permission End

                        var view_payment='<a class="dropdown-item" href="#view2" rel="modal:open"> <i class="icon icon-money mg-r6" ></i>View Payments</a>';

                        var action='<div class="dropdown" ><button class="btn btn-primary dropdown-toggle btn-xs" type="button" data-toggle="dropdown">Actions<span class="caret"></span></button> <div class="dropdown-menu dropdown-action shadow dropdown-width-inv"> '+view+' '+edit+'  '+del+' '+print+' '+print_management+' '+excel+' <hr class="hr-dropdown"> '+add_payment+' '+view_payment+' </div> </div>';

                        return action;

                    }
                    }

                ],
                fixedColumns: true,
                responsive: true
            });
        }

        //on click table
        $(document).ready(function() {
            $('#master-table tbody').on('click', 'tr', function (evt) {

                var table = $('#master-table').DataTable();

                //get val
                var id = table.row(this).data().id;

                //set id to delete
                $('#delete_id').val(id);
                
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


                //display master data end

                
                //table start
                detail('{{route('invoice_detail.get_data')}}',id);
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

                //List detail End

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

                //only run if column smaller than action
                var $cell=$(evt.target).closest('td');
                if( $cell.index()<9){
                    $('#view').modal('show');
                }

                //only run if click on payment status
                if($cell.index()==3){
                    //show modal payment
                    $('#view2').modal('show');
                    //display all payment invoice
                    detail2('{{route('invoice_payment.get_data')}}',id);
                }

                //only run if click on action
                if($cell.index()==9){
                    //display all payment invoice
                    detail2('{{route('invoice_payment.get_data')}}',id);
                }

                //add or edit payment start

                //display master data
                $('#p-invoice-no2').html(invoice_no);
                $('#p-cus2').html(cus);
                $('#p-cus2-id').html(cus_id);
                $('#p-plate-no2').html(plate_no);
                $('#p-contact-num2').html(con_num);
                $('#p-date2').html(date);
                $('#p-payment2').html(payment);
                $('#p-sa2').html(sa);
                $('#p-mechanic2').html(mechanic);
                $('#p-seller2').html(seller);
                $('#p-km2').html(km);
                $('#p-ro2').html(ro);
                $('#p-note2').html(note);

                var url_req="{{url('invoice-detail/payment')}}/"+id;
                $.get(url_req,function (data) {
                    //remove table data
                    $("#payment-table > tbody").html("");

                    //if empty payment
                    if (data.payment.length==0){

                        var pa_id=0;
                        var date='<div class="input-group date date_picker'+pa_id+'" data-provide="datepicker"> <div class="input-group-addon"> <span class="icon icon-calendar"></span> </div> <input type="text" class="form-control date'+pa_id+'" placeholder="Select None">  </div>';
                        var amount="<input name='amount' type='number' class='form-control amount"+pa_id+"' placeholder='$0.00' >";
                        var note="<td><input name='note' type='text' class='form-control note"+pa_id+"' placeholder='Note' ></td>";
                        //display default field
                        $('#payment-table').append("<tr class=' pro-remove product" + pa_id + "'> + <!--ID--> <td style='display: none'><input type='hidden' value='"+pa_id+"'></td> <!--Remove button--> <td><a class='remove' data-id='" + pa_id + "' data-name='" + pa_id + "' href='javascript:void(0)'><i class='icon icon-cancel rm-icon '></i></a> </td>+ <!--Date--> <td>"+date+"</td> <!--Amount-->  <td>"+amount+"</td>  <!--Note-->  "+note+"   </tr>");

                        //modify date picker format again to make it work
                        $(function(){
                            //set default date to current date
                            var now=moment().format('D/MMM/YYYY');
                            //declare date
                            $('.date_picker'+pa_id).datepicker({
                                format: 'dd/M/yyyy',
                                todayHighlight:'TRUE',
                                autoclose: true

                            }).datepicker('setDate', new Date(now)); //default date
                        });

                    }else{
                        for (var i = 0; i < data.payment.length; i++) {

                            //add id to table
                            var pa_id=data.payment[i].id;

                            //format date
                            var date = $.datepicker.formatDate("dd/M/yy", new Date(data.payment[i].date));
                            //change to null if payment date is empty
                            if (data.payment[i].date==''||data.payment[i].date==null){
                                date='';
                            }
                            //add date to table
                            date='<div class="input-group date date_picker'+pa_id+'" data-provide="datepicker"> <div class="input-group-addon"> <span class="icon icon-calendar"></span> </div> <input type="text" class="form-control date'+pa_id+'" placeholder="Select None" value="'+date+'">  </div>';

                            //add amount to table
                            var amount="<input name='amount' type='number' class='form-control amount"+pa_id+"' placeholder='$0.00' value='"+data.payment[i].amount+"'>";

                            var note=data.payment[i].note;

                            //change to '' if null
                            if(note==''||note==null){
                                note='';
                            }

                            //add note to table
                            note="<td><input name='note' type='text' class='form-control note"+pa_id+"' placeholder='Note' value='"+note+"'></td>";

                            $('#payment-table').append("<tr class=' pro-remove product" + pa_id + "'> + <!--ID--> <td style='display: none'><input type='hidden' value='"+pa_id+"'></td> <!--Remove button--> <td><a class='remove' data-id='" + pa_id + "' data-name='" + pa_id + "' href='javascript:void(0)'><i class='icon icon-cancel rm-icon '></i></a> </td>+ <!--Date--> <td>"+date+"</td> <!--Amount-->  <td>"+amount+"</td>  <!--Note-->  "+note+"   </tr>");

                            //modify date picker format again to make it work
                            $(function(){
                                //set default date to current date
                                var now=moment().format('D/MMM/YYYY');
                                //declare date
                                $('.date_picker'+pa_id).datepicker({
                                    format: 'dd/M/yyyy',
                                    todayHighlight:'TRUE',
                                    autoclose: true
                                }); //default date
                            });

                        }
                    }


                });

                //add or edit payment end



            });

        });

        //Delete Master
        //on click by target id
        //note: don't forget to add one class name in a to make this work
        document.body.onclick= function(e){
            e=window.event? event.srcElement: e.target;
            if(e.className && e.className.indexOf('delete')!=-1){
                //send sidebar to back side
                refresh();

                //get id by using index
//                var id=get_id_by_index('index-table','master-table');

                //get id
                var id=$('#delete_id').val();

                swal({
                        title: "Are you sure?",
                        text: '{{config('global.alert_delete_title')}}',
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonClass: "btn-danger",
                        confirmButtonText: "Yes, delete it!",
                        closeOnConfirm: false
                    },
                    function(){

                        //delete from database
                        $.ajax({
                            type: 'post',
                            url: '{{route(config('global.delete_link'))}}',
                            data: {
                                "_token":'{{csrf_token()}}',
                                'id': id
                            },
                            success: function (data) {
                                //console.log(data);

                                //alert error if delete = false
                                if (data.delete=='false'){
                                    swal_alert('Can\'t delete!','{{config('global.cant_delete_text')}}','error');
                                }else{
                                    //alert successful deleted
                                    swal_alert_autoclose('Deleted','{{config('global.after_delete_text')}}','success',1500,false);

                                    //refresh_data_apply();

                                    var page = window.location.hash.replace('#','');
                                    if (page==''){
                                        page=1;
                                    }
                                    //update pagination
                                    update_page(page);


                                }

                            }
                        });


                    });




            }
        };
        //Delete Master End

        //Add Follow up start

        // When click on add new button
        $('#add-new').click(function () {
            //count table row
            var row_count = $('#payment-table >tbody >tr').length;

            //get old id
            var old_id=parseInt($('#payment-table tr').eq(row_count).find('td').eq(0).find("input").val());

            var pa_id=old_id+1;
            var date='<div class="input-group date date_picker'+pa_id+'" data-provide="datepicker"> <div class="input-group-addon"> <span class="icon icon-calendar"></span> </div> <input type="text" class="form-control date'+pa_id+'" placeholder="Select None">  </div>';
            var amount="<input name='amount' type='number' class='form-control amount"+pa_id+"' placeholder='$0.00' >";
            var note="<td><input name='note' type='text' class='form-control note"+pa_id+"' placeholder='Note' ></td>";
            //display default field
            $('#payment-table').append("<tr class=' pro-remove product" + pa_id + "'> + <!--ID--> <td style='display: none'><input type='hidden' value='"+pa_id+"'></td> <!--Remove button--> <td><a class='remove' data-id='" + pa_id + "' data-name='" + pa_id + "' href='javascript:void(0)'><i class='icon icon-cancel rm-icon '></i></a> </td>+ <!--Date--> <td>"+date+"</td> <!--Amount-->  <td>"+amount+"</td>  <!--Note-->  "+note+"   </tr>");

            //modify date picker format again to make it work
            $(function(){
                //set default date to current date
                var now=moment().format('D/MMM/YYYY');
                //declare date
                $('.date_picker'+pa_id).datepicker({
                    format: 'dd/M/yyyy',
                    todayHighlight:'TRUE',
                    autoclose: true

                }).datepicker('setDate', new Date(now)); //default date
            });

        });
        //When click on add New Button End

        //When click on remove button
        $(document).on('click', '.remove', function(e) {
            e.preventDefault();

            var rowCount = $('#payment-table >tbody >tr').length;
            //if remove on default
            if(rowCount==1){
                //get last id
                var last_id=parseInt($('#payment-table tr').eq(rowCount).find('td').eq(0).find("input").val());
                //reset all to default
                $('.date'+last_id).val('');
                $('.amount'+last_id).val('');
                $('.note'+last_id).val('');
            }else{
                $('.product' + $(this).data('id')).remove();
            }

        });
        //When click on button End

        //Add payment Start
        $(document).ready(function() {
            $('#btn-save-pa').click(function () {

                //Delete current payment start
                $.ajax({
                    type: 'post',
                    url: "{{route('delete_payment.invoice')}}",
                    data: {
                        "_token": "<?=csrf_token()?>",
                        'invoice_id': $('#delete_id').val()
                    },
                    success: function (data) {
                    }
                });
                //Delete current payment end

                //Add payment to db start
                var rowCount = $('#payment-table >tbody >tr').length;
                //loop every field in table to get value by index
                for (var i = 1; i < rowCount + 1; i++) {

                    //get date
                    var date = $('#payment-table tr').eq(i).find('td').eq(2).find("input").val();
                    //get amount
                    var amount = $('#payment-table tr').eq(i).find('td').eq(3).find("input").val();
                    //get note
                    var note = $('#payment-table tr').eq(i).find('td').eq(4).find("input").val();

                    //format date
                    date = $.datepicker.formatDate("yy-mm-dd", new Date(date));

                    //Add to database
                    $.ajax({
                        type: 'post',
                        url: "{{route('store_payment_multi.invoice')}}",
                        data: {
                            "_token": "<?=csrf_token()?>",
                            'date': date,
                            'amount': amount,
                            'note': note,
                            'invoice_id': $('#delete_id').val()
                        },
                        success: function (data) {
//                            console.log(data);

                            if (data.verify=='true'){

                                swal_alert_autoclose('Saved','This payment have been saved.','success',1500,false);

                                refresh_data_apply();

                            }
                        }
                    });

                }

                //Add payment to db end
            });

        });
        //Add Payment End

        /*  $("#view3").modal({
         closeClass: 'icon-remove',
         closeText: '!'
         });*/

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
              /*  "footerCallback": function ( row, data, start, end, display ) {
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

                },*/
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
                    { "data": "note"},
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

/*        //on click apply filters
        $('#btn-apply').click(function () {
            var type=$('#filter-type').val();
            var start=$('#date-range').data('daterangepicker').startDate.format('YYYY-MM-DD');
            var end=$('#date-range').data('daterangepicker').endDate.format('YYYY-MM-DD');

            $('#start-date').val(start);
            $('#end-date').val(end);

            refresh_data_apply();

            $('.show_pag').hide();
            //set click apply to true
            $('#apply').val('true');
        });*/


        function filter_date_invoice(start_date,end_date) {
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

        }

        //Refresh datatable
        //Use to refresh datatable with apply click
        function refresh_data_apply(){
            master('{{ route(config('global.index_link')) }}',$('#start-date').val(),$('#end-date').val());

            $.ajax({
                type: 'post',
                url: "{{route('invoice.get_data_by_date')}}",
                data: {
                    "_token": "<?=csrf_token()?>",
                    'start': $('#start-date').val(),
                    'end': $('#end-date').val()
                },
                success: function (data) {
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


                {{--master('{{ route(config('global.index_link')) }}',data.master_pag.data[0],data.master_pag.data[0]);--}}

{{--                $('#cost-in-stock-filter').html(data.cost_in_stock);
                $('#cost-out-stock-filter').html(data.cost_out_stock);
                $('#total-amount-filter').html(data.total_amount);
                $('#total-paid-filter').html(data.total_paid);
                $('#total-remain-filter').html(data.total_remain);--}}

                //filter_date_invoice_no_all(moment(data.date),moment(data.date));

                $('#start-date').val(data.date);
                $('#end-date').val(data.date);

                filter_date_invoice(moment(data.date),moment(data.date));

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

        //on change data on table scroll to top
        $('#master-table').on('draw.dt', function() {
            scroll_to_top(55);
        });
    </script>
@endsection

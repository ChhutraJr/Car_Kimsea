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
                                                <ul class="inner">
                                                    <li>
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <label for="Type"><h6>Date Range:</h6></label>
                                                                <div class="date-range-custom" id="date-range" >
                                                                    <i class="icon icon-calendar"></i>&nbsp;
                                                                    <span></span> <i class="icon icon-caret-down"></i>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <button class=" btn btn-primary pull-right mg-t-29 btn-round" type="button" id="btn-apply">Apply</button>
                                                            </div>
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
            <div class="animated fadeInUpShort shadow">
                <div class="row">
                    <div class="col-md-12">

                        <div class="table-responsive">
                            <div class="card">
                                <div class="card-body2">

                                    <table id="master-table" class="table table-striped table-bordered" cellspacing="0" width="100%" data-options='{"searching":true}'>

                                        <thead>
                                        <tr>
                                            <th>Purchase Date</th>
                                            <th>Reference No</th>
                                            <th>Supplier</th>
                                            <th>Payment Status</th>
                                            <th>Total Amount</th>
                                            <th>Payment Due</th>
                                        </tr>
                                        </thead>


                                    </table>
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
                        <h3>Purchase Details (Reference No: <span id="d-reference"></span>)</h3>
                        <hr>
                        <div class="row">
                            <div class="col-md-4">
                                <b>Reference No:</b> <span id="d-reference-no"></span>
                            </div>
                            <div class="col-md-4">
                                <b>Supplier:</b> <span id="d-supplier"></span>
                            </div>
                            <div class="col-md-4">
                                <b>Date:</b> <span id="d-date"></span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <b>Payment Status:</b> <span id="d-payment"></span>
                            </div>
                            {{-- <div class="col-md-4">
                                 <b>Purchase Status:</b> <span id="d-purchase"></span>
                             </div>--}}
                        </div>
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
                                        <th>Product</th>
                                        <th>Qty</th>
                                        <th>Cost Price</th>
                                        <th>Subtotal</th>
                                        <th>Profit</th>
                                        <th>Sell Price</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
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
                                    <th width="205px">Grand Total Cost:</th>
                                    <td><b><span id="grand-total">$0.00</span></b></td>
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
                        <h3>View Payments (Reference No: <span id="p-reference"></span>)</h3>
                        <hr>
                        <div class="row">
                            <div class="col-md-4">
                                <b>Reference No:</b> <span id="p-reference-no"></span>
                            </div>
                            <div class="col-md-4">
                                <b>Supplier:</b> <span id="p-supplier"></span>
                            </div>
                            <div class="col-md-4">
                                <b>Date:</b> <span id="p-date"></span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <b>Payment Status:</b> <span id="p-payment"></span>
                            </div>
                            {{--<div class="col-md-4">
                                <b>Purchase Status:</b> <span id="p-purchase"></span>
                            </div>--}}
                        </div>
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
@endsection

@section('data')
    <script type="text/javascript">

        //on load display all data
        $(document).ready(function() {
            //add filter date with first master date
            filter_date(moment('{{config('global.start_date')}}'),moment());

            master('{{ route(config('global.index_link')) }}');

            //add active on nav bar
            $('.no-active6').removeClass('no-active6').addClass('active');
            $('.no-active6-4').removeClass('no-active6-3').addClass('active');
        });

        //Display master table with route

        function master(route,data1,data2,data3) {
            $('#master-table').dataTable({
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
                        "data2":data2,
                        "data3":data3
                    }
                },
                "columns": [
                    { "data": "date","render":function (data) {
                        return '<i class="icon icon-timer"></i> '+data+'';
                    }},
                    {"data": "ref_no","render":function (data) {
                        return '<a href="javascript:void(0)" > '+data+' </a>';
                    }},
                    {"data": "sup_name"},
                    { "data": "payment_status","render":function (data) {
                        if (data=='Paid'){
                            var type='<span class="badge badge-success r-3">'+data+'</span>';
                        }else if(data=='Due'){
                            var type='<span class="badge badge-danger r-3">'+data+'</span>';
                        }else{
                            var type='<span class="badge badge-primary r-3">'+data+'</span>';
                        }

                        return '<a href="javascript:void(0)" > '+type+' </a>';
                    }},
                    {"data": "payment_due"},
                    {"data": "total_amount"},

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

                //alert(table.row(this)[0]);
                //     table.rows( $('#master-table tr.active') ).remove().draw();

                //List detail Start
                var reference_no=show_na_empty(table.row(this).data().ref_no);
                var supplier=show_na_empty(table.row(this).data().sup_name);
                var date=show_na_empty(table.row(this).data().date);
                var payment=show_na_empty(table.row(this).data().payment_status);
                var purchase=show_na_empty(table.row(this).data().purchase_status);

                //display master data start
                $('#d-reference').html(reference_no);
                $('#d-reference-no').html(reference_no);
                $('#d-supplier').html(supplier);
                $('#d-date').html(date);
                $('#d-payment').html(payment);
                $('#d-purchase').html(purchase);

                //display master data end

                //table start
                detail('{{route('sale_detail.get_data')}}',table.row(this).data().id);
                //table start

                //display grand total
                var grand_total=show_na_empty(table.row(this).data().total_amount);

                if (grand_total=='NaN'||grand_total==''){
                    $('#grand-total').html('$0.00');
                }else{
                    $('#grand-total').html(grand_total);
                }

                var $cell=$(evt.target).closest('td');
                if( $cell.index()==1){
                    $('#view').modal('show');
                }

                if ($cell.index()==3){
                    //list payment start
                    //display master data
                    $('#d-reference').html(reference_no);
                    $('#d-reference-no').html(reference_no);
                    $('#d-supplier').html(supplier);
                    $('#d-date').html(date);
                    $('#d-payment').html(payment);
                    $('#d-purchase').html(purchase);
                    //list payment end

                    detail2('{{route('sale_payment.get_data')}}',table.row(this).data().id);
                    $('#view2').modal('show');
                }

                //List detail End

            });
        });

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
                    { "data": "pro", "render":function (data,type,all) {
                        return data+' ('+all.code_part+')';
                    }},
                    { "data": "qty"},
                    { "data": "cost_price"},
                    { "data": "total_cost"},
                    { "data": "profit"},
                    { "data": "sell_price"}
                ],
                fixedColumns: true,
                responsive: true
            });
        }
        //Display detail end
        //on click apply filters
        $('#btn-apply').click(function () {
            var type=$('#filter-type').val();
            var start=$('#date-range').data('daterangepicker').startDate.format('YYYY-MM-DD');
            var end=$('#date-range').data('daterangepicker').endDate.format('YYYY-MM-DD');

            master('{{ route(config('global.index_link')) }}',start,end,type);
        });



    </script>
@endsection
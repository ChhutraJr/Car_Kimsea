@extends('master')
@section('content')
    <div class="page has-sidebar-left">

        <div class="container-fluid animatedParent animateOnce my-3">
            <div class="animated fadeInUpShort shadow">
                <div class="row">
                    <div class="col-md-12">
                            <div class="table-responsive">
                                <div class="card">
                                    <div class="card-body2">

                                        <table id="master-table" class="table table-striped table-bordered" cellspacing="0" width="100%" data-options='{"searching":true}'>

                                            <thead>
                                            <tr>
                                                <th>Customer ID</th>
                                                <th>Customer</th>
                                                <th>Plate No</th>
                                                <th>Total Sale</th>
                                                <th>Due</th>
                                            </tr>
                                            </thead>
                                            <tfoot>
                                            <tr>
                                                <th colspan="3" style="text-align:right"><b>Total:</b></th>
                                                <th></th>
                                                <th></th>

                                            </tr>
                                            </tfoot>

                                        </table>
                                    </div>
                                </div>
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

                <h3>Customer Details (<span id="d-cus-type"></span>: <span id="d-cus-id"></span>)</h3>

                <hr>

                <div class="row">
                    <div class="col-md-4">
                        Customer ID: <b> <span id="d-cus-id-num"></span></b>
                    </div>
                    <div class="col-md-4">
                        Customer Name: <b> <span id="d-cus-name"></span></b>
                    </div>
                    <div class="col-md-4">
                        Contact Number: <b> <span id="d-cus-con-num"></span></b>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        Address: <b> <span id="d-cus-address"></span></b>
                    </div>
                    <div class="col-md-4">
                        Email: <b><span id="d-cus-email"></span></b>

                    </div>
                    <div class="col-md-4">
                        Vehicle Model: <b><span id="d-cus-v-model"></span></b>
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-4">
                        Plate No: <b><span id="d-cus-v-plate-no"></span></b>
                    </div>
                    <div class="col-md-4">
                        Year: <b><span id="d-cus-v-year"></span></b>
                    </div>
                    <div class="col-md-4">
                        First Service: <b><span id="d-cus-f-service"></span></b>
                    </div>
                    {{--<div class="col-md-4">
                        <b>Last Service:</b> <span id="d-cus-l-service"></span>
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
                                <th>Date</th>
                                <th>Description</th>
                                <th>Qty</th>
                                <th>Price</th>
                                <th>Amount</th>
                                <th>RO</th>
                                <th>Invoice No</th>
                                <th>Mechanic</th>
                                <th>SA</th>
                                <th>KM</th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                            <tr>
                                <th colspan="4" style="text-align:right"><b>Total:</b></th>
                                <th colspan="6"></th>

                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

        </div>

        {{--Grand total--}}
        {{--<div class="row">
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
                        </tbody>
                    </table>
                </div>
            </div>
        </div>--}}
        {{--<a href="#" class="btn btn-danger" rel="modal:close"><i class="icon-close"></i> Close</a>--}}

    </div>
    {{--List Master Data End--}}

    <input type="hidden" id="delete_id">
@endsection


@section('data')
    <script type="text/javascript">

        //on load display all data
        $(document).ready(function() {
            master('{{ route(config('global.index_link')) }}');

            //add active on nav bar
            $('.no-active6').removeClass('no-active6').addClass('active');
            $('.no-active6-3').removeClass('no-active6-3').addClass('active');
        });

        //Display master table with route
        function master(route,data1) {
            $('#master-table').dataTable({
                "bStateSave": true,
                "lengthMenu": [[50, 100, 500, -1], [50, 100, 500, "All"]],
                "iDisplayLength" : 50,
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
                    total_sale = api
                        .column( 3, { page: 'current'} )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );

                    total_due = api
                        .column( 4, { page: 'current'} )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );

                    // Update footer
                    $( api.column( 3 ).footer() ).html(
                        '<b>$'+parseFloat(total_sale).format(2) +'</b>'
                    );

                    $( api.column( 4 ).footer() ).html(
                        '<b>$'+parseFloat(total_due).format(2) +'</b>'
                    );
                },
                "ajax": {
                    "url": route,
                    "type": "POST",
                    "data":{
                        "_token":"<?=csrf_token()?>",
                        "data1":data1
                    }
                },
                "columns": [
                    { "data": "id_number", "render":function (data) {
                        return '<a class="link-color" href="javascript:void(0)"> '+data+' </a>';
                    }},
                    { "data": "name","render":function (data) {
                        return data;
                    }},
                    { "data": "plate_no", name:'v.plate_no'},
                    { "data": "total_sale"},
                    { "data": "due"}
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
                //show N/A if empty
                var cus_name = show_na_empty(table.row(this).data().name);
                var plate_no = show_na_empty(table.row(this).data().plate_no);
                var tel = show_na_empty(table.row(this).data().tel);
                var id_number=show_na_empty(table.row(this).data().id_number);
                var address=show_na_empty(table.row(this).data().address);
                var email=show_na_empty(table.row(this).data().email);
                var v_model=show_na_empty(table.row(this).data().vm_name);
                var year=show_na_empty(table.row(this).data().year);
                var first_service=show_na_empty(table.row(this).data().first_service);
                var last_service=show_na_empty(table.row(this).data().last_service);

                //List detail Start
                var custype = "";

                if (plate_no!='N/A'){
                    custype = "Plate No";
                    $('#d-cus-id').html(plate_no);
                }else if (cus_name!='N/A') {
                    custype = "Customer Name";
                    $('#d-cus-id').html(cus_name);
                }else {
                    custype = "Customer ID";
                    $('#d-cus-id').html(cus_name);
                }
                //display master data start
                $('#d-cus-type').html(custype);
                $('#d-cus-id-num').html(id_number);
                $('#d-cus-con-num').html(tel);
                $('#d-cus-address').html(address);
                $('#d-cus-name').html(address);
                $('#d-cus-email').html(email);
                $('#d-cus-v-model').html(v_model);
                $('#d-cus-v-plate-no').html(plate_no);
                $('#d-cus-v-year').html(year);
                $('#d-cus-f-service').html(first_service);
                $('#d-cus-l-service').html(last_service);
                //display master data end

                //table start
                detail('{{route('customer_detail.get_data')}}',table.row(this).data().id);
                //table start

                //display grand total
                var grand_total=show_na_empty(table.row(this).data().total_amount);

                if (grand_total=='NaN'||grand_total==''){
                    $('#grand-total').html('$0.00');
                }else{
                    $('#grand-total').html(grand_total);
                }
                //List detail End

                var $cell=$(evt.target).closest('td');
                if( $cell.index()==0){
                    $('#view').modal('show');
                }
            });
        });

        //Display detail start
        function detail(route,data1,data2) {
            n=0;
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
                    total_amount = api
                        .column( 4, { page: 'current'} )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );

                    // Update footer
                    $( api.column( 4 ).footer() ).html(
                        '<b>$'+parseFloat(total_amount).format(2) +'</b>'
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
                    { "data": "date","render":function (data,type,all) {
                        n++;
                        if (n>1){
                            if (invoice_cus==all.invoice_id){
                                show=0;
                                return '';
                            }else{
                                invoice_cus=all.invoice_id;
                                show=1;
                                return '<i class="icon icon-timer"></i> '+data+'';
                            }
                        }else{
                            invoice_cus=all.invoice_id;
                            show=1;
                            return '<i class="icon icon-timer"></i> '+data+'';
                        }


                    }},
                    { "data": "des", "render":function (data) {
                        return '<span class="font-btb">'+data+'</span>';
                    }},
                    { "data": "qty" },
                    { "data": "price"},
                    { "data": "total"},
                    { "data": "ro", "render":function (data) {

                        if (show==1){
                            return data;
                        }else{
                            return '';
                        }

                    }},
                    { "data": "invoice_no", "render":function (data) {
                        if (show==1){
                            return data;
                        }else{
                            return '';
                        }
                    }},
                    { "data": "mechanic", "render":function(data){
                        if (show==1){
                            return data;
                        }else{
                            return '';
                        }
                    }},
                    { "data": "sa", "render":function(data){
                        if (show==1){
                            return data;
                        }else{
                            return '';
                        }
                    }},
                    { "data": "km", "render": function(data){
                        if (show==1){
                            return data;
                        }else{
                            return '';
                        }
                    }}
                ],
                fixedColumns: true,
                responsive: true
            });
        }
        //Display detail end

        //on change data on table scroll to top
        $('#master-table').on('draw.dt', function() {
            scroll_to_top(55);
        });
    </script>
@endsection
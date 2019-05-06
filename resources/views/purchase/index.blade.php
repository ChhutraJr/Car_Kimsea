@extends('master')
@section('content')
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
                                                <th>Purchase Date</th>
                                                <th>Reference No</th>
                                                <th>Supplier</th>
                                                {{--<th>Purchase Status</th>--}}
                                                <th>Payment Status</th>
                                                <th>Total Amount</th>
                                                <th>Payment Due</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>

                                            <tbody>
                                            </tbody>

                                            <tfoot>
                                            <tr>
                                                <th colspan="4" style="text-align:right"><b>Total:</b></th>
                                                <th></th>
                                                <th colspan="2"></th>
                                            </tr>
                                            </tfoot>
                                        </table>
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

        {{--Permission Start--}}
        @if (config('global.add_purchase'))
        <!--Add New Button-->
        <a href="{{url(config('global.add_new_link'))}}" class="btn-fab btn-fab-md fab-right fab-right-bottom-fixed shadow btn-primary"><i
                    class="icon-add"></i></a>
        @endif
        {{--Permission End--}}
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
                            <tfoot>
                            <tr>
                                <th colspan="3" style="text-align:right"><b>Total:</b></th>
                                <th></th>
                                <th></th>
                                <th></th>
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
                            <th width="205px">Grand Total Cost:</th>
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

    {{--Add Payment Start--}}
    <div id="view3" class="modal modal-xl">
        <div class="row">
            <div class="col-md-12">
                <h3>Add or edit payment</h3>
                <hr>
                <div class="row">
                    <div class="col-md-4">
                        <b>Reference No:</b> <span id="p-reference-no2"></span>
                    </div>
                    <div class="col-md-4">
                        <b>Supplier:</b> <span id="p-supplier2"></span>
                    </div>
                    <div class="col-md-4">
                        <b>Date:</b> <span id="p-date2"></span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <b>Payment Status:</b> <span id="p-payment2"></span>
                    </div>
                    {{--<div class="col-md-4">
                        <b>Purchase Status:</b> <span id="p-purchase2"></span>
                    </div>--}}
                </div>

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
    @php $total_detail=Liseng::getSumPurchaseDetail(); @endphp
@endsection

@section('data')
    <script type="text/javascript">

        //on load display all data
        $(document).ready(function() {
            //add filter date with first master date
            filter_date(moment('{{config('global.start_date')}}'),moment());

            //display master table server side
            master('{{ route(config('global.index_link')) }}');

            //add active on nav bar
            $('.no-active7').removeClass('no-active7').addClass('active');
            $('.no-active7-1').removeClass('no-active7-1').addClass('active');
        });

        //on change date range picker
        $(function() {

            //Mon Aug 13 2018 18:31:11 GMT+0700
            // anlert(momet());
            $('#reportrange').on('apply.daterangepicker', function(ev, picker) {
                console.log(picker.startDate.format('YYYY-MM-DD'));
                console.log(picker.endDate.format('YYYY-MM-DD'));
            });

        });

        //Display master table with route
        function master(route,data1,data2,data3) {
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

                    total_remaining = api
                        .column( 5, { page: 'current'} )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );

                    // Update footer
                    $( api.column( 4 ).footer() ).html(
                        '<b>$'+parseFloat(total_amount).format(2) +'</b>'
                    );

                    $( api.column( 5 ).footer() ).html(
                        '<b>$'+parseFloat(total_remaining).format(2) +'</b>'
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
                    {"data": "ref_no"},
                    {"data": "sup_name", name: "supplier.name"},
                  /*  { "data": "purchase_status","render":function (data) {
                        if (data=='Recieved'){
                            var type='<span class="badge badge-success r-3">'+data+'</span>';
                        }else{
                            var type='<span class="badge badge-danger r-3">'+data+'</span>';
                        }
                        return type;
                    }},*/
                    { "data": "payment_status","render":function (data) {
                        if (data=='Paid'){
                            var type='<span class="badge badge-success r-3">'+data+'</span>';
                        }else if(data=='Due'){
                            var type='<span class="badge badge-danger r-3">'+data+'</span>';
                        }else{
                            var type='<span class="badge badge-primary r-3">'+data+'</span>';
                        }
                        return type;
                    }},
                    {"data": "total_amount"},
                    {"data": "payment_due"},
                    { "data": "id", "render": function (data)
                    {

                        var edit='';
                        var del='';
                        var add_payment='';

                        var view='<a class="dropdown-item" href="#view" rel="modal:open"> <i class="icon icon-eye mg-r3"></i>View</a>';

                        //Permission Start
                        @if(config('global.update_purchase'))
                        var edit='<a class="dropdown-item" href="{{url(config('global.update_link'))}}'+'/'+data+'"><i class="icon icon-pencil mg-r3"></i> Edit</a>';
                        @endif
                        //Permission End

                        //Permission Start
                        @if(config('global.delete_purchase'))
                        var del='<a class="master-delete dropdown-item" href="javascript:void(0)" data-toggle="modal" data-target="#delete"><i class="icon icon-trash icon-delete-action mg-r4"></i> Delete</a>';
                        @endif
                        //Permission End

                        var print='<a class="dropdown-item" href={{url(config('global.print_link'))}}'+'/'+data+' rel="modal:open"> <i class="icon icon-print mg-r6" ></i>Print</a>';

                        //Permission Start
                        @if(config('global.add_purchase'))
                        var add_payment='<a class="dropdown-item" href="#view3" rel="modal:open"> <i class="icon icon-money mg-r6" ></i>Add or edit Payment</a>';
                        @endif
                        //Permission End

                        var view_payment='<a class="dropdown-item" href="#view2" rel="modal:open"> <i class="icon icon-money mg-r6" ></i>View Payments</a>';

                        var action='<div class="dropdown" ><button class="btn btn-primary dropdown-toggle btn-xs" type="button" data-toggle="dropdown">Actions<span class="caret"></span></button> <div class="dropdown-menu dropdown-action shadow dropdown-width-pur" > '+view+' '+edit+'  '+del+' <hr class="hr-dropdown"> '+add_payment+' '+view_payment+' </div> </div>';
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

                //fill table detail
                detail('{{route('purchase_detail.get_data')}}',id);
                //fill table detail end

                //display grand total
                var grand_total=show_na_empty(table.row(this).data().total_amount);

                if (grand_total=='NaN'||grand_total==''){
                    $('#grand-total').html('$0.00');
                }else{
                    $('#grand-total').html(grand_total);
                }
                //List detail End
                
                //list payment start
                $('#p-reference').html(reference_no);
                $('#p-reference-no').html(reference_no);
                $('#p-supplier').html(supplier);
                $('#p-date').html(date);
                $('#p-payment').html(payment);
                $('#p-purchase').html(purchase);
                //list payment end
                
                //only run if column smaller than action
                var $cell=$(evt.target).closest('td');
                if( $cell.index()<6){
                    $('#view').modal('show');
                }
                
                //only run if click on payment status
                if($cell.index()==3){
                    //show modal payment
                    $('#view2').modal('show');
                    //display all payment invoice
                    detail2('{{route('purchase_payment.get_data')}}',id);
                }
                
                //only run if click on action
                if($cell.index()==6){
                    //display all payment invoice
                    detail2('{{route('purchase_payment.get_data')}}',id);
                }
                
                //add or edit payment start
                
                //display master data
                $('#p-reference2').html(reference_no);
                $('#p-reference-no2').html(reference_no);
                $('#p-supplier2').html(supplier);
                $('#p-date2').html(date);
                $('#p-payment2').html(payment);
                $('#p-purchase2').html(purchase);
                
                var url_req="{{url('purchase-detail/payment')}}/"+id;
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
                //var id=get_id_by_index('index-table','master-table');

                //get id
                var id=$('#delete_id').val();

                //delete master by id
                master_delete_with_alert(
                    '{{config('global.alert_delete_title')}}', //Alert message
                    '{{route(config('global.delete_link'))}}', //route to delete
                    id, //delete route with this id
                    '{{csrf_token()}}', //send token key for security purpose
                    '{{config('global.after_delete_text')}}', //alert message after delete
                    '{{config('global.cant_delete_text')}}', //alert message if can't delete
                    '{{ route(config('global.index_link')) }}'
                );

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
                    url: "{{route('delete_payment.purchase')}}",
                    data: {
                        "_token": "<?=csrf_token()?>",
                        'purchase_id': $('#delete_id').val()
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
                        url: "{{route('store_payment_multi.purchase')}}",
                        data: {
                            "_token": "<?=csrf_token()?>",
                            'date': date,
                            'amount': amount,
                            'note': note,
                            'purchase_id': $('#delete_id').val()
                        },
                        success: function (data) {
                            //console.log(data);

                            if (data.verify=='true'){
                                swal_alert_autoclose('Saved','This payment have been saved.','success',1500,false);
                                //display master table server side
                                master('{{ route(config('global.index_link')) }}');
                            }
                        }
                    });

                }
                //Add payment to db end
            });
        });
        //Add Payment End

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
                "footerCallback": function ( row, data, start, end, display ) {
                    var api = this.api(), data;
//                    grand_total_amount=data.grand_total_amount;

                    // Remove the formatting to get integer data for summation
                    var intVal = function ( i ) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '')*1 :
                            typeof i === 'number' ?
                                i : 0;
                    };

                    // Total over this page
                    total_subtotal = api
                        .column( 3, { page: 'current'} )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );

                    total_profit = api
                        .column( 4, { page: 'current'} )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );

                    total_sell_price = api
                        .column( 5, { page: 'current'} )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );

                    // Update footer
                    $( api.column( 3 ).footer() ).html(
                        '<b>$'+parseFloat(total_subtotal).format(2) +'</b>'
                    );
                    $( api.column( 4 ).footer() ).html(
                        '<b>$'+parseFloat(total_profit).format(2) +'</b>'
                    );
                    $( api.column( 5 ).footer() ).html(
                        '<b>$'+parseFloat(total_sell_price).format(2) +'</b>'
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
                    { "data": "pro", "render":function (data,type,all) {
                        return '<span class="font-btb">'+data+' ('+all.code_part+')';+'</span>';
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
            master('{{ route('purchase.get_data_filter_date') }}',start,end,type);
        });

        //on change data on table scroll to top
        $('#master-table').on('draw.dt', function() {
            scroll_to_top(55);
        });

    </script>
@endsection

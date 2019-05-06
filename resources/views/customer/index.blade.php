@extends('master')
@section('content')


{{--    <style>

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

                                                                <div class="col-md-2">
                                                                    <div class="form-group">
                                                                        <label for="Type"><h6>Type:</h6></label>
                                                                        <select class="custom-select no-search select2" name="model" id="filter-type">
                                                                            <option value="">All</option>
                                                                            <option value="new">New</option>
                                                                            <option value="gold">Gold</option>
                                                                            <option value="silver">Silver</option>
                                                                            <option value="red">Red</option>

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
                                                <th>ID</th>
                                                <th>Customer Name</th>
                                                <th>Plate No</th>
                                                <th>Contact Number</th>
                                                <th>Contact Address</th>
                                                <th>Vehicle Model</th>
                                                <th>Vehicle Color</th>
                                                {{--<th>Total Services</th>--}}
                                                {{--<th>Total Amount</th>--}}
                                                <th>Last Service</th>
                                                <th>Follow Up</th>
                                                <th>Type</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>

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
        @if(config('global.add_customer'))
        <!--Add New Button-->
        <a href="{{url(config('global.add_new_link'))}}" class="btn-fab btn-fab-md fab-right fab-right-bottom-fixed shadow btn-primary"><i
                    class="icon-add"></i></a>
        @endif
        {{--Permission End--}}
    </div>

    <!-- Detail Modal -->

    {{--<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg ultra">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Detail Of Owner/User</h4>
                    <button type="button" class="close text-right" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row" style="list-style: none">
                        <div class="col-md-4">
                            <li>Owner/Username :</li>
                            <li>Brand/Make :</li>
                            <li>Start Counter :</li>
                            <li>Plate No :</li>
                        </div>
                        <div class="col-md-4">
                            <li>Contact Address :</li>
                            <li>Model :</li>
                            <li>Year :</li>
                            <li>Vin :</li>
                        </div>
                        <div class="col-md-4">
                            <li>Contact Number :</li>
                            <li>Model Engine :</li>
                            <li>Engine No :</li>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-hover data-tables text-center"
                                   data-options='{"searching":true}'>
                                <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Description</th>
                                    <th>QTY</th>
                                    <th>Price</th>
                                    <th>Amount</th>
                                    <th>Check KM</th>
                                    <th>Next Check</th>
                                    <th>Receipt</th>
                                    <th>Invoice</th>
                                    <th>Mechanic</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-raised btn-primary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>--}}

    {{--Close Detail Modal--}}

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

    {{--List Follow Up Start--}}
    <div id="view2" class="modal modal-xl">
        <div class="row">
            <div class="col-md-12">
                <h3>View Follow Ups (<span id="f-cus-type"></span>: <span id="f-cus-id"></span>)</h3>
                <hr>

                <div class="row">
                    <div class="col-md-4">
                        Customer ID: <b><span id="f-cus-id-num"></span></b>
                    </div>
                    <div class="col-md-4">
                        Customer Name: <b><span id="f-cus-name"></span></b>
                    </div>
                    <div class="col-md-4">
                        Contact Number: <b><span id="f-cus-con-num"></span></b>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        Address: <b><span id="f-cus-address"></span></b>
                    </div>
                    <div class="col-md-4">
                        Email: <b><span id="f-cus-email"></span></b>
                    </div>
                    <div class="col-md-4">
                        Vehicle Model: <b><span id="f-cus-v-model"></span></b>
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-4">
                        Plate No: <b><span id="f-cus-v-plate-no"></span></b>
                    </div>
                    <div class="col-md-4">
                        Year: <b><span id="f-cus-v-year"></span></b>
                    </div>
                      <div class="col-md-4">
                          First Service: <b><span id="f-cus-f-service"></span></b>
                      </div>
                    {{--<div class="col-md-4">
                        <b>Last Service:</b> <span id="f-cus-l-service"></span>
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
                                <th class="" width="25%">Follow Up Date</th>
                                <th class="" width="25%">Call Date</th>
                                <th class="text-center">Feedback</th>
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
    {{--List Follow Up End--}}

    {{--Detail End--}}

    {{--Add Follow Up Start--}}
    <div id="view3" class="modal modal-xl">
        <div class="row">
            <div class="col-md-12">
                <h3>Add or edit follow up</h3>
                <hr>
                <div class="row">
                    <div class="col-md-4">
                        Customer ID: <b><span id="f-cus-id-num2"></span></b>
                    </div>
                    <div class="col-md-4">
                        Customer Name: <b><span id="f-cus-name2"></span></b>
                    </div>
                    <div class="col-md-4">
                        Contact Number: <b><span id="f-cus-con-num2"></span></b>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        Address: <b><span id="f-cus-address2"></span></b>
                    </div>
                    <div class="col-md-4">
                        Email: <b><span id="f-cus-email2"></span></b>
                    </div>
                    <div class="col-md-4">
                        Vehicle Model: <b><span id="f-cus-v-model2"></span></b>
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-4">
                        Plate No: <b><span id="f-cus-v-plate-no2"></span></b>
                    </div>
                    <div class="col-md-4">
                        Year: <b><span id="f-cus-v-year2"></span></b>
                    </div>
                      <div class="col-md-4">
                          First Service: <b><span id="f-cus-f-service2"></span></b>
                      </div>
                  {{--  <div class="col-md-4">
                        <b>Last Service:</b> <span id="f-cus-l-service2"></span>
                    </div>--}}
                </div>
            </div>
        </div>
        {{--Table Start--}}
        <div class="row">
            <div class="col-md-12" >
                <div class="card-body2 slimScroll pd-t-20" data-height="100%">
                                    <div class="table-responsive">
                                        <table id="follow-up-table" class="table table-striped table-bordered" cellspacing="0" width="100%" data-options='{"searching":true}'>
                                            <thead>
                                            <tr class="" style="border-bottom: none !important;">
                                                <th style="display: none"></th>
                                                <th width="4%"><a href='javascript:void(0)'><i id="add-new" class='icon icon-add add-icon'></i></a></th>
                                                <th class="" width="24%">Follow Up Date</th>
                                                <th class="" width="24%">Call Date</th>
                                                <th class="text-center">Feedback</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>

                                </div>

                <hr>

                <div style="text-align: right">
                    <button type="button" class="btn btn-primary btn-lg" style="margin: 0px 0px 15px 0px;" id="btn-save-fu" ><i class="icon-save mr-2"></i>Save</button>
                </div>
            </div>
        </div>
        {{--Table End--}}

    </div>
    {{--Add Follow Up End--}}

    {{--For delete--}}
    <input type="hidden" id="delete_id">
@endsection

@section('data')
    <script type="text/javascript">

    //on load display all data
    $(document).ready(function() {
        //add filter date with first master date
        filter_date(moment('{{config('global.start_date')}}'),moment());

        //display master table server side
        master('{{ route(config('global.index_link')) }}','{{config('global.cus_id')}}');

        //add active on nav bar
        $('.no-active2').removeClass('no-active2').addClass('active');
        $('.no-active2-1').removeClass('no-active2-1').addClass('active');
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
                { "data": "id_number"},
                { "data": "name"},
                { "data": "plate_no", name: "v.plate_no"},
                { "data": "tel"},
                { "data": "address"},
                { "data": "vm_name", name: "vm.name"},
                { "data": "vc_name", name: "vc.name"},
                { "data": "last_service","render":function (data) {

                    if (data!=''&&data!=null){
                        return '<i class="icon icon-timer"></i> '+data+'';
                    }

                    return '';
                }},
                { "data": "follow_up"},
                { "data": "type","render":function (data) {
                    var type;
                    if (data=='New'){
                        type='<span class="badge badge-success r-3">'+data+'</span>';
                    }else if(data=='Gold'){
                        type='<span class="badge badge-gold r-3">'+data+'</span>';
                    }else if(data=='Silver'){
                        type='<span class="badge badge-silver r-3">'+data+'</span>';
                    }else{
                        type='<span class="badge badge-danger r-3">'+data+'</span>';
                    }

                    return type;

                }},
                { "data": "id", "render": function (data)
                {
                    /*
                     var action = '';
                     action += '<a class="btn btn-primary btn-xs btn-edit" href="{url('/product-supplier/update/')}}'+'/'+data+'"><i class="icon-pencil "></i> Edit</a>'+' ';
                     action += '<a class="btn btn-danger btn-xs btn-delete" href="javascript:void(0)" data-toggle="modal" data-target="#delete"><i class="icon-trash icon-delete-action"></i> Delete</a>';
                     return action;*/
                    var view='<a class="dropdown-item" href="#view" rel="modal:open"> <i class="icon icon-eye "></i> View</a>';
                    var edit='';
                    var del='';
                    var add_follow_up='';

                    //Permission Start
                    @if(config('global.update_customer'))
                        edit='<a class="dropdown-item" href="{{url(config('global.update_link'))}}'+'/'+data+'"><i class="icon icon-pencil mg-r3"></i> Edit</a>';
                    @endif
                    //Permission End


                    //Permission Start
                    @if(config('global.delete_customer'))
                        del='<a class="master-delete dropdown-item" href="javascript:void(0)" data-toggle="modal" data-target="#delete"><i class="icon icon-trash icon-delete-action mg-r3"></i> Delete</a>';
                    @endif
                    //Permission End
                    var excel='<a class="dropdown-item" target="_blank" href="{{url('/customer-services/export/')}}'+'/'+data+'"> <i class="icon icon-eye mg-r3"></i>Export</a>';


                    //Permission Start
                    @if(config('global.add_customer'))
                        add_follow_up='<a class="dropdown-item" href="#view3" rel="modal:open"><i class="icon icon-clock-o mg-r6"></i>Add or edit Follow Up</a>';
                    @endif

                    var edit='<a class="dropdown-item" href="{{url(config('global.update_link'))}}'+'/'+data+'"><i class="icon icon-pencil mg-r3"></i> Edit</a>';
                    var del='<a class="master-delete dropdown-item" href="javascript:void(0)" data-toggle="modal" data-target="#delete"><i class="icon icon-trash icon-delete-action mg-r4"></i> Delete</a>';
                    var excel_kh='<a class="dropdown-item" target="_blank" href="{{url('/customer-services/export/khmer')}}'+'/'+data+'"> <i class="icon icon-file-excel-o excel-icon mg-r3"></i>Export Khmer</a>';
                    var excel_en='<a class="dropdown-item" target="_blank" href="{{url('/customer-services/export/english/')}}'+'/'+data+'"> <i class="icon icon-file-excel-o excel-icon mg-r3"></i>Export English</a>';
                    var view_follow_up='<a class="dropdown-item" href="#view2" rel="modal:open"><i class="icon icon-clock-o mg-r6" ></i>View Follow Ups</a>';
                    var print_ro='<a class="dropdown-item" target="_blank" href="{{url('customers/print-ro/')}}'+'/'+data+'" > <i class="icon icon-print mg-r6" ></i>Receipt Order</a>';
                    var add_sale='<a class="dropdown-item" href="{{url('/invoice/create/')}}'+'/'+data+'"> <i class="icon icon-arrow-circle-o-up mg-r7"></i>Add new invoice</a>';

                    //var action='<div class="dropdown"><button class="btn btn-primary dropdown-toggle btn-xs" type="button" data-toggle="dropdown">Actions<span class="caret"></span></button> <div class="dropdown-menu dropdown-action shadow dropdown-width-cus"> '+view+' '+edit+' '+del+' '+excel_kh+' '+excel_en+' '+print_ro+' '+add_sale+' <hr class="hr-dropdown"> '+add_follow_up+' '+view_follow_up+' </div> </div>';

                    var action='<div class="dropdown"><button class="btn btn-primary dropdown-toggle btn-xs" type="button" data-toggle="dropdown">Actions<span class="caret"></span></button> <div class="dropdown-menu dropdown-action shadow dropdown-width-cus"> '+view+' '+edit+' '+del+' '+excel_kh+' '+excel_en+' '+print_ro+' '+add_sale+' <hr class="hr-dropdown"> '+add_follow_up+' '+view_follow_up+'</div> </div>';

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

            //list follow up start
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

            var custype = "";

            if (plate_no!='N/A'){
                custype = "Plate No";
                $('#d-cus-id').html(plate_no);
                $('#f-cus-id').html(plate_no);
            }else if (cus_name!='N/A') {
                custype = "Customer Name";
                $('#d-cus-id').html(cus_name);
                $('#f-cus-id').html(cus_name);
            }else {
                custype = "Customer ID";
                $('#d-cus-id').html(id_number);
                $('#f-cus-id').html(id_number);
            }

            //display master data
            $('#f-cus-type').html(custype);
            $('#f-cus-id-num').html(id_number);
            $('#f-cus-name').html(cus_name);
            $('#f-cus-con-num').html(tel);
            $('#f-cus-address').html(address);
            $('#f-cus-email').html(email);
            $('#f-cus-v-model').html(v_model);
            $('#f-cus-v-plate-no').html(plate_no);
            $('#f-cus-v-year').html(year);
            $('#f-cus-f-service').html(first_service);
            $('#f-cus-l-service').html(last_service);


            //list follow up end

            //set id to delete
            $('#delete_id').val(id);

            //only run if column smaller than follow up and type
            var $cell=$(evt.target).closest('td');
            if( $cell.index()<8||$cell.index()==9){
                $('#view').modal('show');
            }

            //only run if click on follow up
            if($cell.index()==8){
                //show modal follow up
                $('#view2').modal('show');
                //display all follow up customer
                detail2('{{route('follow_up.get_data')}}',id);

            }

            //only run on action
            if ($cell.index()==10){
                //display all follow up customer
                detail2('{{route('follow_up.get_data')}}',id);
            }
            //add or edit follow up start

            //display master data
            $('#f-cus-id-num2').html(id_number);
            $('#f-cus-name2').html(cus_name);
            $('#f-cus-con-num2').html(tel);
            $('#f-cus-address2').html(address);
            $('#f-cus-email2').html(email);
            $('#f-cus-v-model2').html(v_model);
            $('#f-cus-v-plate-no2').html(plate_no);
            $('#f-cus-v-year2').html(year);
            $('#f-cus-f-service2').html(first_service);
            $('#f-cus-l-service2').html(last_service);

            //add or edit follow up start
            var url_req="{{url('customer-detail/follow-up')}}/"+id;
            $.get(url_req,function (data) {
                //remove table data
                $("#follow-up-table > tbody").html("");

                //if empty follow up
                if (data.follow_up.length==0){

                    var fu_id=0;
                    var follow_up_date='<div class="input-group date date_picker" data-provide="datepicker"> <div class="input-group-addon"> <span class="icon icon-calendar"></span> </div> <input type="text" class="form-control follow_up_date'+fu_id+'" placeholder="Select None">  </div>';
                    var call_date='<div class="input-group date date_picker" data-provide="datepicker"> <div class="input-group-addon"> <span class="icon icon-calendar"></span> </div> <input type="text" class="form-control call_date'+fu_id+'" placeholder="Select None">  </div>';

                    //display default field
                    $('#follow-up-table').append("<tr class=' pro-remove product" + fu_id + "'> + <!--ID--> <td style='display: none'><input type='hidden' value='"+fu_id+"'></td> <!--Remove button--> <td><a class='remove' data-id='" + fu_id + "' data-name='" + fu_id + "' href='javascript:void(0)'><i class='icon icon-cancel rm-icon '></i></a> </td>+ <!--Follow Up Date--> <td>"+follow_up_date+"</td> <!--Call Date-->  <td>"+call_date+"</td>  <!--Feedback-->  <td><input name='feedback' type='text' class='form-control feedback"+fu_id+"' placeholder='Feedback' ></td>  </tr>");

                    //modify date picker format again to make it work
                    $(function(){
                        $('.date_picker').datepicker({
                            format: 'dd/M/yyyy',
                            todayHighlight:'TRUE',
                            autoclose: true
                        });
                    });

                }else{
                    for (var i = 0; i < data.follow_up.length; i++) {

                        //add id to table
                        var fu_id=data.follow_up[i].id;

                        //format follow up date
                        var follow_up_date = $.datepicker.formatDate("dd/M/yy", new Date(data.follow_up[i].follow_up_date));
                        //change to null if follow up date is empty
                        if (data.follow_up[i].follow_up_date==''||data.follow_up[i].follow_up_date==null){
                            follow_up_date='';
                        }

                        //format call date
                        var call_date=$.datepicker.formatDate("dd/M/yy", new Date(data.follow_up[i].call_date));
                        //change to null if call date is empty
                        if (data.follow_up[i].call_date==''||data.follow_up[i].call_date==null){
                            call_date='';
                        }

                        //add follow up date to table
                        follow_up_date='<div class="input-group date date_picker" data-provide="datepicker"> <div class="input-group-addon"> <span class="icon icon-calendar"></span> </div> <input type="text" class="form-control follow_up_date'+fu_id+'" placeholder="Select None" value="'+follow_up_date+'">  </div>';
                        //add call date to table
                        call_date='<div class="input-group date date_picker" data-provide="datepicker"><div class="input-group-addon"> <span class="icon icon-calendar"></span> </div> <input type="text" class="form-control call_date'+fu_id+'" placeholder="Select None" value="'+call_date+'">  </div>';

                        //add feedback to table
                        var feedback=data.follow_up[i].feedback;

                        //change to '' if null
                        if(feedback==''||feedback==null){
                            feedback='';
                        }

                        //display table database
                        $('#follow-up-table').append("<tr class=' pro-remove product" + fu_id + "'> + <!--ID--> <td style='display: none'><input type='hidden' value='"+fu_id+"'></td> <!--Remove button--> <td><a class='remove' data-id='" + fu_id + "' data-name='" + fu_id + "' href='javascript:void(0)'><i class='icon icon-cancel rm-icon '></i></a> </td>+ <!--Follow Up Date--> <td>"+follow_up_date+"</td> <!--Call Date-->  <td>"+call_date+"</td>  <!--Feedback-->  <td><input name='feedback' type='text' class='form-control feedback"+fu_id+"' placeholder='Feedback' value='"+feedback+"'></td>  </tr>");

                        //modify date picker format agian to make it work
                        $(function(){
                            $('.date_picker').datepicker({
                                format: 'dd/M/yyyy',
                                todayHighlight:'TRUE',
                                autoclose: true,
                            });
                        });

                    }
                }
            });
            //add or edit follow up

            //List detail Start

            //display master data start
            $('#d-cus-type').html(custype);
            $('#d-cus-id-num').html(id_number);
            $('#d-cus-con-num').html(tel);
            $('#d-cus-address').html(address);
            $('#d-cus-name').html(cus_name);
            $('#d-cus-email').html(email);
            $('#d-cus-v-model').html(v_model);
            $('#d-cus-v-plate-no').html(plate_no);
            $('#d-cus-v-year').html(year);
            $('#d-cus-f-service').html(first_service);
            $('#d-cus-l-service').html(last_service);
            //display master data end

            //table start
            detail('{{route('customer_detail.get_data')}}',id);
            //table start

            //display grand total
            var grand_total=show_na_empty(table.row(this).data().total_amount);

            if (grand_total=='NaN'||grand_total==''){
                $('#grand-total').html('$0.00');
            }else{
                $('#grand-total').html(grand_total);
            }
            //List detail End

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
        var row_count = $('#follow-up-table >tbody >tr').length;

        //get old id
        var old_id=parseInt($('#follow-up-table tr').eq(row_count).find('td').eq(0).find("input").val());
        //get old cus name
//        var cus_name=$('#follow-up-table tr').eq(row_count).find('td').eq(2).html();

        var fu_id=old_id+1;
        var follow_up_date='<div class="input-group date date_picker" data-provide="datepicker"> <div class="input-group-addon"> <span class="icon icon-calendar"></span> </div> <input type="text" class="form-control follow_up_date'+fu_id+'" placeholder="Select None">  </div>';
        var call_date='<div class="input-group date date_picker" data-provide="datepicker"> <div class="input-group-addon"> <span class="icon icon-calendar"></span> </div> <input type="text" class="form-control call_date'+fu_id+'" placeholder="Select None">  </div>';

        //display default field
        $('#follow-up-table').append("<tr class=' pro-remove product" + fu_id + "'> + <!--ID--> <td style='display: none'><input type='hidden' value='"+fu_id+"'></td> <!--Remove button--> <td><a class='remove' data-id='" + fu_id + "' data-name='" + fu_id + "' href='javascript:void(0)'><i class='icon icon-cancel rm-icon '></i></a> </td>+ <!--Follow Up Date--> <td>"+follow_up_date+"</td> <!--Call Date-->  <td>"+call_date+"</td>  <!--Feedback-->  <td><input name='feedback' type='text' class='form-control feedback"+fu_id+"' placeholder='Feedback' ></td>  </tr>");

        //anitialize date picker format agian to make it work
        $(function(){
            $('.date_picker').datepicker({
                format: 'dd/M/yyyy',
                todayHighlight:'TRUE',
                autoclose: true,
            });
        });
    });
    //When click on add New Button End

    //When click on remove button
    $(document).on('click', '.remove', function(e) {
        e.preventDefault();

        var rowCount = $('#follow-up-table >tbody >tr').length;
        //if remove on default
        if(rowCount==1){
            //get last id
            var last_id=parseInt($('#follow-up-table tr').eq(rowCount).find('td').eq(0).find("input").val());
            //reset all to default
            $('.follow_up_date'+last_id).val('');
            $('.call_date'+last_id).val('');
            $('.feedback'+last_id).val('');
        }else{
            $('.product' + $(this).data('id')).remove();
        }

    });

    //When click on button End

    //Add follow up Start
    $(document).ready(function() {
        $('#btn-save-fu').click(function () {

            //Delete current follow up start
            $.ajax({
                type: 'post',
                url: "{{route('delete_detail.follow_up')}}",
                data: {
                    "_token": "<?=csrf_token()?>",
                    'cus_id': $('#delete_id').val()
                },
                success: function (data) {
                }
            });
            //Delete current follow up end

            //Add follow up to db start
            var rowCount = $('#follow-up-table >tbody >tr').length;
            //loop every field in table to get value by index
            for (var i = 1; i < rowCount + 1; i++) {

                //get follow up date
                var follow_up_date = $('#follow-up-table tr').eq(i).find('td').eq(2).find("input").val();
                //get call date
                var call_date = $('#follow-up-table tr').eq(i).find('td').eq(3).find("input").val();
                //get feedback
                var feedback = $('#follow-up-table tr').eq(i).find('td').eq(4).find("input").val();

                //format date
                follow_up_date = $.datepicker.formatDate("yy-mm-dd", new Date(follow_up_date));
                call_date=$.datepicker.formatDate("yy-mm-dd", new Date(call_date));

                //Add to database
                $.ajax({
                    type: 'post',
                    url: "{{route('store_detail.follow_up')}}",
                    data: {
                        "_token": "<?=csrf_token()?>",
                        'follow_up_date': follow_up_date,
                        'call_date': call_date,
                        'feedback': feedback,
                        'cus_id': $('#delete_id').val()
                    },
                    success: function (data) {
                        //console.log(data);

                        if (data.verify=='true'){
                            swal_alert('Saved','This follow up have been saved.','success');
                            master('{{ route(config('global.index_link')) }}');
                        }
                    }
                });

            }

            //Add follow up to db end
        });

    });

    //Add Follow Up End

  /*  $("#view3").modal({
        closeClass: 'icon-remove',
        closeText: '!'
    });*/

    //Display follow up table with route start
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
                { "data": "follow_up_date","render":function (data) {
                    return '<i class="icon icon-timer"></i> '+data+'';
                }},
                { "data": "call_date","render":function (data) {
                    return '<i class="icon icon-timer"></i> '+data+'';
                }},
                { "data": "feedback"},
            ],
            fixedColumns: true,
            responsive: true
        });
    }
    //Display follow up table with route end

    var invoice_cus=0;
    var n=0;
    var show=0;

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

    //on click apply filters
    $('#btn-apply').click(function () {
        var type=$('#filter-type').val();
        var start=$('#date-range').data('daterangepicker').startDate.format('YYYY-MM-DD');
        var end=$('#date-range').data('daterangepicker').endDate.format('YYYY-MM-DD');

        master('{{ route('customer.get_data_filter') }}',start,end,type);
    });


    //on change data on table scroll to top
    $('#master-table').on('draw.dt', function() {
        scroll_to_top(210);
    });

    </script>
@endsection

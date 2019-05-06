@extends('master')
@section('content')

    <div class="page has-sidebar-left " >
{{--        <header class="blue accent-3 relative no-refresh">
            <div class="container-fluid text-white">
                <div class="row p-t-b-10 ">
                    <div class="col">
                        <h4 class="">
                            <i class="icon-package2"></i>
                            Products
                        </h4>
                    </div>
                </div>

            </div>
        </header>--}}
        <div class="container-fluid animatedParent animateOnce my-3 ">

            @if(!$master->isEmpty())
            {{--Filter--}}
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

                                                                <div class="col-md-3">
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

            {{--Display Master--}}
            <div class="animated fadeInUpShort shadow">
                <div class="row">
                    <div class="col-md-12">
                            <div class="table-responsive">
                                <div class="card">
                                    <div class="card-body2">

                                        <table id="master-table" class="table table-striped table-bordered" cellspacing="0" width="100%" data-options='{"searching":true}' style="cursor: pointer">

                                            <thead>
                                            <tr>
                                                <th>Product</th>
                                                <th>Code Part</th>
                                                <th>Type</th>
                                                <th>Model</th>
                                                <th>Use for</th>
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
            @endif

            {{--If no master--}}
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
        </div>

        @if(config('global.add_product'))
        <!--Add New Button-->
        <a href="{{url(config('global.add_new_link'))}}" class="btn-fab btn-fab-md fab-right fab-right-bottom-fixed shadow btn-primary"><i
                    class="icon-add"></i>
        </a>
        @endif
    </div>


    {{--Detail Start--}}

    {{--Master Data--}}
    <div id="view" class="modal modal-xl">
        <div class="row">
            <div class="col-md-12">
                <h3 class="font-btb"><span id="pro"></span></h3>

                <hr>

                <div class="row">
                    <div class="col-md-4">
                        <b>Product:</b> <span class="font-btb" id="pro-name"></span>
                    </div>
                    <div class="col-md-4">
                        <b>Code Part:</b> <span id="pro-code-part"></span>
                    </div>
                    <div class="col-md-4">
                        <b>Type:</b> <span id="pro-type"></span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <b>Model:</b> <span id="pro-model"></span>
                    </div>
                    <div class="col-md-4">
                        <b>Category:</b> <span id="pro-cat"></span>
                    </div>

                </div>

            </div>
        </div>

        {{--Detail Data--}}
        <div class="row">
            <div class="col-md-12 no-padding-lr" >
                <div class="slimScroll" data-height="400">
                    <div class="table-responsive">
                        <table id="detail-table" class="table table-striped table-bordered" cellspacing="0" width="100%" data-options='{"searching":true}'>

                            <thead>
                            <tr>
                                <th>Date</th>
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

    {{--Detail End--}}

{{--For delete--}}
    <input type="hidden" id="delete_id">
@endsection


@section('data')
    <script type="text/javascript">

        //on load display all data
        $(document).ready(function() {
            //add filter date with first master date
            filter_date(moment('{{config('global.start_date')}}'),moment());
            //display master table serverside
            master('{{ route(config('global.index_link')) }}','{{config('global.pro_id')}}');

            //add active on nav bar
            $('.no-active4').removeClass('no-active4').addClass('active');
            $('.no-active4-1').removeClass('no-active4-1').addClass('active');
        });

        {{--On select date--}}
        $(function() {

            $('#date-range').val('');
            $('#date-range').on('apply.daterangepicker', function(ev, picker) {
                console.log(picker.startDate.format('YYYY-MM-DD'));
                console.log(picker.endDate.format('YYYY-MM-DD'));
            });
        });

        //Display master table with route
        function master(route,data1,data2) {
            $('#master-table').dataTable( {
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
                        "data2":data2
                    }
                },
                "columns": [
                    { "data": "name", "render":function (data) {
                        return '<span class="font-btb">'+data+'</span>';
                    }},
                    { "data": "code_part"},
                    { "data": "type"},
                    { "data": "m_name", name: "m.name"},
                    { "data": "c_name", name: "c.name"},
                    { "data": "id", "render": function (data)
                    {
/*
                        var action = '';
                        action += '<a class="btn btn-primary btn-xs btn-edit" href="{url('/product-supplier/update/')}}'+'/'+data+'"><i class="icon-pencil "></i> Edit</a>'+' ';
                        action += '<a class="btn btn-danger btn-xs btn-delete" href="javascript:void(0)" data-toggle="modal" data-target="#delete"><i class="icon-trash icon-delete-action"></i> Delete</a>';
                        return action;*/
                        var view='<a class="dropdown-item" href="#view" rel="modal:open"> <i class="icon icon-eye mg-r3"></i>View</a>';
                        var edit='';
                        var del='';

                        //Permission Start
                        @if(config('global.update_product'))
                        edit='<a class="dropdown-item" href="{{url(config('global.update_link'))}}'+'/'+data+'"><i class="icon icon-pencil mg-r3 "></i> Edit</a>';
                        @endif
                        //Permission End

                        //Permission Start
                        @if(config('global.delete_product'))
                        del='<a class="master-delete dropdown-item" href="javascript:void(0)" data-toggle="modal" data-target="#delete"><i class="icon icon-trash icon-delete-action mg-r4"></i> Delete</a>';
                        @endif
                        //Permission End

                        var action='<div class="dropdown"><button class="btn btn-primary dropdown-toggle btn-xs" type="button" data-toggle="dropdown">Actions<span class="caret"></span></button> <div class="dropdown-menu dropdown-action shadow"> '+view+' '+edit+' '+del+' </div> </div>';

                        return action;

                    }
                    }

                ],
                fixedColumns: true,
                responsive: true
            });
        }

        //Display detail table with route
        function detail(route,data1) {
            $('#detail-table').dataTable( {
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
                        "data1":data1
                    }
                },
                "columns": [
                    { "data": "created_at","render":function (data) {
                        return '<i class="icon icon-timer"></i> '+data+'';
                    }},
                    { "data": "qty"},
                    { "data": "cost_price"},
                    { "data": "total_cost"},
                    { "data": "profit"},
                    { "data": "sell_price"},


                ],
                fixedColumns: true,
                responsive: true
            });
        }

        //on click table single row
        $(document).ready(function() {
            $('#master-table tbody').on('click', 'tr', function (evt) {
                var table = $('#master-table').DataTable();

                //get id
                var id = table.row(this).data().id;

               //set id to delete
                $('#delete_id').val(id);

                //Display detail
                var pro_name=show_na_empty(table.row(this).data().name);
                var code_part=show_na_empty(table.row(this).data().code_part);
                var pro_type=show_na_empty(table.row(this).data().pro_type);
                var cat=show_na_empty(table.row(this).data().c_name);
                var model=show_na_empty(table.row(this).data().m_name);

                $('#pro').html(pro_name);
                $('#pro-name').html(pro_name);
                $('#pro-code-part').html(code_part);
                $('#pro-type').html(pro_type);
                $('#pro-cat').html(cat);
                $('#pro-model').html(model);

                //only run if column smaller than index last column
                var $cell=$(evt.target).closest('td');
                if( $cell.index()<5){
                    $('#view').modal('show');
                }

                //display detail data
                detail('{{route('product_detail.get_data')}}',id);

                //display grand total
                var url_req="{{url('product_grand_total')}}/"+id;
                $.get(url_req,function (data) {
                    var grand_total=parseFloat(data).format(2);
                    if (grand_total=='NaN'||grand_total==''){
                        $('#grand-total').html('$0.00');
                    }else{
                        $('#grand-total').html('$'+parseFloat(data).format(2));
                    }
                });

                //alert(id);
                //     table.rows( $('#master-table tr.active') ).remove().draw();

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
//                                console.log(data);

                                //alert error if delete = false
                                if (data.delete=='false_invoice'){
                                    swal_alert('Can\'t delete!','The invoices related to this product exist.','error');
                                }else if(data.delete=='false_purchase'){
                                    swal_alert('Can\'t delete!','The purchases related to this product exist.','error');
                                }else{
                                    //alert successful deleted
                                    swal_alert('Deleted','{{config('global.after_delete_text')}}','success');
                                    master('{{ route(config('global.index_link')) }}');
                                }

                            }
                        });


                    });

            }
        };


        //on click apply filters
        $('#btn-apply').click(function () {
            var start=$('#date-range').data('daterangepicker').startDate.format('YYYY-MM-DD');
            var end=$('#date-range').data('daterangepicker').endDate.format('YYYY-MM-DD');

            master('{{ route('product.get_data_filter_date') }}',start,end);
        });


        num_only(['pro_stock']);
        float_only(['pro_price']);

        //on change data on table scroll to top
        $('#master-table').on('draw.dt', function() {
            scroll_to_top(195);
        });
    </script>
@endsection

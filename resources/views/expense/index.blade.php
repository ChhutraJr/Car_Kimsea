@extends('master')
@section('content')
    <div class="page has-sidebar-left">

        <div class="container-fluid animatedParent animateOnce my-3">


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
                                    <div class="col-md-4 b-r p-3">
                                        <h5>Total Amount</h5>
                                        <span id="total-amount-filter" >{{Liseng::total_amount_exp(config('current_page_date'),config('current_page_date'))}} </span>
                                    </div>
                                    <div class="col-md-4 b-r p-3">
                                        <h5>Total Paid</h5>
                                        <span id="total-paid-filter" >{{Liseng::total_paid_exp(config('current_page_date'),config('current_page_date'))}} </span>
                                    </div>
                                    <div class="col-md-4 p-3">
                                        <div class="">
                                            <h5>Total Credit</h5> {{--<span class="amber-text">+87.4</span></h5>--}}
                                            <span id="total-credit-filter">{{Liseng::total_credit_exp(config('current_page_date'),config('current_page_date'))}}</span>
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
                                                <th>Date</th>
                                                <th>Category</th>
                                                <th>Payment Status</th>
                                                <th>Total Amount</th>
                                                <th>Note</th>
                                                <th>Action</th>

                                            </tr>
                                            </thead>
                                            <tfoot>
                                            <tr>
                                                <th colspan="3" style="text-align:right"><b>Total:</b></th>
                                                <th colspan="3"></th>

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

        {{--Permission Start--}}
        @if(config('global.add_expense'))
        <!--Add New Button-->
        <a href="{{url(config('global.add_new_link'))}}" class="btn-fab btn-fab-md fab-right fab-right-bottom-fixed shadow btn-primary"><i
                    class="icon-add"></i>
        </a>
        @endif
        {{--Permission End--}}
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

            filter_date_expense(moment('{{config('current_page_date')}}'),moment('{{config('current_page_date')}}'));

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
            $('.no-active5').removeClass('no-active5').addClass('active');
            $('.no-active5-1').removeClass('no-active5-1').addClass('active');
        });

        //Display master table with route
        function master(route,data1,data2,data3) {
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
                    total_amount = api
                        .column( 3, { page: 'current'} )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );

                    // Update footer
                    $( api.column( 3 ).footer() ).html(
                        '<b>$'+parseFloat(total_amount).format(2) +'</b>'
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
                    { "data": "ec_name", name: "ec.name"},
                    /*{ "data": "cat", "render": function (data,type,all) {
                        if (data=='stock'){
                            return 'Stock'+' ('+'<span style="font-size:12px">'+all.pro+'</span>'+')';
                        }else{
                            return data;
                        }
                    }},*/
                    { "data": "payment_status","render":function (data) {
                        if (data=='Paid'){
                            var type='<span class="badge badge-success r-3">'+data+'</span>';
                        }else{
                            var type='<span class="badge badge-danger r-3">'+data+'</span>';
                        }

                        return type;
                    }},
                    { "data": "total_amount" },
                    { "data": "note" },
                    { "data": "id", "render": function (data)
                    {
                        var action = '';

                        //Permission Start
                        @if(config('global.update_expense'))
                        action += '<a class="btn btn-primary btn-xs btn-edit" href="{{url(config('global.update_link'))}}'+'/'+data+'"><i class="icon-pencil "></i> Edit</a>'+' ';
                        @endif
                        //Permission End

                        //Permission Start
                        @if(config('global.delete_expense'))
                        action += '<a class="btn btn-danger btn-xs btn-delete" href="javascript:void(0)" data-toggle="modal" data-target="#delete"><i class="icon-trash icon-delete-action"></i> Delete</a>';
                        @endif
                        //Permission End
                        return action;
                    }
                    }

                ],
                fixedColumns: true,
                responsive: true
            });
        }

        //on click table single row
        $(document).ready(function() {
            $('#master-table tbody').on('click', 'tr', function () {

                var table = $('#master-table').DataTable();
//                console.log(table.row(this).data());
                $('#delete_id').val(table.row(this).data().id);

                //alert(table.row(this)[0]);
                //     table.rows( $('#master-table tr.active') ).remove().draw();

            });
        });

        //Delete Master
        //on click by target id
        document.body.onclick= function(e){
            e=window.event? event.srcElement: e.target;
            if(e.className && e.className.indexOf('delete')!=-1){
                //alert(id);

                //send sidebar to back side
                refresh();

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

        //on click apply filters
/*        $('#btn-apply').click(function () {
            var type=$('#filter-type').val();

        });*/

        function filter_date_expense(start_date,end_date) {
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
                url: "{{route('expense.get_data_by_date')}}",
                data: {
                    "_token": "<?=csrf_token()?>",
                    'start': $('#start-date').val(),
                    'end': $('#end-date').val()
                },
                success: function (data) {
                    $('#total-amount-filter').html(data.total_amount);
                    $('#total-paid-filter').html(data.total_paid);
                    $('#total-credit-filter').html(data.total_credit);
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
            $('#apply').val('false');
        });
        $(window).on('hashchange',function(){
            page = window.location.hash.replace('#','');

            update_page(page);

        });

        function update_page(page) {
            $.ajax({
                url: '/expense/pagination/' + page,
                type: "get",
                dataType: 'json'
            }).done(function(data){
//                console.log(data);

                var next_page='/expenses?page='+(data.current_page*1+1);
                var pre_page='/expenses?page='+(data.current_page*1-1);


                {{--master('{{ route(config('global.index_link')) }}',data.master_pag.data[0],data.master_pag.data[0]);--}}

  {{--              $('#total-amount-filter').html(data.total_amount);
                $('#total-paid-filter').html(data.total_paid);
                $('#total-credit-filter').html(data.total_credit);

                filter_date_no_all(moment(data.date),moment(data.date));--}}


                $('#start-date').val(data.date);
                $('#end-date').val(data.date);

                filter_date_expense(moment(data.date),moment(data.date));

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

                numbers+='<li class="'+active_page+'"><a class="page-link" href="expenses?page='+p+'">'+p+'</a></li>';
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
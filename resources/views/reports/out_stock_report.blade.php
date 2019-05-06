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
                                            <th>Product</th>
                                            <th>Code Part</th>
                                            <th>Model</th>
                                            <th>Use For</th>
                                            <th>Qty</th>
                                            <th>Invoice No</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div class="col-md-3">
                                    <a target="_blank" href="{{url('/out_stock/export')}}" class="btn btn-success btn-lg btn-add-sale" style="margin: 0px 13px 15px 0px;"><i class=" icon icon-file-excel-o excel-icon mg-r3"></i> Export To Excel</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


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
            //display master table server side
            master('{{ route(config('global.index_link')) }}');

            //add active on nav bar
            $('.no-active2').removeClass('no-active2').addClass('active');
            $('.no-active2-1').removeClass('no-active2-1').addClass('active');
        });

        //on load display all data
        $(document).ready(function() {
            master('{{ route(config('global.index_link')) }}');

            //add active on nav bar
            $('.no-active6').removeClass('no-active6').addClass('active');
            $('.no-active6-1').removeClass('no-active6-1').addClass('active');
        });

        //Display master table with route
        function master(route,data1,data2) {
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
                        "data2":data2
                    }
                },
                "columns": [
                    { "data": "name",name:"p.name", "render":function (data) {
                        return '<span class="font-btb">'+data+'</span>';
                    }},
                    { "data": "code_part",name:"p.code_part"},
                    { "data": "m_name", name: "m.name"},
                    { "data": "c_name", name: "c.name"},
                    { "data": "qty"},
                    { "data": "invoice_no",name:"inv.invoice_no"}
                ],
                fixedColumns: true,
                responsive: true,

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

        //on click apply filters
        $('#btn-apply').click(function () {
            var type=$('#filter-type').val();
            var start=$('#date-range').data('daterangepicker').startDate.format('YYYY-MM-DD');
            var end=$('#date-range').data('daterangepicker').endDate.format('YYYY-MM-DD');
            master('{{ route('out_stock_report.get_data_filter_date') }}',start,end,type);
        });

    </script>
@endsection
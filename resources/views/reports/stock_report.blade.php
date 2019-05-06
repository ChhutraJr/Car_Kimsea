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
                                                <th>Product</th>
                                                <th>Code Part</th>
                                                <th>Model</th>
                                                <th>Use For</th>
                                                <th>Cost Price</th>
                                                <th>Sell Price</th>
                                                <th>Stock Total</th>
                                                <th>Stock Out</th>
                                                <th>Current Stock</th>

                                            </tr>
                                            </thead>

                                        </table>
                                    </div>


                                    <div class="col-md-3">
                                        <a target="_blank" href="{{url('stock-report/print')}}" class="btn btn-success btn-lg btn-add-sale" style="margin: 0px 13px 15px 0px;"><i class="icon-print"></i> Print</a>
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
            master('{{ route(config('global.index_link')) }}');

            //add active on nav bar
            $('.no-active6').removeClass('no-active6').addClass('active');
            $('.no-active6-1').removeClass('no-active6-1').addClass('active');
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
                "ajax": {
                    "url": route,
                    "type": "POST",
                    "data":{
                        "_token":"<?=csrf_token()?>",
                        "data1":data1
                    }
                },
                "columns": [
                    { "data": "name", "render":function (data) {
                        return '<span class="font-btb">'+data+'</span>';
                    }},
                    { "data": "code_part"},
                    { "data": "model" },
                    { "data": "use_for"},
                    { "data": "cost_price"},
                    { "data": "sell_price"},
                    { "data": "total_qty", "render": function (data) {
                        return '<span class="badge badge-primary r-3">'+data+'</span>';
                    }},
                    { "data": "stock_out", "render": function (data) {
                       return '<span class="badge badge-danger r-3">'+data+'</span>';
                    }},
                    { "data": "current_qty", "render": function (data) {
                        return '<span class="badge badge-success r-3">'+data+'</span>';
                    } }

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

        //on change data on table scroll to top
        $('#master-table').on('draw.dt', function() {
            scroll_to_top(55);
        });
    </script>
@endsection
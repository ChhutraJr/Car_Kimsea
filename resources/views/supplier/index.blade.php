@extends('master')
@section('content')
    <div class="page has-sidebar-left">

        <div class="container-fluid animatedParent animateOnce my-3">
            <div class="animated fadeInUpShort shadow">
                <div class="row">
                    <div class="col-md-12">
                        @if(!$master->isEmpty())
                            <div class="table-responsive">
                            <div class="card">
                            <div class="card-body2">

                                <table id="master-table" class="table table-striped table-bordered" cellspacing="0" width="100%" data-options='{"searching":true}'>

                                    <thead>
                                    <tr>
                                        <th>Supplier</th>
                                        <th>Action</th>

                                    </tr>
                                    </thead>

                                </table>
                            </div>
                        </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

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

        <!--Add New Button-->
        <a href="{{url(config('global.add_new_link'))}}" class="btn-fab btn-fab-md fab-right fab-right-bottom-fixed shadow btn-primary"><i
                    class="icon-add"></i>
        </a>
    </div>

    <input type="hidden" id="delete_id">
@endsection


@section('data')
    <script type="text/javascript">

        //on load display all data
        $(document).ready(function() {
            master('{{ route(config('global.index_link')) }}');

            //add active on nav bar
            $('.no-active7').removeClass('no-active7').addClass('active');
            $('.no-active7-3').removeClass('no-active7-3').addClass('active');
        });

        //Display master table with route
        function master(route,data1) {
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
                        "data1":data1
                    }
                },
                "columns": [
                    { "data": "name"},
                    { "data": "id", "render": function (data)
                    {

                        var action = '';

                            action += '<a class="btn btn-primary btn-xs btn-edit" href="{{url(config('global.update_link'))}}'+'/'+data+'"><i class="icon-pencil "></i> Edit</a>'+' ';

                            action += '<a class="btn btn-danger btn-xs btn-delete" href="javascript:void(0)" data-toggle="modal" data-target="#delete"><i class="icon-trash icon-delete-action"></i> Delete</a>';

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
        }

        //on change data on table scroll to top
        $('#master-table').on('draw.dt', function() {
            scroll_to_top(55);
        });
    </script>
@endsection
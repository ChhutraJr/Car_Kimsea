@extends('master')
@section('content')
    {{--<style>
        .float-left{
            margin-left: 1px;
        }
    </style>--}}
    <div class="page has-sidebar-left " >
        <div class="container-fluid animatedParent animateOnce my-3 ">

            @if(!$master->isEmpty())
                {{--Display Master--}}
                <div class="animated fadeInUpShort shadow">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <div class="card">
                                    <div class="card-body2">

                                        <table id="master-table" class="table table-striped table-bordered" cellspacing="0" width="100%" data-options='{"searching":true}' >

                                            <thead>
                                            <tr>
                                                <th width="6%"></th>
                                                <th>Name</th>
                                                <th>Username</th>
                                                <th>Role</th>
                                                <th>Joined Date</th>
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

        {{--Permission Start--}}
        @if(config('global.add_user'))
        <!--Add New Button-->
        <a href="{{url(config('global.add_new_link'))}}" class="btn-fab btn-fab-md fab-right fab-right-bottom-fixed shadow btn-primary"><i
                    class="icon-add"></i>
        </a>
        @endif
        {{--Permission End--}}
    </div>

    <input type="hidden" id="user_id">
    <input type="hidden" id="status">
@endsection

@section('data')
    <script type="text/javascript">
        //on load display all data
        $(document).ready(function() {
            //display master table serverside
            master('{{ route(config('global.index_link')) }}');
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
                    { "data": "image","render":function (data,type,all) {
                        if (all.status==1){
                            return '<div> <div class="float-left "> <i class="icon-circle text-primary act-icon blink"></i> </div> <div class="float-left info image "> <img class="img-user" src="/storage/'+data+'" alt=""> </div> </div>  ';
                        }else{
                            return '<div> <div class="float-left "> <i class="icon-circle text-danger act-icon"></i> </div> <div class="float-left info image "> <img class="img-user" src="/storage/'+data+'" alt=""> </div> </div>  ';
                        }

                    }},
                    { "data": "name"},
                    { "data": "username"},
                    { "data": "role", name:"r.name"},
                    { "data": "created_at","render":function (data) {
                        return '<i class="icon icon-timer"></i> '+data+'';
                    }},
                    { "data": "id", "render": function (data,type,all)
                    {
                        var action = '';

                        //Permission Start
                        @if(config('global.update_user'))
                        action += '<a class="btn btn-primary btn-xs btn-edit" href="{{url(config('global.update_link'))}}'+'/'+data+'"><i class="icon-pencil "></i> Edit</a>'+' ';

                        if (all.status==1){
                            action += '<a class="btn btn-danger btn-xs btn-delete" href="javascript:void(0)" data-toggle="modal" data-target="#delete"><i class="icon-block icon-delete-action"></i> Deactivate</a>';

                        }else{
                            action += '<a class="btn btn-success btn-xs btn-delete" href="javascript:void(0)" data-toggle="modal" data-target="#delete"><i class="icon-check-circle icon-delete-action"></i> Activate</a>';

                        }
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
                $('#user_id').val(table.row(this).data().id);
                $('#status').val(table.row(this).data().status);
                //alert(table.row(this)[0]);
                //     table.rows( $('#master-table tr.active') ).remove().draw();

            });
        });

        //Activated or Deactivated Master Start

        //activated or deactivated by route and id

        //on click by target id
        document.body.onclick= function(e){
            e=window.event? event.srcElement: e.target;
            if(e.className && e.className.indexOf('delete')!=-1){
                //alert(id);

                //send sidebar to back side
                refresh();

                //get id
                var id=$('#user_id').val();
                //get status
                var status=$('#status').val();
                var alert_ms='';

                if (status==1){
                    alert_ms='Deactivate';
                }else{
                    alert_ms='Activate';
                }

                //change status user
                master_alert(
                    alert_ms+' this user.', //Alert message
                    '{{route('status.user')}}', //route to delete
                    id, //delete route with this id
                    '{{csrf_token()}}', //send token key for security purpose
                    'User have been updated.' //alert message after delete
                );

            }
        };

        //Master Alert
        function master_alert(text,route,id,token,text_deleted,text_cant_delete,refresh_route) {
            //get status
            var status=$('#status').val();

            var alert_ms='';
            var alert_btn='';

            if (status==1){
                alert_ms='Yes deactivate it!';
                alert_btn="btn-danger";
            }else{
                alert_ms='Yes activate it!';
                alert_btn="btn-success";
            }

            swal({
                    title: "Are you sure?",
                    text: text,
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: alert_btn,
                    confirmButtonText: alert_ms,
                    closeOnConfirm: false
                },
                function(){

                    master_d(route,id,token,text_deleted,text_cant_delete);

                    /*,function() {
                     location.reload();
                     });*/

                });
        }

        function master_d(route,id,token,text_deleted,text_cant_delete,refresh_route) {

            //delete from database
            $.ajax({
                type: 'post',
                url: route,
                data: {
                    "_token":token,
                    'id': id
                },
                success: function (data) {
                    console.log(data);

                    if (data.status==1){
                        //alert successful deactivate
                        swal_alert('Deactivated',text_deleted,'success');
                    }else{
                        //alert successful activate
                        swal_alert('Activated',text_deleted,'success');
                    }

                    master('{{ route(config('global.index_link')) }}');
                }
            });
        }

        //Activated or Deactivated Master End
    </script>
@endsection

@extends('master')
@section('content')
    <div class="page has-sidebar-left">
        {{--Add Master--}}
        <div class="container-fluid animatedParent animateOnce my-3">

            <div class="animated fadeInUpShort shadow">
                <form id="form-master">
                    {{csrf_field()}}
                    <div class="card no-b  ">
                        <div class="card-body">
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-group m-0">
                                        <label for="name" class="col-form-label s-12">Role <span class="required">*</span></label>
                                        <input name="name"  id="category" placeholder="Enter Role Name" class="form-control-lg r-0 light s-12 input1" type="text">
                                    </div>
                                    <span class="text-danger">
                                                    <strong id="error1"></strong>
                                                </span>

                                </div>

                            </div>

                            @foreach($module as $m)
                            {{--User Start--}}
                            <div class="row">
                                <div class="card-body b-b">
                                    <div class="row">
                                        <div class="col-md-1">
                                            <label for="name" class="col-form-label s-12 fw-500" style="text-transform: capitalize;padding-top: 16px;">{{str_replace('_',' ',$m->name)}}</label>
                                        </div>
                                        <div class="col-md-2">
                                            <ul class="list-group">
                                                {{--Only show if has sub module more than one--}}
                                                @if($m->sub->count()>1)
                                                <li class="list-group-item">
                                                    Select all
                                                    <div class="material-switch float-right">
                                                        <input id="all{{$m->id}}" name="all"  type="checkbox"/>
                                                        <label for="all{{$m->id}}" class="bg-success"></label>
                                                    </div>
                                                </li>
                                                @endif

                                            </ul>
                                        </div>
                                        <div class="col-md-3">
                                            <ul class="list-group">

                                                @foreach($m->sub as $s)
                                                <li class="list-group-item" style="text-transform: capitalize">
                                                    {{str_replace('_',' ',$s->name)}}
                                                    <div class="material-switch float-right">
                                                        <input id="sub{{$s->id}}" type="checkbox"/>
                                                        <label for="sub{{$s->id}}" class="bg-success"></label>
                                                    </div>
                                                </li>
                                                @endforeach

                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{--User End--}}
                            @endforeach

                            <div style="text-align: right">
                                <button type="submit" class="btn btn-primary btn-lg" style="margin: 18px 13px 15px 0px;" id="btn-save" ><i class="icon-save mr-2"></i>Save</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>

    </div>

@endsection

@section('data')
    <script type="text/javascript">
        var option='';
        var option2='';

        $(function () {
//            all_checked('u');
            var url_req="{{url('/module/all')}}";
            $.get(url_req,function (data) {
//                console.log(data);

                for (var i=0;i<data.length;i++){
                    all_checked('all'+data[i].id,data[i].id);
                    //add all module to option
                    option+=''+data[i].id+',';
                }

                /*var array = option.split(",");

                for (var j=0;j<array.length-1;j++){
                    alert(array[j]);
                }*/

            });

            //add all sub module to option2
            var url_req2="{{url('/sub_module/all')}}";
            $.get(url_req2,function (data) {
//                console.log(data);
                for (var j=0;j<data.length;j++){
                    option2+=''+data[j].id+',';
                }

            });
        });

        {{--On Submit--}}
        $("#form-master").submit(function (e) {
                    e.preventDefault();

        //            has_errors('.input-cat','#cat-error');
                    clear_border(['input1']);
                    clear_error(['error1']);

                    var form = new FormData($("#form-master")[0]);
        //            alert('hi');
                    $.ajax({
                        /* location to go*/
                        url: "{{route(config('global.submit_link'))}}",
                        method: "POST",
                        dataType: 'json',
                        data: form,
                        processData: false,
                        contentType: false,
                        success: function(data){
                            /* When controller is complete it send back value to data*/
//                            console.log(data);

                            if ((data.errors)) {
                                data_error(data.errors.name,'error1','input1');
                            }

                            if(data.verify=='true'){
                                var role_id=data.id;

                                //Add permission
                                var array2 = option2.split(",");
                                var add='';
                                //loop all sub module
                                for (var i=0;i<array2.length-1;i++){

                                    //get 0 is false 1 is true
                                    var sub=get_checked('sub'+array2[i]);
                                    //add id to add value if checked
                                    if (sub==1){
                                        add+=''+array2[i]+',';
                                    }
                                }

                                //add permission to database
                                $.ajax({
                                    /* location to go*/
                                    url: "{{route('role.per')}}",
                                    method: "POST",
                                    dataType: 'json',
                                    data: {
                                        "_token":"<?=csrf_token()?>",
                                        'role_id':role_id,
                                        'sub_module':add
                                    },
                                    success: function (data2) {
//                                        console.log(data2);
        //
                                        if(data2.verify=='true'){
                                            window.location.href='{{url(config('global.index_link'))}}';
                                        }


                                    }
                                });


                                //list module
                                /* var url_req="{url('/sub_module/all')}}";
                                 $.get(url_req,function (data2) {

                                 //                            console.log(data2);
                                 for (var i=0;i<data2.length;i++){
                                 var last='false';
                                 if (i==data2.length-1){
                                 last='true';
                                 }

                                 //get 0 is false 1 is true
                                 var sub=get_checked('sub'+data2[i].id);

                                 $.ajax({
                                 /!* location to go*!/
                                 url: "{route('role.per')}}",
                                 method: "POST",
                                 dataType: 'json',
                                 data: {
                                 "_token":"?=csrf_token()?>",
                                 'role_id':role_id,
                                 'sub_module_id':data2[i].id,
                                 'sub':sub,
                                 'last':last
                                 },
                                 success: function (data3) {
                                 //                                            console.log(data3);
                                 if (data3.last=='true'){
                                 window.location.href='{url(config('global.index_link'))}}';
                                 }
                                 }
                                 });
                                 }

                                 });*/
                            }
                        },
                        error: function(er){}
                    });
                });

        //change checked and unchecked by id
        function all_checked(id_div,id){
            //on change checkbox select all customer start
            $('#'+id_div).change(function () {
                //if select is true check all sub user
                if (this.checked==true){
//                alert($('#vu').attr().checked());

                    var url_req="{{url('/sub_module/')}}"+"/"+id;
                    $.get(url_req,function (data) {
                        for(var i=0;i<data.length;i++){
                            $('#sub'+data[i].id).attr('Checked','Checked');
                        }
                    });

                    //alert('on');
                }else{
                    var url_req="{{url('/sub_module/')}}"+"/"+id;
                    $.get(url_req,function (data) {
                        for(var i=0;i<data.length;i++){
                            $('#sub'+data[i].id).removeAttr('Checked');
                        }
                    });


//                alert('off');
                }
//           alert($('#u').val());
            });
        }

        //return all value 0 or 1 checkbox by id
        function get_checked (id_div){
            var checked=0;
            $('#'+id_div).each(function () {
                //if box is checked
                if(this.checked==true){
                    checked=1;
                }
            });

            return checked;
        }
    </script>
@endsection


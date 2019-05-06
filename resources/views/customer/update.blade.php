@extends('master')
@section('content')
    <div class="page has-sidebar-left">

        <div class="container-fluid animatedParent animateOnce my-3">

            <div class="animated fadeInUpShort r-0 shadow">

                <form id="form-master">
                    {{csrf_field()}}
                    <input type="hidden" name="update_id" value="{{$master->id}}">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <div class="form-group">
                                                <label for="validationCustom04">Customer Name <span class="required">*</span></label>
                                                <input type="text" class="form-control input1" id = "cus" name="customer_name" placeholder="Customer Name" value="{{$master->name}}">
                                                <span class="text-danger">
                                                    <strong id="error1"></strong>
                                                </span>
                                            </div>

                                        </div>
                                        <div class="col-md-4 mb-3">

                                            <div class="form-group">
                                                <label for="validationCustom04">Contact Number</label>
                                                <input  class="tagsinput input2" name="contact_number" id ="input" value="@foreach ($master->multi_tel as $t) {{$t->name}}
                                                @if(!$loop->last) , @endif
                                                @endforeach "/>

                                                <span class="text-danger">
                                                    <strong id="error2"></strong>
                                                </span>

                                            </div>

                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="form-group">
                                                <label for="Email">Email</label>
                                                <input type="email" class="form-control input3" name="email" placeholder="Email" value="{{$master->email}}">
                                                {{-- <span class="text-danger">
                                                     <strong id="error1"></strong>
                                                 </span>--}}
                                            </div>

                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 mb-3">

                                            <div class="form-group">
                                                <label for="validationCustom04">Plate No</label>
                                                <input type="text" class="form-control input4" name="plate_no" placeholder="Plate No" value="@if(!empty($vehicle->plate_no)) {{$vehicle->plate_no}} @endif">
                                                <span class="text-danger">
                                                    <strong id="error4"></strong>
                                                </span>

                                            </div>

                                        </div>
                                        <div class="col-md-4 mb-3">

                                            <div class="form-group">
                                                <label for="brand">Vehicle Model</label>
                                                <select class="custom-select select2 tags input7" name="model">
                                                    <option value="">Select None</option>
                                                    @if(!empty($vehicle->model_id))
                                                        @foreach($model as $m)
                                                            @if($m->id==$vehicle->model_id)
                                                                <option value="{{$m->id}}" selected>{{$m->name}}</option>
                                                            @else
                                                                <option value="{{$m->id}}">{{$m->name}}</option>
                                                            @endif

                                                        @endforeach
                                                    @else
                                                        @foreach($model as $m)
                                                            <option value="{{$m->id}}">{{$m->name}}</option>
                                                        @endforeach
                                                    @endif

                                                </select>
                                                <span class="text-danger">
                                                    <strong id="error7"></strong>
                                                </span>

                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="form-group">
                                                <label for="validationCustom04">Vehicle Year</label>
                                                <input type="text" class="form-control input10" name="year" placeholder="Year" value="@if(!empty($vehicle->year)) {{$vehicle->year}} @endif">
                                                <span class="text-danger">
                                                        <strong id="error10"></strong>
                                                    </span>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <div class="form-group">
                                                <label for="brand">Vehicle Color</label>
                                                <select class="custom-select select2 tags input11" name="color">
                                                    <option value="">Select None</option>
                                                    @if(!empty($vehicle->color_id))
                                                        @foreach($color as $c)
                                                            @if($c->id==$vehicle->color_id)
                                                                <option value="{{$c->id}}" selected>{{$c->name}}</option>
                                                            @else
                                                                <option value="{{$c->id}}">{{$c->name}}</option>
                                                            @endif

                                                        @endforeach
                                                    @else
                                                        @foreach($color as $c)
                                                            <option value="{{$c->id}}">{{$c->name}}</option>
                                                        @endforeach
                                                    @endif

                                                </select>
                                                <span class="text-danger">
                                                <strong id="error11"></strong>
                                            </span>

                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label for="validationCustom04">Contact Address</label>
                                                <textarea class="form-control input-address hideSearch input3"
                                                          placeholder="Contact Address" rows="1" name="contact_address" >{{$master->address}}</textarea>
                                                <span class="text-danger">
                                                    <strong id="error3"></strong>
                                                </span>

                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <hr>

                                <div style="text-align: right">
                                    <button type="button" class="btn btn-default btn-lg btn-close" style="margin: 0px 8px 15px 0px;" onclick="window.location.href='{{url(config('global.index_link'))}}'">Close</button>
                                    <button type="submit" class="btn btn-primary btn-lg" style="margin: 0px 13px 15px 0px;" id="btn-save" ><i class="icon-save mr-2"></i>Save</button>
                                </div>

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

        $(document).ready(function() {

            //add active on nav bar
            $('.no-active2').removeClass('no-active2').addClass('active');

        });

        //  cus_name_validate //
        $("#cus").on("input", function(e) {

            on_change_input('cus','input1','error1','The customer name field is required.');

        });

        $("#form-master").submit(function (e) {
            e.preventDefault();


            var form = new FormData($("#form-master")[0]);
            $.ajax({
                async: false,
                /* location to go*/
                url: "{{route(config('global.submit_link'))}}",
                method: "POST",
                dataType: 'json',
                data: form,
                processData: false,
                contentType: false,
                success: function(data){
                    /* When controller is complete it send back value to data*/
//                    console.log(data);

                    if ((data.errors)) {
                        data_error(data.errors.customer_name, 'error1', 'input1');
                    }

                    if(data.verify=='true'){
//                        $("#form-product")[0].reset();
                        window.location.href='{{url(config('global.index_link'))}}';
                    }

                    if (data.verify=='false'){
                        swal_alert('Empty','You don\'t have any identify of the customer.','error');
                    }
                },
                error: function(er){}
            });
        });

    </script>
@endsection


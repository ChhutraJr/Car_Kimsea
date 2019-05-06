@extends('master')
@section('content')
    <div class="page has-sidebar-left">

        <div class="container-fluid animatedParent animateOnce my-3">

            <div class="animated fadeInUpShort r-0 shadow">

                <form id="form-master">
                    {{csrf_field()}}
                    <div class="row"> 
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <div class="form-group">
                                                <label for="validationCustom04">Customer Name <span class="required">*</span></label>
                                                <input type="text" class="form-control input1" id ="cus" name="customer_name"  placeholder="Customer Name">
                                                <span class="text-danger">
                                                    <strong id="error1"></strong>
                                                </span>
                                            </div>

                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="form-group">
                                                <label for="validationCustom04">Contact Number</label>
                                                <input class="tagsinput input2" name="contact_number"/>
                                                <span class="text-danger">
                                                    <strong id="error2"></strong>
                                                </span>

                                            </div>

                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="form-group">
                                                <label for="Email">Email</label>
                                                <input type="email" class="form-control input3" name="email" placeholder="Email">
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
                                                <input type="text" class="form-control input4" name="plate_no" placeholder="Plate No">
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
                                                    @foreach($model as $m)
                                                        <option value="{{$m->id}}">{{$m->name}}</option>
                                                    @endforeach
                                                </select>
                                                <span class="text-danger">
                                                    <strong id="error7"></strong>
                                                </span>

                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="form-group">
                                                    <label for="validationCustom04">Vehicle Year</label>
                                                    <input type="text" class="form-control input10" name="year" placeholder="Year">
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
                                                    @foreach($color as $c)
                                                        <option value="{{$c->id}}">{{$c->name}}</option>
                                                    @endforeach
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
                                                          placeholder="Contact Address" rows="1" name="contact_address" ></textarea>
                                                <span class="text-danger">
                                                    <strong id="error3"></strong>
                                                </span>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                               {{-- <hr class="no-mg-t no-mg-b">
                                <div class="card-body">
                                    <h5 class="card-title mb-4">Vehicle</h5>
                                    <div class="row">
                                        <div class="col-md-3 mb-3">

                                            <div class="form-group">
                                                <label for="validationCustom04">Plate Number</label>
                                                <input type="text" class="form-control input4" name="plate_number" placeholder="Plate Number">
                                                <span class="text-danger">
                                                    <strong id="error4"></strong>
                                                </span>

                                            </div>

                                            <div class="form-group">
                                                <label for="validationCustom04">Engine Model</label>
                                                <input type="text" class="form-control input5" name="engine_model" placeholder="Engine Model">
                                                <span class="text-danger">
                                                    <strong id="error5"></strong>
                                                </span>

                                            </div>

                                            <div class="form-group">
                                                <label for="validationCustom04">Vin</label>
                                                <input type="text" class="form-control input-code-part input6" name="vin" placeholder="Vin">
                                                <span class="text-danger">
                                                    <strong id="error6"></strong>
                                                </span>

                                            </div>

                                        </div>

                                        <div class="col-md-3 mb-3">

                                            <div class="form-group">
                                                <label for="brand">Model</label>
                                                <select class="custom-select select2 tags input7" name="model">
                                                    <option value="">Select None</option>
                                                    @foreach($model as $m)
                                                        <option value="{{$m->id}}">{{$m->name}}</option>
                                                    @endforeach
                                                </select>
                                                <span class="text-danger">
                                                    <strong id="error7"></strong>
                                                </span>

                                            </div>
                                            <div class="form-group">
                                                <label for="validationCustom04">Start Counter</label>
                                                <input type="text" class="form-control input8" name="start_counter" placeholder="Start Counter">
                                                <span class="text-danger">
                                                    <strong id="error8"></strong>
                                                </span>

                                            </div>

                                        </div>

                                        <div class="col-md-3 mb-3">

                                            <div class="form-group">
                                                <label for="brand">Brand</label>
                                                <select class="custom-select select2 tags input9" name="brand">
                                                    <option value="">Select None</option>
                                                    @foreach($brand as $b)
                                                        <option value="{{$b->id}}">{{$b->name}}</option>
                                                    @endforeach
                                                </select>
                                                <span class="text-danger">
                                                    <strong id="error9"></strong>
                                                </span>

                                            </div>

                                            <div class="form-group">
                                                <label for="validationCustom04">Year</label>
                                                <input type="text" class="form-control input10" name="year" placeholder="Year">
                                                <span class="text-danger">
                                                    <strong id="error10"></strong>
                                                </span>

                                            </div>

                                        </div>

                                        <div class="col-md-3 mb-3">

                                            <div class="form-group">
                                                <label for="brand">Color</label>
                                                <select class="custom-select select2 tags input11" name="color">
                                                    <option value="">Select None</option>
                                                    @foreach($color as $c)
                                                        <option value="{{$c->id}}">{{$c->name}}</option>
                                                    @endforeach
                                                </select>
                                                <span class="text-danger">
                                                    <strong id="error11"></strong>
                                                </span>

                                            </div>
                                            <div class="form-group">
                                                <label for="validationCustom04">Engine No</label>
                                                <input type="text" class="form-control input12" name="engine_no" placeholder="Engine No">
                                                <span class="text-danger">
                                                    <strong id="error12"></strong>
                                                </span>

                                            </div>

                                        </div>
                                    </div>

                                </div>--}}

                                <hr>

                                <div style="text-align: right">
                                    <button type="submit" onclick="$('#save-type').val('save_add_sale')" class="btn btn-success btn-lg btn-add-sale" style="margin: 0px 13px 15px 0px;"  ><i class="icon-save mr-2"></i>Save and Add sale</button>
                                    <button type="submit" onclick="$('#save-type').val('save_add_another')" class="btn btn-danger  btn-lg btn-add-another " style="margin: 0px 13px 15px 0px;"  ><i class="icon-save mr-2"></i>Save and Add Another</button>
                                    <button type="submit" onclick="$('#save-type').val('save')" class="btn btn-primary btn-lg" style="margin: 0px 13px 15px 0px;" id="btn-save" ><i class="icon-save mr-2"></i>Save</button>
                                </div>


                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>

    <input type="hidden" id="save-type">
@endsection

@section('data')
    <script type="text/javascript">

        $(document).ready(function() {


            //add active on nav bar
            $('.no-active2').removeClass('no-active2').addClass('active');
            $('.no-active2-2').removeClass('no-active2-2').addClass('active');
        });

        //  cus_name_validate //
        $("#cus").on("input", function(e) {

            on_change_input('cus','input1','error1','The customer name field is required.');

        });

        $("#form-master").submit(function (e) {
            e.preventDefault();

            clear_border(['input1','input4']);
            clear_error(['error1','error4']);

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

                    if ((data.errors)) {
                        data_error(data.errors.plate_no,'error4', 'input4');
                    }



                    if(data.verify=='true'){
//                        $("#form-product")[0].reset();
                        if ($('#save-type').val()=='save'){
                            window.location.href='{{url(config('global.index_link'))}}';
                        }else if($('#save-type').val()=='save_add_another'){
                            window.location.href='{{url('customer/create/')}}';
                        }else{
                            //if save and add new sale
                            window.location.href='{{url('sale/create/')}}'+'/'+data.cus_id;
                        }

                    }

                    if (data.verify=='false'){
                        swal_alert('Empty','You don\'t have any identify of the customer.','error');
                    }
                },
                error: function(er){}
            });
        });

/*
        float_only(['pro_unit_price','pro_cost_unit']);
        //Input Number
        float_only(['contact_number','contact_number_other']).on('input', function() {
            this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');
        });
*/

    </script>
@endsection


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
                                        <div class="col-md-4 mb-3" >
                                            <div class="form-group">
                                                <label for="brand">Category <span class="required">*</span></label>
                                                <select id="exp-cat" class="custom-select select2 tags input1" name="category" >
                                                    <option value="">Select None</option>
                                                    {{--@if($master->cat_id==0)
                                                        <option value="0" selected>Stock</option>
                                                    @else
                                                        <option value="0">Stock</option>
                                                    @endif--}}

                                                    @foreach($cat as $c)
                                                        @if($c->id==$master->cat_id)
                                                            <option value="{{$c->id}}" selected>{{$c->name}}</option>
                                                        @else
                                                            <option value="{{$c->id}}">{{$c->name}}</option>
                                                        @endif

                                                    @endforeach
                                                </select>
                                                <span class="text-danger">
                                                    <strong id="error1"></strong>
                                                    </span>

                                            </div>

                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <div class="form-group">
                                                <label for="brand">Expense Date <span class="required">*</span></label>
                                                <div class="input-group date date_picker" data-provide="datepicker">
                                                    <div class="input-group-addon">
                                                        <span class="icon icon-calendar"></span>
                                                    </div>
                                                    <input id="date" onkeydown="return false" type="text" class="form-control input5" placeholder="Select None" name="date" value="{{date('d/M/Y', strtotime($master->date))}}">

                                                </div>
                                                <span class="text-danger">
                                                    <strong id="error5"></strong>
                                                </span>
                                            </div>

                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <div class="form-group">
                                                <label for="brand">Payment Status <span class="required">*</span></label>
                                                <select id="payment-status" class="custom-select select2 no-search input2" name="payment_status">
                                                    <option value="">Select None</option>
                                                    @if($master->payment_status=='paid')
                                                        <option value="paid" selected>Paid</option>
                                                    @else
                                                        <option value="paid">Paid</option>
                                                    @endif

                                                    @if($master->payment_status=='credit')
                                                        <option value="credit" selected>Credit</option>
                                                    @else
                                                        <option value="credit">Credit</option>
                                                    @endif

                                                </select>
                                                <span class="text-danger">
                                                    <strong id="error2"></strong>
                                                </span>
                                            </div>
                                        </div>

                                        {{--<div class="div_pro col-md-4 mb-3">
                                            <div class="form-group">
                                                <label for="brand">Product <span class="required">*</span></label>
                                                <select class="custom-select select2 tags input4" name="product">
                                                    <option value="">Select None</option>
                                                    @foreach($pro as $p)
                                                        @if($p->id==$master->pro_id)
                                                            <option value="{{$p->id}}" selected>{{$p->name}}</option>
                                                        @else
                                                            <option value="{{$p->id}}">{{$p->name}}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                                <span class="text-danger">
                                            <strong id="error4"></strong>
                                        </span>

                                            </div>
                                        </div>--}}

                                        <div class="col-md-4 mb-3">
                                            <div class="form-group">
                                                <label for="validationCustom04">Total Amount <span class="required">*</span></label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <span class="icon icon-money"></span>
                                                    </div>
                                                    <input id="t-amount" type="text" class="form-control input3" name="total_amount" placeholder="0.00" value="{{$master->total_amount}}">
                                                </div>

                                                <span class="text-danger">
                                                    <strong id="error3"></strong>
                                                </span>
                                            </div>
                                        </div>


                                        <div class="col-md-12 mb-3">
                                            <div class="form-group">
                                                <label for="validationCustom04">Expense Note</label>
                                                <textarea class="form-control input-address hideSearch input6"
                                                          placeholder="Expense Note" rows="2" name="note" >{{$master->note}}</textarea>
                                                <span class="text-danger">
                                                    <strong id="error6"></strong>
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

    <input type="hidden" id="cat" value="{{$master->cat_id}}">
    {{--<input type="hidden" id="exp-date" value="{{$master->date}}">--}}
@endsection

@section('data')
    <script type="text/javascript">

        $(document).ready(function() {

            //add active on nav bar
            $('.no-active5').removeClass('no-active5').addClass('active');


            //  exp_name_validate //

            $("#t-amount").on("input", function(e) {
                var total_amount=$('#t-amount').val();
                clear_border(['input3']);     //Chart on load
                clear_error(['error3']);
                $.ajax({
                    /* location to go*/
                    url: "{{route('expense.total_amount_validate')}}",
                    method: "POST",
                    dataType: 'json',
                    data: {
                        'total_amount':total_amount,
                        '_token': "{{ csrf_token() }}"
                    },
                    success: function(data){
                        /* When controller is complete it send back value to data*/
                        //   console.log(data);

                        if ((data.errors)) {
                            data_error(data.errors.total_amount, 'error3', 'input3');
                        }
                    },
                    error: function(er){}
                });
            });

            // On change  Expense cat
            $('#exp-cat').on('change', function() {
                on_change_input('exp-cat','input1','error1','The category field is required.');
            });


            // On change   payment status
            $('#payment-status').on('change', function() {
                on_change_input('payment-status','input2','error2','The payment status field is required.');
            });
            //set default date to update date
//            var date=$('#exp-date').val();

            //declare date
            $('.date_picker').datepicker({
                format: 'dd/M/yyyy',
                todayHighlight:'TRUE',
                autoclose: true

            }); //default date
/*
            //remove div product
            if ($('#cat').val()==0){
                $('.div_pro').show();
            }else{
                $('.div_pro').hide();
            }*/


/*            //Onchange Expense Category
            $('#exp-cat').on('change', function() {
                //if expense category is stock show list product
                if (this.value=='0'){
                    $('.div_pro').show();
                }else{
                    $('.div_pro').hide();
                }
            });*/



        });


        $("#form-master").submit(function (e) {
            e.preventDefault();

            //clear all errors
            clear_border(['input1','input2','input3','input4','input5','input6']);
            clear_error(['error1','error2','error3','error4','error5','error6']);

            var date= $.datepicker.formatDate("yy-mm-dd", new Date($('#date').val()));
            //if date is empty
            if (date=='NaN-NaN-NaN'){
                date='';
            }
            var form = new FormData($("#form-master")[0]);
            form.append('date',date);
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
//                    console.log(data);

                    if ((data.errors)) {
                        data_error(data.errors.category,'error1','input1');
                        data_error(data.errors.payment_status,'error2','input2');
                        data_error(data.errors.total_amount,'error3','input3');
//                        data_error(data.errors.product,'error4','input4');
                        data_error(data.errors.date,'error5','input5');
                        data_error(data.errors.note,'error6','input6');
                    }
                    if(data.verify=='true'){
//                        $("#form-product")[0].reset();
                        window.location.href='{{url(config('global.index_link'))}}';
                    }

                },
                error: function(er){}
            });
        });

        //only allow number when typing
        float_only(['t-amount']);

    </script>
@endsection


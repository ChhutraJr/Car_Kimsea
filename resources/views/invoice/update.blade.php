@extends('master')
@section('content')
    <div class="page has-sidebar-left">

        {{--Update Master--}}
        <div class="container-fluid animatedParent animateOnce my-3">

            <div class="animated fadeInUpShort r-0 shadow">

                <form id="form-master">
                    {{csrf_field()}}

                    <input type="hidden" name="update_id" value="{{$master->id}}">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card no-b">
                                <div class="card-body">
                                    <div class="row">

                                        <div class="col-md-4 mb-3">
                                            <div class="form-group">
                                                <label for="customer">Customer <span class="required">*</span></label>
                                                <select id="cus" name="customer" class="custom-select select2 tags input1" >
                                                    <option value="">Select None</option>
                                                    @foreach($cus as $c)
                                                        <?php
                                                            $plate_no='';
                                                            if (!empty($c->plate_no)){
                                                                $plate_no='('.$c->plate_no.')';
                                                            }
                                                        ?>
                                                        @if($c->id==$master->cus_id)
                                                            <option value="{{$c->id}}" selected>{{$c->name}} {{$plate_no}}</option>
                                                        @else
                                                            <option value="{{$c->id}}">{{$c->name}} {{$plate_no}}</option>
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
                                                <label for="brand">Invoice Date <span class="required">*</span></label>
                                                <div class="input-group date date_picker" data-provide="datepicker">
                                                    <div class="input-group-addon">
                                                        <span class="icon icon-calendar"></span>
                                                    </div>
                                                    <input id="date" onkeydown="return false" type="text" class="form-control input2" placeholder="Select None" name="date" value="{{date('d/M/Y', strtotime($master->date))}}">

                                                </div>
                                                <span class="text-danger">
                                                    <strong id="error2"></strong>
                                                </span>
                                            </div>
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <div class="form-group">
                                                <label>SA</label>
                                                <select id="cat" name="sa[]" class="custom-select select2 tags input3 select-none" multiple>

                                                    @foreach($sa as $s)
                                                        @php($n=0)
                                                        {{--Check all master multi sa to see if have in list sa or not--}}
                                                        @foreach($master->multi_sa as $multi_sa)
                                                            @if($multi_sa->user_id==$s->id)
                                                                @php($n=1)
                                                                @break($multi_sa)
                                                            @endif
                                                        @endforeach

                                                        {{--Select if user multi sa and sa is the same--}}
                                                        @if($n==1)
                                                            <option selected value="{{$s->id}}">{{$s->first_name}} {{$s->last_name}}</option>
                                                        @else
                                                            <option value="{{$s->id}}">{{$s->first_name}} {{$s->last_name}}</option>
                                                        @endif

                                                    @endforeach
                                                </select>

                                                <span class="text-danger">
                                                    <strong id="error3"></strong>
                                                </span>

                                            </div>
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <div class="form-group">
                                                <label>Mechanic</label>
                                                <select id="cat" name="mechanic[]" class="custom-select select2 tags input4 select-none" multiple>

                                                    @foreach($mechanic as $m)
                                                        @php($n=0)
                                                        {{--Check all master multi mechanic to see if have in list mechanic or not--}}
                                                        @foreach($master->multi_mechanic as $multi_mechanic)
                                                            @if($multi_mechanic->user_id==$m->id)
                                                                @php($n=1)
                                                                @break($multi_mechanic)
                                                            @endif
                                                        @endforeach

                                                        {{--Select if user multi mechanic and mechanic is the same--}}
                                                        @if($n==1)
                                                            <option selected value="{{$m->id}}">{{$m->first_name}} {{$m->last_name}}</option>
                                                        @else
                                                            <option value="{{$m->id}}">{{$m->first_name}} {{$m->last_name}}</option>
                                                        @endif

                                                    @endforeach
                                                </select>

                                                <span class="text-danger">
                                                    <strong id="error4"></strong>
                                                </span>

                                            </div>
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <div class="form-group">
                                                <label>Seller</label>
                                                <select name="seller[]" class="custom-select select2 tags input4 select-none" multiple>

                                                    @foreach($seller as $s)
                                                        @php($n=0)
                                                        {{--Check all master multi seller to see if have in list seller or not--}}
                                                        @foreach($master->multi_seller as $multi_seller)
                                                            @if($multi_seller->user_id==$s->id)
                                                                @php($n=1)
                                                                @break($multi_seller)
                                                            @endif
                                                        @endforeach

                                                        {{--Select if user multi seller and seller is the same--}}
                                                        @if($n==1)
                                                            <option selected value="{{$s->id}}">{{$s->first_name}} {{$s->last_name}}</option>
                                                        @else
                                                            <option value="{{$s->id}}">{{$s->first_name}} {{$s->last_name}}</option>
                                                        @endif

                                                    @endforeach
                                                </select>

                                                <span class="text-danger">
                                                    <strong id="error4"></strong>
                                                </span>

                                            </div>
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <div class="form-group ">

                                                <label>KM</label>
                                                <input name="km" type="text" class="form-control input5" placeholder="KM" value="{{$master->km}}" >

                                                <span class="text-danger">
                                                    <strong id="error5"></strong>
                                                </span>


                                            </div>
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <div class="form-group">
                                                <label for="validationCustom04">RO</label>
                                                <input type="text" name="ro" class="form-control input6" placeholder="RO" value="{{$master->ro}}">
                                                <span class="text-danger">
                                                    <strong id="error6"></strong>
                                                </span>

                                            </div>

                                        </div>

                                        <div class="col-md-8 mb-3">
                                            <div class="form-group">
                                                <label for="validationCustom04">Invoice Note</label>
                                                <textarea class="form-control input-address hideSearch input7"
                                                          placeholder="Invoice Note" rows="1" name="note" >{{$master->note}}</textarea>
                                                <span class="text-danger">
                                                    <strong id="error7"></strong>
                                                </span>

                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>

        {{--Add Detail--}}
        <div class="container-fluid animatedParent animateOnce my-3">

            <div class="animated fadeInUpShort shadow">

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body2">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card-body slimScroll" data-height="100%">


                                            <div class="table-responsive">
                                                <table id="detail-table" class="table table-striped table-bordered" cellspacing="0" width="100%" data-options='{"searching":true}'>
                                                    <thead>
                                                    <tr class="" style="border-bottom: none !important;">
                                                        <th style="display: none"></th>
                                                        <th width="3%"><a href='javascript:void(0)'><i id="add-new" class='icon icon-add add-icon'></i></a></th>
                                                        <th class="text-center" >Description</th>
                                                        <th class="text-center" width="20%">Code Part</th>
                                                        <th class="text-center" width="10%">Note</th>
                                                        <th class="text-center" width="15%">Qty</th>
                                                        <th class="text-center" width="10%">Cost Price</th>
                                                        <th class="text-center" width="10%">Sell Price</th>
                                                        <th class="text-center" width="10%">Total</th>

                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>

                                            </div>


                                            <div class="row">
                                                <div class="col-9">

                                                </div>
                                                <div class="col-3">

                                                    <div class="table-responsive">
                                                        <table class="table">
                                                            <tbody>
                                                            <tr>
                                                                <td></td>
                                                                <th width="205px">Grand Total:</th>
                                                                <td><b><span id="grand-total">$0.00</span></b></td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                    </div>


                                </div>
                            </div>


                        </div>
                    </div>

                </div>

            </div>
        </div>

        {{--Add Discount--}}
        <div class="container-fluid animatedParent animateOnce my-3">

            <div class="animated fadeInUpShort shadow">
                <form id="form-discount">
                    {{csrf_field()}}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card ">
                                <div class="card-body">
                                    <h5>Add Discount</h5>
                                    <br>
                                    <div class="row">

                                        <div class="col-md-4 mb-3">
                                            <div class="form-group">
                                                <label for="Type">Discount Type</label>
                                                <select id="dis-type" class="custom-select no-search select2" name="model" id="filter-type">
                                                    <option value="">Select None</option>

                                                    @if($master->dis_type=='fixed')
                                                        <option value="fixed" selected>Fixed</option>
                                                    @else
                                                        <option value="fixed">Fixed</option>
                                                    @endif

                                                    @if($master->dis_type=='percentage')
                                                        <option value="percentage" selected>Percentage</option>
                                                    @else
                                                        <option value="percentage">Percentage</option>
                                                    @endif


                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-8 mb-3">
                                            <div class="form-group">
                                                <label for="validationCustom04">Discount Amount</label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <span id="dis-amount-icon" ></span>
                                                    </div>
                                                    <input id="dis-amount-input" type="text" name="amount" class="form-control input8" placeholder="0.00" value="{{$master->dis_amount}}">
                                                </div>

                                                <span class="text-danger">
                                                    <strong id="error8"></strong>
                                                </span>

                                            </div>

                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-9">

                                        </div>
                                        <div class="col-3">

                                            <div class="table-responsive">
                                                <table class="table">
                                                    <tbody>
                                                    <tr>
                                                        <td></td>
                                                        <th width="205px">Discount Amount:</th>
                                                        <td><b><span id="dis-amount">${{number_format($master->dis_total_amount, 2)}}</span></b></td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <th width="205px">Total Payable:</th>
                                                        <td><b><span id="total-payable">${{number_format($master->total_amount, 2)}}</span></b></td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </form>
            </div>

        </div>

        {{--Add Payment--}}
        <div class="container-fluid animatedParent animateOnce my-3">

            <div class="animated fadeInUpShort shadow">
                <form id="form-payment">
                    {{csrf_field()}}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card no-b">
                                <div class="card-body">
                                    <h5>Add Payment</h5>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <div class="form-group">
                                                <label for="validationCustom04">Amount</label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <span class="icon icon-money"></span>
                                                    </div>
                                                    <input id="payment-amount" type="text" name="amount" class="form-control input8" placeholder="0.00">
                                                </div>

                                                <span class="text-danger">
                                                    <strong id="error8"></strong>
                                                </span>

                                            </div>

                                        </div>

                                        <div class="col-md-8 mb-3">
                                            <div class="form-group">
                                                <label for="validationCustom04">Payment Note</label>
                                                <textarea class="form-control input-address hideSearch input9"
                                                          placeholder="Payment Note" rows="1" name="note" ></textarea>
                                                <span class="text-danger">
                                                    <strong id="error9"></strong>
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

    <input type="hidden" id="delete" value="false">
    <input type="hidden" id="amount" value="{{$master->amount}}">
    <input type="hidden" id="master_id" value="{{$master->id}}">
@endsection

@section('data')
    <script type="text/javascript">
        var option='';
        var option2='';
        //on load
        $(document).ready(function() {

            //update payment amount
            var total_credit={{$master->total_remaining}};
            $('#payment-amount').val(total_credit);

            //declare date
            $('.date_picker').datepicker({
                format: 'dd/M/yyyy',
                todayHighlight:'TRUE',
                autoclose: true

            }).on("change", function (e) {
                if(!e.target.value){
                    $('.input2').parent().addClass('has-error');
                    $('#error2').html('The date field is required.');
                }
                else{
                    clear_border(['input2']);     //Chart on load
                    clear_error(['error2'])
                }
                //   console.log("Date changed: ", e.target.value);
            });

            //add list product to description

            //get sale product from db
/*            var url_sale_pro="{url('/sale_products')}}";
            $.get(url_sale_pro,function (data,status){
                //console.log(data);
                option+='<option value="">Select None</option>';
                for (var i=0;i<data.length;i++){
                    option+='<option value="'+data[i].id+'">'+data[i].name +'</option>';
                }
            });*/
            // On change purchase validate
            $('#cus').on('change', function() {
                on_change_input('cus','input1','error1','The customer field is required.');
            });

            //display detail data
            var url_req="{{url('invoice_detail/update')}}/"+$('#master_id').val();
            $.get(url_req,function (data) {

                if (data.detail.length==0){
                    //set value default to field
                    var id=0;
                    var qty=0;
                    var price=0;
                    var total='$0.00';
                    var des='';
//                  <input name='description' type='text' class='form-control des"+id+"' placeholder='Description' >

                    //set field
                    var remove_btn_field="<td><a class='remove' data-id='" + id + "' data-name='" + id + "' href='javascript:void(0)'><i class='icon icon-cancel rm-icon '></i> </a> </td>";
                    var des_type="<span class='des-type" + id + "' id='des-type"+id+"'></span>";
                    var des_field="<td class='font-btb'> <div class='row'><div class='col-md-2'>"+des_type+"</div>   <div class='col-md-10'><select name='description' class='custom-select select2  inv-des" + id + "'' > <option value=''>Select None</option> </select></div> </div></td>";
                    var code_part_field="<td><select name='code_part' class='custom-select select2  inv-code-part" + id + "'' > <option value=''>Select None</option> </select></td>";
                    var note_field="<td><input name='note' type='text' class='form-control note"+id+" note' data-id='" + id + "' data-name='" + id + "' placeholder='Note' ></td>";
                    var qty_field="<td class='text-center' width='150px'> <div class='qty-input'><i class='less' data-id='" + id + "' data-name='" + id + "'><i class='icon icon-minus qty-size'></i></i> <input type='text' class='inputQty"+id+" qty"+id+" input_qty' data-id='" + id + "' data-name='" + id + "' value='"+qty+"'/>  <i class='more' data-id='" +id+ "' data-name='" + id + "'><i class='icon icon-plus qty-size'></i></i>  </div>  <span class='text-danger'  id='errorQty"+id+"'></span> </td>";
                    var cost_price_field="<td><input name='cost_price' type='number' class='form-control cost-price"+id+" cost-price' data-id='" + id + "' data-name='" + id + "' placeholder='$0.00' ></td>";
                    var price_field="<td><input name='sell_price' type='number' class='form-control price"+id+" price' data-id='" + id + "' data-name='" + id + "' placeholder='$0.00' ></td>";
                    var total_price_field="<td class='text-center'><span id='total_price"+id+"'> " + total+ " </span></td>";

                    //display default field
                    $('#detail-table').append("<tr class=' pro-remove product" + id + "'> + <!--ID--> <td style='display: none'><input type='hidden' value='"+id+"'> <!--Remove button--> "+remove_btn_field+" +  <!--Description-->  "+des_field+" <!-- Code Part --> "+code_part_field+" "+note_field+" <!--Qty--> "+qty_field+"  <!--Cost Price-->  "+cost_price_field+"  <!--Sell Price-->  "+price_field+"  <!--Total--> "+total_price_field+" </tr>");

                    //modify select2 again to make it work
                    $(function(){

                        //modify select2
                        $(".inv-des"+id).select2({
                            tags: true
                        });

                        $(".inv-code-part"+id).select2({
                            tags: true
                        });

                        //add icon no description type
                        document.getElementById('des-type'+id).innerHTML = '<p><i class="des-type-no-des qtip tip-top" data-tip="No Description"><span class="icon icon-circle-o"></span></i></p>';

                        //add list product to description
                        var url_req="{{url('/invoice_products')}}";
                        $.get(url_req,function (data,status){
                            //console.log(data);
                            option+='<option value="">Select None</option>';
                            for (var i=0;i<data.length;i++){
                                option+='<option value="'+data[i].name+'">'+data[i].name +'</option>';
                            }

                            $('.inv-des'+id).html(option);
                        });

                    });

                    //on change select
                    $(document.body).on("change",".inv-des"+id,function(){

                        var des = $('.inv-des' + id).val();
                        if (des!=''){

                            //check if product already add
                            //create duplicate false
                            var dup=0;
                            //count rows
                            var rowCount = $('#detail-table >tbody >tr').length;

                            //loop every field in table to get value by index
                            for(var i=1;i<rowCount+1;i++) {

                                //get description
                                var des2 = $('#detail-table tr').eq(i).find('td').eq(2).find("select").val();

                                //get table field id from table
                                var table_id=parseInt($('#detail-table tr').eq(i).find('td').eq(0).find("input").val());

                                //if product already added and id is not the same with table field id
                                if (des2==des&&id!=table_id){
                                    //change duplicate to true
                                    dup=1;
                                    break;
                                }
                            }

                            //only add if duplicate is false
                            if (dup==0){
                                $.ajax({
                                    type: 'post',
                                    url: "{{route('invoice_des.check')}}",
                                    data: {
                                        "_token": "<?=csrf_token()?>",
                                        'des': des,
                                        'id' : id
                                    },
                                    success: function (data) {
//                                console.log(data);
                                        if (data.des=='false'){
                                            document.getElementById('des-type'+id).innerHTML = '<p><i class="des-type-pro qtip tip-top" data-tip="Product"><span class="icon icon-package2"></span></i></p>';

                                            option2='';
                                            option2+='<option value="">Select None</option>';

                                            for (var i=0;i<data.code_part.length;i++){
                                                option2+='<option value="'+data.code_part[i].id+'">'+data.code_part[i].code_part +'</option>';
                                            }

                                            $('.inv-code-part'+id).html(option2);

                                            //on change code part
                                            $(document.body).on("change",".inv-code-part"+id,function(){
                                                var code_part = $('.inv-code-part' + id).val();
                                                if (code_part!=''){
                                                    //get cost price and sell price when change product
                                                    var url_req="{{url('get-product/')}}/"+code_part;
                                                    $.get(url_req,function (data) {
                                                        //console.log(data);
                                                        $('.cost-price'+id).val(data.cost_price);
                                                        //add sell price
                                                        $('.price'+id).val(data.sell_price);
                                                        var qty=parseFloat($('.qty'+id).val());

                                                        check_pro_qty(id,qty);
                                                        //update subtotal
                                                        subtotal(data.sell_price,qty,id);
                                                        grand_total();
                                                    });
                                                }
                                            });


                                        }else{
                                            /*
                                             //send sidebar to back side
                                             refresh();
                                             //ask if want to add new product or not
                                             swal({
                                             title: "Add this to product?",
                                             text: 'This will add automatically to product.',
                                             type: "warning",
                                             showCancelButton: true,
                                             confirmButtonClass: "btn-success",
                                             confirmButtonText: "Yes, add it!",
                                             closeOnConfirm: false
                                             },
                                             function(){
                                             //if new product
                                             document.getElementById('des-type'+id).innerHTML = '<p><i class="des-type qtip tip-top" data-tip="New Product"><span class="icon icon-package2"></span></i></p>';
                                             swal_alert('Added','','success');
                                             });*/

                                            //if other

                                            //clear select
                                            $('.inv-code-part'+id).empty();

                                            document.getElementById('des-type'+id).innerHTML = '<p><i class="des-type-des qtip tip-top" data-tip="Other"><span class="icon icon-note-list2"></span></i></p>';

                                        }

                                    }
                                });
                            }else{
                                alert_toast_error('This product is already taken!');
                                //make select to default
                                $('.inv-des'+id).val("").change();
                            }

                        }else{
                            //add icon no description type
                            document.getElementById('des-type'+id).innerHTML = '<p><i class="des-type-no-des qtip tip-top" data-tip="No Description"><span class="icon icon-circle-o"></span></i></p>';

                        }

                    });
                }else{
                    for (var i = 0; i < data.detail.length; i++) {
                        //set value default to field
                        var id=data.detail[i].id;
                        var qty=data.detail[i].qty;
                        var cost_price=data.detail[i].cost_price;
                        var price=data.detail[i].price;
                        var total="$" + parseFloat(data.detail[i].total).format(2);
                        var note=data.detail[i].note;
                        if (note==null){
                            note='';
                        }
                        var des='';

                        //set field
                        var remove_btn_field="<td><a class='remove' data-id='" + id + "' data-name='" + id + "' href='javascript:void(0)'><i class='icon icon-cancel rm-icon '></i> </a> </td>";
                        var des_type="<span id='des-type"+id+"'></span>";
                        var des_field="<td> <div class='row'><div class='col-md-2'>"+des_type+"</div>   <div class='col-md-10'><select disabled name='description' class='custom-select select2 inv-des" + id + "''> <option value=''>Select None</option> </select></div> </div></td>";
                        var code_part_field="<td><select disabled name='code_part' class='custom-select select2  inv-code-part" + id + "'' > <option value=''>Select None</option> </select></td>";
                        var note_field="<td><input name='note' type='text' class='form-control note"+id+" note' data-id='" + id + "' data-name='" + id + "' placeholder='Note' value='"+note+"'></td>";
                        var qty_field="<td class='text-center' width='150px'> <div class='qty-input'><i class='less' data-id='" + id + "' data-name='" + id + "'><i class='icon icon-minus qty-size'></i></i> <input type='text' class='inputQty"+id+" qty"+id+" input_qty' data-id='" + id + "' data-name='" + id + "' value='"+qty+"'/>  <i class='more' data-id='" +id+ "' data-name='" + id + "'><i class='icon icon-plus qty-size'></i></i>  </div>  <span class='text-danger'  id='errorQty"+id+"'></span> </td>";
                        var cost_price_field="<td><input name='cost_price' type='number' class='form-control cost-price"+id+" cost-price' data-id='" + id + "' data-name='" + id + "' placeholder='$0.00' value='"+cost_price+"'></td>";
                        var price_field="<td><input name='sell_price' type='number' class='form-control price"+id+" price' data-id='" + id + "' data-name='" + id + "' placeholder='$0.00' value='"+price+"' ></td>";
                        var total_price_field="<td class='text-center'><span id='total_price"+id+"'> " + total+ " </span></td>";

                        //display default field
                        $('#detail-table').append("<tr class=' pro-remove product" + id + "'> + <!--ID--> <td style='display: none'><input type='hidden' value='"+id+"'> <!--Remove button--> "+remove_btn_field+" +  <!--Description-->  "+des_field+" <!-- Code Part --> "+code_part_field+" "+note_field+" <!--Qty--> "+qty_field+" <!--Cost Price-->  "+cost_price_field+" <!--Sell Price-->  "+price_field+"  <!--Total--> "+total_price_field+" </tr>");

                        //modify select2 again to make it work

                        //modify select2
                        $(".inv-des"+id).select2({
                            tags: true
                        });

                        $(".inv-code-part"+id).select2({
                            tags: true
                        });

                        //change icon type
                        if (data.detail[i].type=='other'){
                            document.getElementById('des-type'+id).innerHTML = '<p><i class="des-type-des qtip tip-top" data-tip="Other"><span class="icon icon-note-list2"></span></i></p>';
                        }else{
                            document.getElementById('des-type'+id).innerHTML = '<p><i class="des-type-pro qtip tip-top" data-tip="Product"><span class="icon icon-package2"></span></i></p>';
                        }

                        //add list product to description
                        option='';
                        option2='';

                        option+='<option value="">Select None</option>';
                        option2+='<option value="">Select None</option>';
                        //if detail type is other
                        if (data.detail[i].type=='other'){
                            option+='<option selected value="'+data.detail[i].des+'">'+data.detail[i].des +'</option>';
                             /*for (var j=0;j<data.sale_product.length;j++){
                                option+='<option value="'+data.sale_product[j].id+'">'+data.sale_product[j].name +'</option>';
                             }*/
                        }else{
                            option+='<option selected value="'+data.detail[i].pro_id+'">'+data.detail[i].pro_name +'</option>';
                            option2+='<option selected value="'+data.detail[i].pro_id+'">'+data.detail[i].code_part +'</option>';
                            /*for (var j=0;j<data.sale_product.length;j++){
                             if (data.detail[i].pro_id==data.sale_product[j].id){
                             option+='<option selected value="'+data.sale_product[j].id+'">'+data.sale_product[j].name +'</option>';
                             break;
                             }
                             }*/
                            /*for (var j=0;j<data.sale_product.length;j++){
                             if (data.detail[i].pro_id==data.sale_product[j].id){
                             option+='<option selected value="'+data.sale_product[j].id+'">'+data.sale_product[j].name +'</option>';
                             }else{
                             option+='<option value="'+data.sale_product[j].id+'">'+data.sale_product[j].name +'</option>';
                             }
                             }*/
                        }

                        //alert(option);

                        $('.inv-des'+id).html(option);
                        $('.inv-code-part'+id).html(option2);
//                    alert($('.inv-des'+id).val());


                        //on change select when load start
                        /*    $(document.body).on("change",".inv-des"+id,function(){
                         var des = $('.inv-des'+id).val();

                         if (des!=''){

                         //check if product already add
                         //create duplicate false
                         var dup=0;
                         //count rows
                         var rowCount = $('#detail-table >tbody >tr').length;

                         //loop every field in table to get value by index
                         for(var i=1;i<rowCount+1;i++) {

                         //get description
                         var des2 = $('#detail-table tr').eq(i).find('td').eq(2).find("select").val();

                         //get table field id from table
                         var table_id=parseInt($('#detail-table tr').eq(i).find('td').eq(0).find("input").val());

                         //if product already added and id is not the same with table field id
                         if (des2==des&&id!=table_id){
                         //change duplicate to true
                         dup=1;
                         break;
                         }
                         }

                         //only add if duplicate is false
                         if (dup==0){
                         $.ajax({
                         type: 'post',
                         url: "{route('sale_des.check')}}",
                         data: {
                         "_token": "<=csrf_token()?>",
                         'des': des,
                         'id' : id
                         },
                         success: function (data2) {
                         console.log(data2);
                         if (data2.des=='false'){
                         document.getElementById('des-type'+id).innerHTML = '<p><i class="des-type-pro qtip tip-top" data-tip="Product"><span class="icon icon-package2"></span></i></p>';
                         }else{
                         //send sidebar to back side
                         refresh();
                         //ask if want to add new product or not
                         swal({
                         title: "Add this to product?",
                         text: 'This will add automatically to product.',
                         type: "warning",
                         showCancelButton: true,
                         confirmButtonClass: "btn-success",
                         confirmButtonText: "Yes, add it!",
                         closeOnConfirm: false
                         },
                         function(){
                         //if new product
                         document.getElementById('des-type'+id).innerHTML = '<p><i class="des-type qtip tip-top" data-tip="New Product"><span class="icon icon-package2"></span></i></p>';
                         swal_alert('Added','','success');
                         });

                         //if other
                         document.getElementById('des-type'+id).innerHTML = '<p><i class="des-type-des qtip tip-top" data-tip="Other"><span class="icon icon-note-list2"></span></i></p>';

                         }

                         }
                         });
                         }else{
                         alert_toast_error('This product is already taken!');
                         //make select to default
                         $('.inv-des'+id).val("").change();

                         }

                         }else{
                         //add icon no description type
                         document.getElementById('des-type'+id).innerHTML = '<p><i class="des-type-no-des qtip tip-top" data-tip="No Description"><span class="icon icon-circle-o"></span></i></p>';

                         }

                         });*/
                        //on change select when load end

                        //if last index add all product to list option
                        if (i==data.detail.length-1){
                            //add all product to select
                            option='';
                            option+='<option value="">Select None</option>';
                            for (var j=0;j<data.invoice_product.length;j++) {
                                option += '<option value="' + data.invoice_product[j].id + '">' + data.invoice_product[j].name + '</option>';
                            }
                        }
                    }
                }


            });


            //update grand total
            //if grand total no value
            var grand_total=$('#amount').val();
            if (isNaN(grand_total)||grand_total==0){
                document.getElementById('grand-total').innerHTML = '$0.00';
            }else{
                document.getElementById('grand-total').innerHTML = "$" + parseFloat(grand_total).format(2);
            }

            //add active on nav bar
            $('.no-active3').removeClass('no-active3').addClass('active');

            //change discount amount icon
            @if($master->dis_type=='fixed')
                $('#dis-amount-icon').html('<span class="icon icon-money"></span>');
            @elseif($master->dis_type=='percentage')
                $('#dis-amount-icon').html('<span class="icon icon-percent"></span>');
            @else
                $('#dis-amount-icon').html('<span class="icon icon-info"></span>');
            @endif

        });

        //Master
        $("#btn-save").click(function (e) {
            e.preventDefault();
            //Check detail
            var detail='false';
            var detail2='true';
            var check_qty='true';

            //count rows
            var rowCount = $('#detail-table >tbody >tr').length;

            //loop every field in table to get value by index
            for(var i=1;i<rowCount+1;i++) {
                //get description
                var des = $('#detail-table tr').eq(i).find('td').eq(2).find("select").val();
                var qty = $('#detail-table tr').eq(i).find('td').eq(5).find("input").val();

                if (des!=''&&des!=null&&qty>0){
                    detail='true';
                }

                //check if des or product or new product
                var html_des=$('#detail-table tr').eq(i).find('td').eq(2).find("span").html();

                if (html_des=='<p><i class="des-type-pro qtip tip-top" data-tip="Product"><span class="icon icon-package2"></span></i></p>'){
                    var code_part = $('#detail-table tr').eq(i).find('td').eq(3).find("select").val();
                    if (code_part==''||code_part==null){
                        detail2='false';
                    }else{
                        var invoice_id=$('#master_id').val();
                        //if product and code part exit check product qty
                        //check qty
                        $.ajax({
                            type: 'post',
                            url: "{{route('invoice_product_qty.check')}}",
                            data: {
                                "_token": "<?=csrf_token()?>",
                                'qty': qty,
                                'code_part': code_part,
                                'invoice_id': invoice_id
                            },
                            success: function (data) {
//                                console.log(data);
                                if (data.check_qty == 'false') {
                                    check_qty='false';
                                }
                            }
                        });
                    }
                }
            }

            //if no detail
            if (detail=='false'||detail2=='false'){
                swal_alert('Empty','You don\'t have any products or services to sell.','error');
                return;
            }

            //if error qty product
            if(check_qty=='false'){
                swal_alert('Qty Error','You don\'t have enough qty to sell !','error');
                return;
            }

            //Add master
            clear_border(['input1','input2','input3','input4','input5','input6','input7']);
            clear_error(['error1','error2','error3','error4','error5','error6','error7']);

            var date= $.datepicker.formatDate("yy-mm-dd", new Date($('#date').val()));
            //if date is empty
            if (date=='NaN-NaN-NaN'){
                date='';
            }

            var amount=$('#grand-total').html();
            var total_amount= $('#total-payable').html();
            var dis_type=$('#dis-type').val();
            var dis_amount=$('#dis-amount-input').val()*1;
            var dis_total_amount=$('#dis-amount').html();

            var form = new FormData($("#form-master")[0]);
            form.append('date',date);
            form.append('amount',amount.replace('$',''));
            form.append('total_amount',total_amount.replace('$',''));
            form.append('dis_type',dis_type);
            form.append('dis_amount',dis_amount);
            form.append('dis_total_amount',dis_total_amount.replace('$',''));

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
                    console.log(data);

                    if ((data.errors)) {

                        data_error(data.errors.customer,'error1','input1');
                        data_error(data.errors.date,'error2','input2');
                        data_error(data.errors.km,'error5','input5');
                        data_error(data.errors.ro,'error6','input6');
                        data_error(data.errors.note,'error7','input7');

                    }

                    if(data.verify=='true'){
//                        $("#form-product")[0].reset();

                        var invoice_id=data.invoice_id;
                        //Add Detail

                        //count rows
                        var rowCount = $('#detail-table >tbody >tr').length;

                        //loop every field in table to get value by index
                        for(var i=1;i<rowCount+1;i++) {

                            //get description type
                            var des_type = '';
                            //check if des or product or new product
                            var html_des=$('#detail-table tr').eq(i).find('td').eq(2).find("span").html();

                            if (html_des=='<p><i class="des-type-pro qtip tip-top" data-tip="Product"><span class="icon icon-package2"></span></i></p>'){
                                des_type='product';
                            }else if (html_des=='<p><i class="des-type qtip tip-top" data-tip="New Product"><span class="icon icon-package2"></span></i></p>'){
                                des_type='new_product';
                            }else{
                                des_type='other';
                            }

                            //get description
                            var des=$('#detail-table tr').eq(i).find('td').eq(2).find("select").val();
                            //get code part
                            var code_part=$('#detail-table tr').eq(i).find('td').eq(3).find("select").val();
                            //get note
                            var note=$('#detail-table tr').eq(i).find('td').eq(4).find("input").val();
                            //get qty
                            var qty=parseFloat($('#detail-table tr').eq(i).find('td').eq(5).find("input").val());
                            //get cost price
                            var cost_price=parseFloat($('#detail-table tr').eq(i).find('td').eq(6).find("input").val());
                            //get price
                            var price=parseFloat($('#detail-table tr').eq(i).find('td').eq(7).find("input").val());

                            //get total cost
                            var total=parseFloat(qty*price);

//                            alert(total);
                            //check if the last row
                            var last='false';
                            if (i==rowCount){
                                last='true';
                            }

                            //Add to database
                            $.ajax({
                                async: false,
                                type: 'post',
                                url: "{{route('save_update_detail.invoice')}}",
                                data: {
                                    "_token":"<?=csrf_token()?>",
                                    'qty': qty,
                                    'cost_price':cost_price,
                                    'price':price,
                                    'des_type':des_type,
                                    'des':des,
                                    'code_part':code_part,
                                    'note':note,
                                    'total':total,
                                    'invoice_id':invoice_id,
                                    'last':last
                                },
                                success: function(data) {
//                                    console.log(data);
                                    //only refresh if the last row
                                    if (data.last=='true'){
                                        //Payment
                                        var payment_amount=$('#payment-amount').val();
                                        if (payment_amount!=''&&payment_amount!=null){
                                            if (payment_amount>0){
                                                var form = new FormData($("#form-payment")[0]);
                                                form.append('invoice_id',invoice_id);

                                                //Add payment to database
                                                $.ajax({
                                                    async: false,
                                                    url: "{{route('save_update_payment.invoice')}}",
                                                    method: "POST",
                                                    dataType: 'json',
                                                    data: form,
                                                    processData: false,
                                                    contentType: false,
                                                    success: function (data) {
//                                                    console.log(data);

                                                        if (data.verify=='true'){
                                                            window.location.href='{{url(config('global.index_link'))}}';
                                                        }

                                                    }
                                                });
                                            }else{
                                                window.location.href='{{url(config('global.index_link'))}}';
                                            }

                                        }else{
                                            window.location.href='{{url(config('global.index_link'))}}';

                                        }

                                    }


                                }
                            });

                        }


                        {{--                        window.location.href='{{url(config('global.index_link'))}}';--}}
                    }

                },
                error: function(er){}
            });
        });

        //Detail

        //when click on plus qty
        $(document).on('click', '.more', function(e) {
            e.preventDefault();
            //get qty to plus
            var qty=parseFloat($('.qty'+$(this).data('id')).val())+1;
            //change value
            $('.qty'+$(this).data('id')).val(qty);

            //get cost price value
            var price = parseFloat($('.price' + $(this).data('id')).val());

            //check product qty
            check_pro_qty($(this).data('id'),qty);

            subtotal(price,qty,$(this).data('id'));
            grand_total();

        });

        //when click on minus qty
        $(document).on('click', '.less', function(e) {
            e.preventDefault();
            //get qty to minus
            var qty=parseFloat($('.qty'+$(this).data('id')).val())-1;
            //change value
            $('.qty'+$(this).data('id')).val(qty);

            //get cost price value
            var price = parseFloat($('.price' + $(this).data('id')).val());

            //check product qty
            check_pro_qty($(this).data('id'),qty);

            subtotal(price,qty,$(this).data('id'));
            grand_total();

        });

        //Input Qty
        $(document).on('change', '.input_qty', function(e) {
            e.preventDefault();

            var qty=parseFloat($('.qty'+$(this).data('id')).val());
            //get cost price value
            var price = parseFloat($('.price' + $(this).data('id')).val());

            //check product qty
            check_pro_qty($(this).data('id'),qty);

            subtotal(price,qty,$(this).data('id'));
            grand_total();
        });

        //Check Qty Product
        function check_pro_qty(id,qty) {
            var invoice_id=$('#master_id').val();

            var html_des=$('.des-type'+id).html();
            var des_type='';
            if (html_des=='<p><i class="des-type-pro qtip tip-top" data-tip="Product"><span class="icon icon-package2"></span></i></p>'){
                des_type='product';
            }else{
                des_type='other';
            }

            //check product qty start
            //get description value
            var code_part = $('.inv-code-part' + id).val();

            if (code_part==''||code_part==null&&des_type=='product'){
                $('.qty'+id).val('0');
                alert_toast_error('Please add description first!');
            }else{
                $.ajax({
                    type: 'post',
                    url: "{{route('invoice_product_qty.check')}}",
                    data: {
                        "_token": "<?=csrf_token()?>",
                        'qty': qty,
                        'code_part': code_part,
                        'id' : id,
                        'invoice_id':invoice_id
                    },
                    success: function (data) {
//                        console.log(data);
                        if (data.check_qty=='false'){
                            //alert error if the qty is not enough
                            $('.inputQty'+data.id).addClass('error-qty');
                            var pro_qty=data.pro_qty;
                            if (pro_qty==null||pro_qty==''){
                                pro_qty=0;
                            }
                            document.getElementById('errorQty'+data.id).innerHTML = '<br> <strong> Only '+pro_qty+' available</strong>';
                        }else{
                            $('.inputQty'+data.id).removeClass('error-qty');
                            document.getElementById('errorQty'+data.id).innerHTML = '';
                        }

                    }
                });

            }
            //check product qty end
        }

        //Input Price
        $(document).on('change', '.price', function(e) {
            e.preventDefault();

            //get cost price value
            var price = parseFloat($('.price' + $(this).data('id')).val());
            //get qty
            var qty=parseFloat($('.qty'+$(this).data('id')).val());

            subtotal(price,qty,$(this).data('id'));
            grand_total();
        });

        // When click on add new button
        $('#add-new').click(function () {

            //count table row
            var row_count = $('#detail-table >tbody >tr').length;

            //check if all description is already have or not
            //make no description to false
            var no_des=0;
            //loop every field in table to get value by index
            for(var i=1;i<row_count+1;i++) {

                //get description
                var des = $('#detail-table tr').eq(i).find('td').eq(2).find("select").val();

                if (des==''){
                    //make no description to true
                    no_des=1;
                    break;
                }
            }

            //if already have all description
            if (no_des==0){

                //get old id
                var old_id=parseInt($('#detail-table tr').eq(row_count).find('td').eq(0).find("input").val());
                //set id to last and add 1
                var id=old_id+1;

                //set value default to field
                var qty=0;
                var price=0;
                var sell_price=0;
                var total='$0.00';
                var des='';
//              <input name='description' type='text' class='form-control des"+id+"' placeholder='Description' >

                //set field
                var remove_btn_field="<td><a class='remove' data-id='" + id + "' data-name='" + id + "' href='javascript:void(0)'><i class='icon icon-cancel rm-icon '></i> </a> </td>";
                var des_type="<span class='des-type" + id + "' id='des-type"+id+"'></span>";
                var des_field="<td class='font-btb'> <div class='row'><div class='col-md-2'>"+des_type+"</div>   <div class='col-md-10'><select name='description' class='custom-select select2  inv-des" + id + "'' > <option value=''>Select None</option> </select></div> </div></td>";
                var code_part_field="<td><select name='code_part' class='custom-select select2  inv-code-part" + id + "'' > <option value=''>Select None</option> </select></td>";
                var note_field="<td><input name='note' type='text' class='form-control note"+id+" note' data-id='" + id + "' data-name='" + id + "' placeholder='Note'></td>";
                var qty_field="<td class='text-center' width='150px'> <div class='qty-input'><i class='less' data-id='" + id + "' data-name='" + id + "'><i class='icon icon-minus qty-size'></i></i> <input type='text' class='inputQty"+id+" qty"+id+" input_qty' data-id='" + id + "' data-name='" + id + "' value='"+qty+"'/>  <i class='more' data-id='" +id+ "' data-name='" + id + "'><i class='icon icon-plus qty-size'></i></i>  </div>  <span class='text-danger'  id='errorQty"+id+"'></span> </td>";
                var cost_price_field="<td><input name='cost_price' type='number' class='form-control cost-price"+id+" cost-price' data-id='" + id + "' data-name='" + id + "' placeholder='$0.00' ></td>";
                var price_field="<td><input name='sell_price' type='number' class='form-control price"+id+" price' data-id='" + id + "' data-name='" + id + "' placeholder='$0.00' ></td>";
                var total_price_field="<td class='text-center'><span id='total_price"+id+"'> " + total+ " </span></td>";

                //display default field
                $('#detail-table').append("<tr class=' pro-remove product" + id + "'> + <!--ID--> <td style='display: none'><input type='hidden' value='"+id+"'> <!--Remove button--> "+remove_btn_field+" +  <!--Description-->  "+des_field+" <!-- Code Part --> "+code_part_field+" "+note_field+" <!--Qty--> "+qty_field+" <!--Cost Price-->  "+cost_price_field+" <!--Sell Price-->  "+price_field+"  <!--Total--> "+total_price_field+" </tr>");

                //modify select2 again to make it work
                $(function(){

                    option='';

                    //modify select2
                    $(".inv-des"+id).select2({
                        tags: true
                    });

                    $(".inv-code-part"+id).select2({
                        tags: true
                    });

                    //add icon no description type
                    document.getElementById('des-type'+id).innerHTML = '<p><i class="des-type-no-des qtip tip-top" data-tip="No Description"><span class="icon icon-circle-o"></span></i></p>';

                    //add list product to description
                    var url_req="{{url('/invoice_products')}}";
                    $.get(url_req,function (data,status){
                        //console.log(data);
                        option+='<option value="">Select None</option>';
                        for (var i=0;i<data.length;i++){
                            option+='<option value="'+data[i].name+'">'+data[i].name +'</option>';
                        }

                        $('.inv-des'+id).html(option);
                    });

                });

                //on change select
                $(document.body).on("change",".inv-des"+id,function(){

                    var des = $('.inv-des' + id).val();
                    if (des!=''){

                        //check if product already add
                        //create duplicate false
                        var dup=0;
                        //count rows
                        var rowCount = $('#detail-table >tbody >tr').length;

                        //loop every field in table to get value by index
                        for(var i=1;i<rowCount+1;i++) {

                            //get description
                            var des2 = $('#detail-table tr').eq(i).find('td').eq(2).find("select").val();

                            //get table field id from table
                            var table_id=parseInt($('#detail-table tr').eq(i).find('td').eq(0).find("input").val());

                            //if product already added and id is not the same with table field id
                            if (des2==des&&id!=table_id){
                                //change duplicate to true
                                dup=1;
                                break;
                            }
                        }

                        //only add if duplicate is false
                        if (dup==0){
                            $.ajax({
                                type: 'post',
                                url: "{{route('invoice_des.check')}}",
                                data: {
                                    "_token": "<?=csrf_token()?>",
                                    'des': des,
                                    'id' : id
                                },
                                success: function (data) {
//                                    console.log(data);
                                    if (data.des=='false'){
                                        document.getElementById('des-type'+id).innerHTML = '<p><i class="des-type-pro qtip tip-top" data-tip="Product"><span class="icon icon-package2"></span></i></p>';

                                        option2='';
                                        option2+='<option value="">Select None</option>';

                                        for (var i=0;i<data.code_part.length;i++){
                                            option2+='<option value="'+data.code_part[i].id+'">'+data.code_part[i].code_part +'</option>';
                                        }

                                        $('.inv-code-part'+id).html(option2);

                                        //on change code part
                                        $(document.body).on("change",".inv-code-part"+id,function(){
                                            var code_part = $('.inv-code-part' + id).val();
                                            if (code_part!=''){
                                                //get cost price and sell price when change product
                                                var url_req="{{url('get-product/')}}/"+code_part;
                                                $.get(url_req,function (data) {
                                                    //                                        console.log(data);
                                                    //add sell price
                                                    $('.cost-price'+id).val(data.cost_price);
                                                    $('.price'+id).val(data.sell_price);
                                                    var qty=parseFloat($('.qty'+id).val());

                                                    check_pro_qty(id,qty);
                                                    //update subtotal
                                                    subtotal(data.sell_price,qty,id);
                                                    grand_total();
                                                });
                                            }
                                        });


                                    }else{
                                        /*
                                         //send sidebar to back side
                                         refresh();
                                         //ask if want to add new product or not
                                         swal({
                                         title: "Add this to product?",
                                         text: 'This will add automatically to product.',
                                         type: "warning",
                                         showCancelButton: true,
                                         confirmButtonClass: "btn-success",
                                         confirmButtonText: "Yes, add it!",
                                         closeOnConfirm: false
                                         },
                                         function(){
                                         //if new product
                                         document.getElementById('des-type'+id).innerHTML = '<p><i class="des-type qtip tip-top" data-tip="New Product"><span class="icon icon-package2"></span></i></p>';
                                         swal_alert('Added','','success');
                                         });*/

                                        //if other

                                        //clear select
                                        $('.inv-code-part'+id).empty();

                                        document.getElementById('des-type'+id).innerHTML = '<p><i class="des-type-des qtip tip-top" data-tip="Other"><span class="icon icon-note-list2"></span></i></p>';

                                    }

                                }
                            });
                        }else{
                            alert_toast_error('This product is already taken!');
                            //make select to default
                            $('.inv-des'+id).val("").change();
                        }

                    }else{
                        //add icon no description type
                        document.getElementById('des-type'+id).innerHTML = '<p><i class="des-type-no-des qtip tip-top" data-tip="No Description"><span class="icon icon-circle-o"></span></i></p>';

                    }

                });
            }else{
                alert_toast_error('Please add description before add new!')
            }




        });

        //When click on remove button
        $(document).on('click', '.remove', function(e) {
            e.preventDefault();

            var rowCount = $('#detail-table >tbody >tr').length;
            //if remove on default
            if(rowCount==1){
                //get last id
                var last_id=parseInt($('#detail-table tr').eq(rowCount).find('td').eq(0).find("input").val());
                //reset all to default
                $('.qty'+last_id).val(0);
                $('.cost-price'+last_id).val(0);
                $('.price'+last_id).val(0);
                $('.inv-des'+last_id).val("").change();
                $('.inv-code-part'+last_id).val("").change();

                enable_select(['.inv-des'+last_id,'.inv-code-part'+last_id]);

                document.getElementById('total_price'+last_id).innerHTML = '$0.00';
                //modify select2 again to make it work
                $(function(){

                    option='';

                    //modify select2
                    $(".inv-des"+last_id).select2({
                        tags: true
                    });

                    $(".inv-code-part"+last_id).select2({
                        tags: true
                    });

                    //add icon no description type
                    document.getElementById('des-type'+last_id).innerHTML = '<p><i class="des-type-no-des qtip tip-top" data-tip="No Description"><span class="icon icon-circle-o"></span></i></p>';

                    //add list product to description
                    var url_req="{{url('/invoice_products')}}";
                    $.get(url_req,function (data,status){
                        //console.log(data);
                        option+='<option value="">Select None</option>';
                        for (var i=0;i<data.length;i++){
                            option+='<option value="'+data[i].name+'">'+data[i].name +'</option>';
                        }

                        $('.inv-des'+last_id).html(option);
                    });

                });

                //on change select
                $(document.body).on("change",".inv-des"+last_id,function(){

                    var des = $('.inv-des' + last_id).val();
                    if (des!=''){

                        //check if product already add
                        //create duplicate false
                        var dup=0;
                        //count rows
                        var rowCount = $('#detail-table >tbody >tr').length;

                        //loop every field in table to get value by index
                        for(var i=1;i<rowCount+1;i++) {

                            //get description
                            var des2 = $('#detail-table tr').eq(i).find('td').eq(2).find("select").val();

                            //get table field id from table
                            var table_id=parseInt($('#detail-table tr').eq(i).find('td').eq(0).find("input").val());

                            //if product already added and id is not the same with table field id
                            if (des2==des&&last_id!=table_id){
                                //change duplicate to true
                                dup=1;
                                break;
                            }
                        }

                        //only add if duplicate is false
                        if (dup==0){
                            $.ajax({
                                type: 'post',
                                url: "{{route('invoice_des.check')}}",
                                data: {
                                    "_token": "<?=csrf_token()?>",
                                    'des': des,
                                    'id' : last_id
                                },
                                success: function (data) {
//                                    console.log(data);
                                    if (data.des=='false'){
                                        document.getElementById('des-type'+last_id).innerHTML = '<p><i class="des-type-pro qtip tip-top" data-tip="Product"><span class="icon icon-package2"></span></i></p>';

                                        option2='';
                                        option2+='<option value="">Select None</option>';

                                        for (var i=0;i<data.code_part.length;i++){
                                            option2+='<option value="'+data.code_part[i].id+'">'+data.code_part[i].code_part +'</option>';
                                        }

                                        $('.inv-code-part'+last_id).html(option2);

                                        //on change code part
                                        $(document.body).on("change",".inv-code-part"+last_id,function(){
                                            var code_part = $('.inv-code-part' + last_id).val();
                                            if (code_part!=''){
                                                //get cost price and sell price when change product
                                                var url_req="{{url('get-product/')}}/"+code_part;
                                                $.get(url_req,function (data) {
                                                    //                                        console.log(data);
                                                    //add sell price
                                                    $('.cost-price'+last_id).val(data.cost_price);
                                                    $('.price'+last_id).val(data.sell_price);
                                                    var qty=parseFloat($('.qty'+last_id).val());

                                                    check_pro_qty(last_id,qty);
                                                    //update subtotal
                                                    subtotal(data.sell_price,qty,last_id);
                                                    grand_total();
                                                });
                                            }
                                        });


                                    }else{
                                        /*
                                         //send sidebar to back side
                                         refresh();
                                         //ask if want to add new product or not
                                         swal({
                                         title: "Add this to product?",
                                         text: 'This will add automatically to product.',
                                         type: "warning",
                                         showCancelButton: true,
                                         confirmButtonClass: "btn-success",
                                         confirmButtonText: "Yes, add it!",
                                         closeOnConfirm: false
                                         },
                                         function(){
                                         //if new product
                                         document.getElementById('des-type'+id).innerHTML = '<p><i class="des-type qtip tip-top" data-tip="New Product"><span class="icon icon-package2"></span></i></p>';
                                         swal_alert('Added','','success');
                                         });*/

                                        //if other

                                        //clear select
                                        $('.inv-code-part'+last_id).empty();

                                        document.getElementById('des-type'+last_id).innerHTML = '<p><i class="des-type-des qtip tip-top" data-tip="Other"><span class="icon icon-note-list2"></span></i></p>';

                                    }

                                }
                            });
                        }else{
                            alert_toast_error('This product is already taken!');
                            //make select to default
                            $('.inv-des'+last_id).val("").change();
                        }

                    }else{
                        //add icon no description type
                        document.getElementById('des-type'+last_id).innerHTML = '<p><i class="des-type-no-des qtip tip-top" data-tip="No Description"><span class="icon icon-circle-o"></span></i></p>';

                    }

                });
            }else{
                $('.product' + $(this).data('id')).remove();
            }


//            $('.product' + $(this).data('id')).remove();

            grand_total();
        });

        //Total
        function subtotal(price,qty,id) {
            //find total cost
            var total=price*qty;

            //display total cost
            //if cost price no value
            if (isNaN(total)){
                document.getElementById('total_price'+id).innerHTML = '$0.00';
            }else{
                document.getElementById('total_price'+id).innerHTML = "$" + parseFloat(total).format(2);
            }
        }

        //Grand total
        function grand_total() {
            var rowCount = $('#detail-table >tbody >tr').length;
            var grand_total=0;

            //loop every field in table to get total cost by index
            //row index start from 1
            for(var i=1;i<rowCount+1;i++) {
                //get qty
                var qty=parseFloat($('#detail-table tr').eq(i).find('td').eq(5).find("input").val());
                //get cost price
                var price=parseFloat($('#detail-table tr').eq(i).find('td').eq(7).find("input").val());

                var total=parseFloat(qty*price);
                if (isNaN(total)){
                    total=0;
                }
                grand_total+=total;

            }

            //display grand total
            //if grand total no value
            if (isNaN(grand_total)){
                document.getElementById('grand-total').innerHTML = '$0.00';
            }else{
                document.getElementById('grand-total').innerHTML = "$" + parseFloat(grand_total).format(2);
            }



            //change discount
            discount();
            //payment
            update_payment();
        }

        function update_payment() {
            var total_payable=($('#total-payable').html()+"").replace(",","");
            var total_payable2=parseFloat(total_payable.replace("$",""))*1;

            var total_paid={{$master->total_paid}};

            var payment_amount=total_payable2-total_paid;

            $('#payment-amount').val(payment_amount);
        }

        //Discount Type Change
        $('#dis-type').on("change", function () {
            if (this.value=='fixed'){
                $('#dis-amount-icon').html('<span class="icon icon-money"></span>');
            }else if(this.value=='percentage'){
                $('#dis-amount-icon').html('<span class="icon icon-percent"></span>');
            }else{
                $('#dis-amount-icon').html('<span class="icon icon-info"></span>');
                $('#dis-amount-input').val('');
            }

            discount();
        });

        //Discount Amount Change
        $('#dis-amount-input').on("input", function () {
            if ($('#dis-type').val()!=''){
                discount();
            }else{
                alert_toast_error("Please select discount type first!");
                $('#dis-amount-input').val('');
            }
            //alert(this.value);


//            alert(grand_total.replace("$",""));

        });

        function discount() {
            var grand_total=($('#grand-total').html()+"").replace(",","");
            var grand_total2=parseFloat(grand_total.replace("$",""))*1;

            var dis_amount=0;
            var total_payable=0;
            var dis_amount_input=($('#dis-amount-input').val()*1)+0;
            //if type fixed
            if ($('#dis-type').val()=='percentage'){
                dis_amount=(grand_total2*dis_amount_input)/100;
            }else if($('#dis-type').val()=='fixed'){
                dis_amount=dis_amount_input;
            }else{
                dis_amount=0;
            }

            total_payable=grand_total2-dis_amount;

            document.getElementById('dis-amount').innerHTML = "$" + parseFloat(dis_amount).format(2);
            document.getElementById('total-payable').innerHTML = "$" + parseFloat(total_payable).format(2);

        }
        float_only(['amount','dis-amount-input']);
    </script>
@endsection


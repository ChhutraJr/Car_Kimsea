@extends('master')
@section('content')

    <div class="page has-sidebar-left">
        {{--Add Master--}}
        <div class="container-fluid animatedParent animateOnce my-3">

            <div class="animated fadeInUpShort shadow">
                <form id="form-master">
                    {{csrf_field()}}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card no-b">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <div class="form-group">
                                                <label for="supplier">Supplier <span class="required">*</span></label>
                                                <select id="supplier" name="supplier" class="custom-select select2 tags input1" >
                                                    <option value="">Select None</option>
                                                    @foreach($sup as $s)
                                                        <option value="{{ $s->id }}">{{$s->name}}</option>
                                                    @endforeach
                                                </select>
                                                <span class="text-danger">
                                                    <strong id="error1"></strong>
                                                </span>

                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="form-group">
                                                <label for="brand">Purchase Date <span class="required">*</span></label>
                                                <div class="input-group date date_picker" data-provide="datepicker">
                                                    <div class="input-group-addon">
                                                        <span class="icon icon-calendar"></span>
                                                    </div>
                                                    <input id="date" onkeydown="return false" type="text" class="form-control input2" placeholder="Select None" name="date">
                                                </div>
                                                <span class="text-danger">
                                                    <strong id="error2"></strong>
                                                </span>
                                            </div>
                                        </div>

                                        {{--<div class="col-md-4 mb-3">
                                            <div class="form-group">
                                                <label>PA</label>
                                                <select id="pa" name="pa[]" class="custom-select select2 input3 select-none" disabled>
                                                    @foreach($users as $s)
                                                        @if ($s->first_name == Auth::user()->first_name && $s->last_name == Auth::user()->last_name)
                                                            <option selected value="{{$s->id}}">{{$s->first_name}} {{ $s->last_name }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>

                                                <span class="text-danger">
                                                    <strong id="error3"></strong>
                                                </span>

                                            </div>
                                        </div>--}}

                                        <div class="col-md-12 mb-3">
                                            <div class="form-group">
                                                <label for="validationCustom04">Purchase Note</label>
                                                <textarea class="form-control input-address hideSearch input7"
                                                          placeholder="Purchase Note" rows="2" name="note" ></textarea>
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
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card-body slimScroll" data-height="100%">

                                            <div class="table-responsive">
                                                <table id="detail-table" class="table table-striped table-bordered" cellspacing="0" width="100%" data-options='{"searching":true}'>
                                                    <thead>
                                                    <tr class="" style="border-bottom: none !important;">
                                                        <th style="display: none"></th>
                                                        <th width="3%"><a href='javascript:void(0)'><i id="add-new" class='icon icon-add add-icon'></i></a></th>
                                                        <th class="text-center">Product</th>
                                                        <th class="text-center" width="17%">Code Part</th>
                                                        <th class="text-center" width="14%">Qty</th>
                                                        <th class="text-center" width="11%">Cost Price</th>
                                                        <th class="text-center" width="10%">Subtotal</th>
                                                        <th class="text-center" width="10%">Profit</th>
                                                        <th class="text-center" width="11%">Sell Price</th>
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
                                                                <th width="205px">Grand Total Cost:</th>
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
                                                    <input id="amount" type="text" name="amount" class="form-control input8" placeholder="0.00">
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

        var option='';
        var option2='';
        //on load
        $(document).ready(function() {

            //set default date to current date
            var now=moment().format('D/MMM/YYYY');
            //declare date
            $('.date_picker').datepicker({
                format: 'dd/M/yyyy',
                todayHighlight:'TRUE',
                autoclose: true

            }).datepicker('setDate', new Date(now)).on("change", function (e) {
                if(!e.target.value){
                    $('.input2').parent().addClass('has-error');
                    $('#error2').html('The date field is required.');
                }
                else{
                    clear_border(['input2']);     //Chart on load
                    clear_error(['error2'])
                }
                //   console.log("Date changed: ", e.target.value);
            }); //default date

            // On change purchase validate supplier
            $('#supplier').on('change', function() {
                on_change_input('supplier','input1','error1','The supplier field is required.');
            });

            //set value default to field
            var id=0;
            var qty=0;
            var cost_price=0;
            var total='$0.00';
            var sell_price=0;
            var profit='$0.00';

            //set field
            /*var des_type="<span id='des-type"+id+"'></span>";
            var des_field="<td> <div class='row'><div class='col-md-2'>"+des_type+"</div>   <div class='col-md-10'><select name='description' class='custom-select select2 inv-des" + id + "'' > <option value=''>Select None</option> </select></div> </div></td>";
            */

            var des_field="<td class='font-btb'> <select name='description' class='custom-select select2 inv-des" + id + "'' > <option value=''>Select None</option> </select> </td>";
            var code_part_field="<td><select name='code_part' class='custom-select select2  inv-code-part" + id + "'' > <option value=''>Select None</option> </select></td>";

            var remove_field="<td><a class='remove' data-id='" + id + "' data-name='" + id + "' href='javascript:void(0)'><i class='icon icon-cancel rm-icon '></i></a> </td>";
            var qty_field="<td class='text-center' width='150px'> <div class='qty-input'><i class='less' data-id='" + id + "' data-name='" + id + "'><i class='icon icon-minus qty-size'></i></i> <input type='text' class='qty"+id+" input_qty' data-id='" + id + "' data-name='" + id + "' value='"+qty+"'/><i class='more' data-id='" +id+ "' data-name='" + id + "'><i class='icon icon-plus qty-size'></i></i> </div> </td> ";
            var cost_price_field="<td class='text-center'><input class='form-control cost_price"+id+" cost_price' data-id='" + id + "' data-name='" + id + "' type='number' placeholder='$0.00' ></td>";
            var subtotal_field="<td class='text-center'><span id='subtotal"+id+"'> " + total+ " </span></td>";
            var sell_price_field="<td><input name='sell_price' type='number' class='form-control sell_price"+id+" sell_price' data-id='" + id + "' data-name='" + id + "' placeholder='$0.00' ></td>";
            var profit_field="<td class='text-center'><span id='profit_price"+id+"'> " + profit+ " </span></td>";

            //display default field
            $('#detail-table').append("<tr class=' pro-remove product" + id + "'> + <!--ID--> <td style='display: none'><input type='hidden' value='"+id+"'></td> <!--Remove button--> "+remove_field+"+ <!-- Product --> "+des_field+" <!-- Code Part--> "+code_part_field+"  <!--Qty--> "+qty_field+"<!--Cost Price--> "+cost_price_field+" "+subtotal_field+" <!--Profit--> "+profit_field+"  <!--Sell Price--> "+sell_price_field+"  </tr>");


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
                //document.getElementById('des-type'+id).innerHTML = '<p><i class="des-type-no-des qtip tip-top" data-tip="No Description"><span class="icon icon-circle-o"></span></i></p>';

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
                                //get cost price and sell price when change product

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
//                                            console.log(data);
                                            //add cost price and sell price
                                            $('.cost_price'+id).val(data.cost_price);
                                            $('.sell_price'+id).val(data.sell_price);
                                            var qty=parseInt($('.qty'+id).val());

                                            //update subtotal
                                            subtotal(data.sell_price,qty,id);
                                            grand_total();
                                        });

                                        /*var url_req="{url('get-product/')}}/"+data.pro_id;
                                        $.get(url_req,function (data) {
//                                        console.log(data);
                                            //add cost price and sell price
                                            $('.cost_price'+id).val(data.cost_price);
                                            $('.sell_price'+id).val(data.sell_price);
                                        });*/

                                    }
                                });

                                /*document.getElementById('des-type'+id).innerHTML = '<p><i class="des-type-pro qtip tip-top" data-tip="Product"><span class="icon icon-package2"></span></i></p>';

                                if (data.des=='true'){

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
                                        function(isConfirm){
                                            if (isConfirm) {
                                                //if new product
                                                document.getElementById('des-type'+id).innerHTML = '<p><i class="des-type qtip tip-top" data-tip="New Product"><span class="icon icon-package2"></span></i></p>';
                                                swal_alert('Added','','success');
                                            }else{
                                                //clear select
                                                $('.inv-des'+id).val("").change();
                                            }

                                        });


                                }else {
                                    //get cost price and sell price when change product
                                    var url_req="{url('get-product/')}}/"+data.pro_id;
                                    $.get(url_req,function (data) {
//                                        console.log(data);
                                        //add cost price and sell price
                                        $('.cost_price'+id).val(data.cost_price);
                                        $('.sell_price'+id).val(data.sell_price);
                                    });
                                }*/

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

            //add active on nav bar
            $('.no-active7').removeClass('no-active7').addClass('active');
            $('.no-active7-2').removeClass('no-active7-2').addClass('active');
        });

        //Master
        $("#btn-save").click(function (e) {
            e.preventDefault();
            //Check detail
            var detail='false';
            //count rows
            var rowCount = $('#detail-table >tbody >tr').length;

            //loop every field in table to get value by index
            for(var i=1;i<rowCount+1;i++) {
                //get description
                var des = $('#detail-table tr').eq(i).find('td').eq(2).find("select").val();
                var qty = $('#detail-table tr').eq(i).find('td').eq(4).find("input").val();

                if (des!=''&&des!=null&&qty>0){
                    detail='true';
                    break;
                }
            }

            //if no detail
            if (detail=='false'){
                swal_alert('Empty','You don\'t have any products to purchase.','error');
                return;
            }

            //Add master
            clear_border(['input1','input2','input3','input4','input5','input6','input7']);
            clear_error(['error1','error2','error3','error4','error5','error6','error7']);

            var date= $.datepicker.formatDate("yy-mm-dd", new Date($('#date').val()));
            var total_amount= $('#grand-total').html();

            //if date is empty
            if (date=='NaN-NaN-NaN'){
                date='';
            }
            var form = new FormData($("#form-master")[0]);
            form.append('date',date);
            form.append('total_amount',total_amount.replace('$',''));

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

                        data_error(data.errors.supplier,'error1','input1');
                        data_error(data.errors.date,'error2','input2');
                        data_error(data.errors.note,'error7','input7');

                    }

                    if(data.verify=='true'){
//                        $("#form-product")[0].reset();

                        var purchase_id=data.purchase_id;
                        //Add Detail

                        //count rows
                        var rowCount = $('#detail-table >tbody >tr').length;

                        //loop every field in table to get value by index
                        for(var i=1;i<rowCount+1;i++) {

                            //get description type
                            var des_type = 'product';
                            //check if des or product or new product
                            var html_des=$('#detail-table tr').eq(i).find('td').eq(2).find("span").html();

                            /*if (html_des=='<p><i class="des-type-pro qtip tip-top" data-tip="Product"><span class="icon icon-package2"></span></i></p>'){
                                des_type='product';
                            }else{
                                des_type='new_product';
                            }*/

                            //get description
                            var des=$('#detail-table tr').eq(i).find('td').eq(2).find("select").val();
                            //get code part
                            var code_part=$('#detail-table tr').eq(i).find('td').eq(3).find("select").val();
                            //get qty
                            var qty=parseInt($('#detail-table tr').eq(i).find('td').eq(4).find("input").val());
                            //get cost price
                            var cost_price=parseFloat($('#detail-table tr').eq(i).find('td').eq(5).find("input").val());
                            //get sell price
                            var sell_price=parseFloat($('#detail-table tr').eq(i).find('td').eq(8).find("input").val());
                            //get total cost
                            var total_cost=parseFloat(qty*cost_price);
                            //get profit
                            var profit=parseFloat((sell_price-cost_price)*qty);

                            var last='false';
                            if (i==rowCount){
                                last='true';
                            }

                            //Add to database
                            $.ajax({
                                async: false,
                                type: 'post',
                                url: "{{route('purchases.store_detail')}}",
                                data: {
                                    "_token":"<?=csrf_token()?>",
                                    'qty': qty,
                                    'cost_price':cost_price,
                                    'sell_price':sell_price,
                                    'total_cost':total_cost,
                                    'profit':profit,
                                    'purchase_id':purchase_id,
                                    'des':des,
                                    'code_part':code_part,
                                    'des_type':des_type,
                                    'last':last
                                },
                                success: function(data) {
//                                    console.log(data);

                                    //only refresh if the last row
                                    if (data.last=='true'){
                                        //Payment
                                        var amount=$('#amount').val();
                                        if (amount!=''&&amount!=null){
                                            var form = new FormData($("#form-payment")[0]);
                                            form.append('purchase_id',purchase_id);

                                            //Add payment to database
                                            $.ajax({
                                                async: false,
                                                url: "{{route('store_payment.purchase')}}",
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
            var qty=parseInt($('.qty'+$(this).data('id')).val())+1;
            //change value
            $('.qty'+$(this).data('id')).val(qty);

            //get cost price and sell price value
            var cost_price = parseFloat($('.cost_price' + $(this).data('id')).val());
            var sell_price = parseFloat($('.sell_price' + $(this).data('id')).val());

            subtotal(cost_price,qty,$(this).data('id'));
            profit(cost_price,sell_price,qty,$(this).data('id'));
            grand_total();

        });


        //when click on minus qty
        $(document).on('click', '.less', function(e) {
            e.preventDefault();
            //get qty to minus
            var qty=parseInt($('.qty'+$(this).data('id')).val())-1;
            //change value
            $('.qty'+$(this).data('id')).val(qty);


            //get cost price and sell price value
            var cost_price = parseFloat($('.cost_price' + $(this).data('id')).val());
            var sell_price = parseFloat($('.sell_price' + $(this).data('id')).val());

            subtotal(cost_price,qty,$(this).data('id'));
            profit(cost_price,sell_price,qty,$(this).data('id'));
            grand_total();

        });

        //Input Qty
        $(document).on('change', '.input_qty', function(e) {
            e.preventDefault();

            var qty=parseInt($('.qty'+$(this).data('id')).val());

            //get cost price and sell price value
            var cost_price = parseFloat($('.cost_price' + $(this).data('id')).val());
            var sell_price = parseFloat($('.sell_price' + $(this).data('id')).val());

            subtotal(cost_price,qty,$(this).data('id'));
            profit(cost_price,sell_price,qty,$(this).data('id'));
            grand_total();
        });

        //Input Cost Price
        $(document).on('change', '.cost_price', function(e) {
            e.preventDefault();

            //get qty
            var qty=parseInt($('.qty'+$(this).data('id')).val());

            //get cost price and sell price value
            var cost_price = parseFloat($('.cost_price' + $(this).data('id')).val());
            var sell_price = parseFloat($('.sell_price' + $(this).data('id')).val());

            subtotal(cost_price,qty,$(this).data('id'));
            profit(cost_price,sell_price,qty,$(this).data('id'));
            grand_total();
        });

        //Input Sell Price
        $(document).on('change', '.sell_price', function(e) {
            e.preventDefault();

            //get qty
            var qty=parseInt($('.qty'+$(this).data('id')).val());

            //get cost price and sell price value
            var cost_price = parseFloat($('.cost_price' + $(this).data('id')).val());
            var sell_price = parseFloat($('.sell_price' + $(this).data('id')).val());

            subtotal(cost_price,qty,$(this).data('id'));
            profit(cost_price,sell_price,qty,$(this).data('id'));
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
                var cost_price=0;
                var total='$0.00';
                var sell_price=0;
                var profit='$0.00';

                //set field
                /*var des_type="<span id='des-type"+id+"'></span>";
                var des_field="<td> <div class='row'><div class='col-md-2'>"+des_type+"</div>   <div class='col-md-10'><select name='description' class='custom-select select2 inv-des" + id + "'' > <option value=''>Select None</option> </select></div> </div></td>";
*/
                var des_field="<td class='font-btb'> <select name='description' class='custom-select select2 inv-des" + id + "'' > <option value=''>Select None</option> </select> </td>";
                var code_part_field="<td><select name='code_part' class='custom-select select2  inv-code-part" + id + "'' > <option value=''>Select None</option> </select></td>";

                var remove_field="<td><a class='remove' data-id='" + id + "' data-name='" + id + "' href='javascript:void(0)'><i class='icon icon-cancel rm-icon '></i></a> </td>";
                var qty_field="<td class='text-center' width='150px'> <div class='qty-input'><i class='less' data-id='" + id + "' data-name='" + id + "'><i class='icon icon-minus qty-size'></i></i> <input type='text' class='qty"+id+" input_qty' data-id='" + id + "' data-name='" + id + "' value='"+qty+"'/><i class='more' data-id='" +id+ "' data-name='" + id + "'><i class='icon icon-plus qty-size'></i></i> </div> </td> ";
                var cost_price_field="<td class='text-center'><input class='form-control cost_price"+id+" cost_price' data-id='" + id + "' data-name='" + id + "' type='number' placeholder='$0.00' ></td>";
                var subtotal_field="<td class='text-center'><span id='subtotal"+id+"'> " + total+ " </span></td>";
                var sell_price_field="<td><input name='sell_price' type='number' class='form-control sell_price"+id+" sell_price' data-id='" + id + "' data-name='" + id + "' placeholder='$0.00' ></td>";
                var profit_field="<td class='text-center'><span id='profit_price"+id+"'> " + profit+ " </span></td>";

                //display default field
                $('#detail-table').append("<tr class=' pro-remove product" + id + "'> + <!--ID--> <td style='display: none'><input type='hidden' value='"+id+"'></td> <!--Remove button--> "+remove_field+"+ <!-- Product --> "+des_field+" <!-- Code Part--> "+code_part_field+"  <!--Qty--> "+qty_field+"<!--Cost Price--> "+cost_price_field+" "+subtotal_field+" <!--Profit--> "+profit_field+"  <!--Sell Price--> "+sell_price_field+"  </tr>");

                //display default field
//              $('#detail-table').append("<tr class=' pro-remove product" + id + "'> + <!--ID--> <td style='display: none'><input type='hidden' value='"+id+"'></td> <!--Remove button--> <td><a class='remove' data-id='" + id + "' data-name='" + id + "' href='javascript:void(0)'><i class='icon icon-cancel rm-icon '></i></a> </td>+ <!--Description-->  <td> <select name='description' class='custom-select select2 inv-des input2 inv-des" + id + "'' > <option value=''>Select None</option> </select> </td> <!--Qty--> <td class='text-center' width='150px'> <div class='qty-input'><i class='less' data-id='" + id + "' data-name='" + id + "'><i class='icon icon-minus qty-size'></i></i> <input type='text' class='qty"+id+" input_qty' data-id='" + id + "' data-name='" + id + "' value='"+qty+"'/><i class='more' data-id='" +id+ "' data-name='" + id + "'><i class='icon icon-plus qty-size'></i></i> </div> </td> <!--Sell Price--> <td><input name='sell_price' type='number' class='form-control price"+id+" price' data-id='" + id + "' data-name='" + id + "' placeholder='$0.00' ></td>  <!--Total Cost--> <td class='text-center'><span id='total_price"+id+"'> " + total+ " </span></td> </tr>");

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
                    //document.getElementById('des-type'+id).innerHTML = '<p><i class="des-type-no-des qtip tip-top" data-tip="No Description"><span class="icon icon-circle-o"></span></i></p>';

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
                                    //get cost price and sell price when change product

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
//                                                console.log(data);
                                                //add cost price and sell price
                                                $('.cost_price'+id).val(data.cost_price);
                                                $('.sell_price'+id).val(data.sell_price);
                                                var qty=parseInt($('.qty'+id).val());

                                                //update subtotal
                                                subtotal(data.sell_price,qty,id);
                                                grand_total();
                                            });

                                            /*var url_req="{url('get-product/')}}/"+data.pro_id;
                                             $.get(url_req,function (data) {
                                             //                                        console.log(data);
                                             //add cost price and sell price
                                             $('.cost_price'+id).val(data.cost_price);
                                             $('.sell_price'+id).val(data.sell_price);
                                             });*/

                                        }
                                    });

                                    /*document.getElementById('des-type'+id).innerHTML = '<p><i class="des-type-pro qtip tip-top" data-tip="Product"><span class="icon icon-package2"></span></i></p>';

                                     if (data.des=='true'){

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
                                     function(isConfirm){
                                     if (isConfirm) {
                                     //if new product
                                     document.getElementById('des-type'+id).innerHTML = '<p><i class="des-type qtip tip-top" data-tip="New Product"><span class="icon icon-package2"></span></i></p>';
                                     swal_alert('Added','','success');
                                     }else{
                                     //clear select
                                     $('.inv-des'+id).val("").change();
                                     }

                                     });


                                     }else {
                                     //get cost price and sell price when change product
                                     var url_req="{url('get-product/')}}/"+data.pro_id;
                                     $.get(url_req,function (data) {
                                     //                                        console.log(data);
                                     //add cost price and sell price
                                     $('.cost_price'+id).val(data.cost_price);
                                     $('.sell_price'+id).val(data.sell_price);
                                     });
                                     }*/

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
                alert_toast_error('Please add product before add new!')
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
                $('.cost_price'+last_id).val(0);
                $('.sell_price'+last_id).val(0);
                document.getElementById('profit_price'+last_id).innerHTML = '$0.00';
                document.getElementById('subtotal'+last_id).innerHTML = '$0.00';
                $('.inv-des'+last_id).val("").change();
            }else{
                $('.product' + $(this).data('id')).remove();
            }

            grand_total();
        });

        //Subtotal
        function subtotal(cost_price,qty,id) {
            var des = $('.inv-des' + id).val();

            if (des==''||des==null){
                $('.qty'+id).val('0');
                alert_toast_error('Please add product first!');
            }else{
                var subtotal=cost_price*qty;
                if (isNaN(subtotal)){
                    document.getElementById('subtotal'+id).innerHTML = '$0.00';
                }else{
                    document.getElementById('subtotal'+id).innerHTML = "$" + parseFloat(subtotal).format(2);
                }
            }

        }

        //Profit
        function profit(cost_price,sell_price,qty,id) {
            //find total cost
            var total=(sell_price-cost_price)*qty;

            //if no value
            if (isNaN(total)){
                document.getElementById('profit_price'+id).innerHTML = '$0.00';
            }else{
                document.getElementById('profit_price'+id).innerHTML = "$" + parseFloat(total).format(2);
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
                var qty=parseInt($('#detail-table tr').eq(i).find('td').eq(4).find("input").val());
                //get cost price
                var cost_price=parseFloat($('#detail-table tr').eq(i).find('td').eq(5).find("input").val());

                var total=parseFloat(qty*cost_price);
                if (isNaN(total)){
                    total=0;
                }

                grand_total+=total;
            }

            //display grand total
            //if cost price no value
            if (isNaN(grand_total)){
                document.getElementById('grand-total').innerHTML = '$0.00';
            }else{
                document.getElementById('grand-total').innerHTML = "$" + parseFloat(grand_total).format(2);
            }

            //Add total to payment
            $('#amount').val(parseFloat(grand_total).format(2));

        }

        float_only(['amount']);
    </script>
@endsection


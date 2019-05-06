@extends('master')
@section('content')
    <div class="page has-sidebar-left">

        {{--Add Master--}}
        <div class="container-fluid animatedParent animateOnce my-3">

            <div class="animated fadeInUpShort shadow">
                <form id="form-master">
                    {{csrf_field()}}
                    <input type="hidden" name="update_id" value="{{$master->id}}">

                    <div class="row"> 
                        <div class="col-md-12">
                            <div class="card no-b">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <div class="form-group ">

                                                <label for="pro_name">Product Name <span class="required">*</span></label>

                                                <select name="product_name" class="custom-select select2 tags input1" id="pro" >
                                                    <option value="">Select None</option>
                                                    @foreach($pros as $p)
                                                        @if($master->name==$p->name)
                                                            <option selected value="{{$p->name}}">{{$p->name}}</option>
                                                        @else
                                                            <option value="{{$p->name}}">{{$p->name}}</option>
                                                        @endif

                                                    @endforeach
                                                </select>
                                                {{--<input name="product_name" type="text" class="form-control input1" id="pro_name" placeholder="Product Name" value="{{$master->name}}">--}}

                                                <span class="text-danger">
                                                    <strong id="error1"></strong>
                                                </span>


                                            </div>

                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <div class="form-group">
                                                <label for="validationCustom04">Code Part <span class="required">*</span></label>
                                                <input type="text" name="code_part" id ="code_part" class="form-control input3" placeholder="Code Part" value="{{$master->code_part}}">
                                                <span class="text-danger">
                                                    <strong id="error3"></strong>
                                                </span>

                                            </div>

                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <div class="form-group">
                                                <label for="validationCustom04">Type</label>
                                                <select class="custom-select select2 no-search input5" name="type">
                                                    <option value="">Select None</option>
                                                    @if($master->type=='unit')
                                                        <option selected value="unit">Unit</option>
                                                    @else
                                                        <option value="unit">Unit</option>
                                                    @endif

                                                    @if($master->type=='liter')
                                                        <option selected value="liter">Liter</option>
                                                    @else
                                                        <option value="liter">Liter</option>
                                                    @endif

                                                    @if($master->type=='can')
                                                        <option selected value="can">Can</option>
                                                    @else
                                                        <option value="can">Can</option>
                                                    @endif


                                                </select>
                                                <span class="text-danger">
                                                    <strong id="error5"></strong>
                                                </span>

                                            </div>

                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <div class="form-group">
                                                <label for="validationCustom04">Model</label>
                                                <select class="custom-select select2 tags input4" name="model" >
                                                    <option value="">Select None</option>
                                                    @foreach($model as $m)
                                                        @if($m->id==$master->model_id)
                                                            <option selected value="{{$m->id}}">{{$m->name}}</option>
                                                        @else
                                                            <option value="{{$m->id}}">{{$m->name}}</option>
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
                                                <label for="category">Use for</label>
                                                <select id="cat" name="category" class="custom-select select2 tags input2" >
                                                    <option value="">Select None</option>
                                                    @foreach($use_for as $u)
                                                        @if($u->id==$master->cat_id)
                                                            <option selected value="{{$u->id}}">{{$u->name}}</option>
                                                        @else
                                                            <option value="{{$u->id}}">{{$u->name}}</option>
                                                        @endif
                                                    @endforeach
                                                </select>

                                                <span class="text-danger">
                                                    <strong id="error2"></strong>
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
                                            <div class="card-body slimScroll" data-height="300">
                                                <h5>Add or edit opening stock</h5>
                                                <br>

                                                <div class="table-responsive">
                                                    <table id="detail-table" class="table table-striped table-bordered" cellspacing="0" width="100%" data-options='{"searching":true}'>
                                                        <thead>
                                                        <tr class="" style="border-bottom: none !important;">
                                                            <th style="display: none"></th>
                                                            <th><a href='javascript:void(0)'><i id="add-new" class='icon icon-add add-icon'></i></a></th>
                                                            <th class="text-center" width="15%">Qty</th>
                                                            <th class="text-center" width="30%">Cost Price</th>
                                                            <th class="text-center" width="15%">Subtotal</th>
                                                            <th class="text-center" width="15%">Profit</th>
                                                            <th class="text-center" width="30%">Sell Price</th>
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


                                <hr>

                                <div style="text-align: right">
                                    <button type="button" class="btn btn-default btn-lg btn-close" style="margin: 0px 8px 15px 0px;" onclick="window.location.href='{{url(config('global.index_link'))}}'">Close</button>
                                    <button type="submit" class="btn btn-primary btn-lg" style="margin: 0px 13px 15px 0px;" id="btn-save" ><i class="icon-save mr-2"></i>Save</button>
                                </div>
                            </div>
                        </div>

                    </div>

            </div>
        </div>


    </div>

    <input type="hidden" id="delete" value="false">
    <input type="hidden" id="master_id" value="{{$master->id}}">
@endsection

@section('data')
    <script type="text/javascript">

        //on load
        $(document).ready(function() {

            //display detail data
            var url_req="{{url('product_detail/update')}}/"+$('#master_id').val();
            $.get(url_req,function (data) {
                if(data.detail.length==0){
                    //set value default to field
                    var id=0;
                    var qty=0;
                    var cost_price=0;
                    var subtotal='$0.00';
                    var sell_price=0;
                    var profit='$0.00';

                    var remove_field="<td><a class='remove' data-id='" + id + "' data-name='" + id + "' href='javascript:void(0)'><i class='icon icon-cancel rm-icon '></i></a> </td>";
                    var qty_field="<td class='text-center' width='150px'> <div class='qty-input'><i class='less' data-id='" + id + "' data-name='" + id + "'><i class='icon icon-minus qty-size'></i></i> <input type='text' class='qty"+id+" input_qty' data-id='" + id + "' data-name='" + id + "' value='"+qty+"'/><i class='more' data-id='" +id+ "' data-name='" + id + "'><i class='icon icon-plus qty-size'></i></i> </div> </td> ";
                    var cost_price_field="<td class='text-center'><input class='form-control cost_price"+id+" cost_price' data-id='" + id + "' data-name='" + id + "' type='number' placeholder='$0.00' ></td>";
                    var subtotal_field="<td class='text-center'><span id='subtotal"+id+"'> " + subtotal+ " </span></td>";
                    var sell_price_field="<td><input name='sell_price' type='number' class='form-control sell_price"+id+" sell_price' data-id='" + id + "' data-name='" + id + "' placeholder='$0.00' ></td>";
                    var profit_field="<td class='text-center'><span id='profit_price"+id+"'> " + profit+ " </span></td>";

                    //display default field
                    $('#detail-table').append("<tr class=' pro-remove product" + id + "'> + <!--ID--> <td style='display: none'><input type='hidden' value='"+id+"'></td> <!--Remove button--> "+remove_field+"+ <!--Qty--> "+qty_field+"<!--Cost Price--> "+cost_price_field+" "+subtotal_field+" <!--Profit--> "+profit_field+"  <!--Sell Price--> "+sell_price_field+"  </tr>");

                }else{
                    for (var i=0;i<data.detail.length;i++){
                        //set value default to field
                        var id=data.detail[i].id;
                        var qty=data.detail[i].qty;
                        var cost_price=data.detail[i].cost_price;
                        var subtotal=parseFloat(data.detail[i].total_cost).format(2);;
                        var sell_price=data.detail[i].sell_price;
                        var profit=parseFloat(data.detail[i].profit).format(2);

                        //change NaN to 0
                        if (isNaN(profit)||profit==null){
                            profit='$0.00';
                        }

                        var remove_field="<td><a class='remove' data-id='" + id + "' data-name='" + id + "' href='javascript:void(0)'><i class='icon icon-cancel rm-icon '></i></a> </td>";
                        var qty_field="<td class='text-center' > <div class='qty-input' style='padding-left: 30%'> <input disabled type='text' class='qty"+id+" input_qty' data-id='" + id + "' data-name='" + id + "' value='"+qty+"'/> </div> </td> ";
                        var cost_price_field="<td class='text-center'><input class='form-control cost_price"+id+" cost_price' data-id='" + id + "' data-name='" + id + "' type='number' placeholder='$0.00' value='"+cost_price+"'></td>";
                        var subtotal_field="<td class='text-center'><span id='subtotal"+id+"'> $" + subtotal+ " </span></td>";
                        var sell_price_field="<td><input name='sell_price' type='number' class='form-control sell_price"+id+" sell_price' data-id='" + id + "' data-name='" + id + "' placeholder='$0.00' value='"+sell_price+"'></td>";
                        var profit_field="<td class='text-center'><span id='profit_price"+id+"'> $" + profit+ " </span></td>";

                        //display default field
                        $('#detail-table').append("<tr class=' pro-remove product" + id + "'> + <!--ID--> <td style='display: none'><input type='hidden' value='"+id+"'></td> <!--Remove button--> "+remove_field+"+ <!--Qty--> "+qty_field+"<!--Cost Price--> "+cost_price_field+" "+subtotal_field+" <!--Profit--> "+profit_field+"  <!--Sell Price--> "+sell_price_field+"  </tr>");

                    }
                }


                //change null to 0
                var grand_total=data.grand_total;
                if (isNaN(grand_total)||grand_total==null){
                    grand_total=0;
                }
                //display grand total
                document.getElementById('grand-total').innerHTML = "$" + parseFloat(grand_total).format(2);


                //console.log(data);
            });


            //add active on nav bar
            $('.no-active4').removeClass('no-active4').addClass('active');

        });


        //  Products_name_validate //

        $("#code_part").on("input", function(e) {
            var code_part=$('#code_part').val();
            clear_border(['input3']);     //Chart on load
            clear_error(['error3']);
            $.ajax({
                /* location to go*/
                url: "{{route('product.code_part_validate')}}",
                method: "POST",
                dataType: 'json',
                data: {
                    "_token":"<?=csrf_token()?>",
                    'code_part':code_part,
                },
                success: function(data){
                    /* When controller is complete it send back value to data*/
                    //   console.log(data);

                    if ((data.errors)) {
                        data_error(data.errors.code_part, 'error3', 'input3');
                    }
                },
                error: function(er){}
            });
        });

        // On change Products
        $('#pro').on('change', function() {
            on_change_input('pro','input1','error1','The product name field is required.');
        });

        //Master
        $("#btn-save").click(function (e) {
            e.preventDefault();

            clear_border(['input1','input3']);
            clear_error(['error1','error3']);

            var form = new FormData($("#form-master")[0]);
            form.append('delete',$('#delete').val());
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

                        data_error(data.errors.product_name,'error1','input1');
                        data_error(data.errors.code_part,'error3','input3');

                    }

                    if(data.verify=='true'){
//                        $("#form-product")[0].reset();

                        //count rows
                        var rowCount = $('#detail-table >tbody >tr').length;
//                        var grand_total=0;

                        //loop every field in table to get value by index
                        for(var i=1;i<rowCount+1;i++) {

                            //get id
                            var id=parseInt($('#detail-table tr').eq(i).find('td').eq(0).find("input").val());
                            //get qty
                            var qty=parseInt($('#detail-table tr').eq(i).find('td').eq(2).find("input").val());
                            //get cost price
                            var cost_price=parseFloat($('#detail-table tr').eq(i).find('td').eq(3).find("input").val());
                            //get sell price
                            var sell_price=parseFloat($('#detail-table tr').eq(i).find('td').eq(6).find("input").val());
                            //get total cost
                            var total_cost=parseFloat(qty*cost_price);
                            //get profit
                            var profit=parseFloat((sell_price-cost_price)*qty);
                            //get delete
                            var del=$('#delete').val();

                            //check if the last row
                            var last='false';
                            if (i==rowCount){
                                last='true';
                            }

                            //Add to database
                            $.ajax({
                                async: false,
                                type: 'post',
                                url: "{{route(config('global.submit_detail_link'))}}",
                                data: {
                                    "_token":"<?=csrf_token()?>",
                                    'qty': qty,
                                    'cost_price':cost_price,
                                    'sell_price':sell_price,
                                    'total_cost':total_cost,
                                    'profit':profit,
                                    'pro_id':data.pro_id,
                                    'id':id,
                                    'delete':del,
                                    'last':last
                                },
                                success: function(data) {
//                                    console.log(data);

                                    //only refresh if the last row
                                    if (data.last=='true'){
                                        window.location.href='{{url(config('global.index_link'))}}';
                                    }


                                }
                            });

//                            grand_total+=qty*cost_price;
                        }


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

//        When click on add new button
        $('#add-new').click(function () {
            //count table row
            var row_count = $('#detail-table >tbody >tr').length;
            //alert(rowCount);

            //get old id
            var old_id=parseInt($('#detail-table tr').eq(row_count).find('td').eq(0).find("input").val());
            //get cost_price old value
            var old_cost_price=parseFloat($('#detail-table tr').eq(row_count).find('td').eq(3).find("input").val());
            //get sell price old value
            var old_sell_price=parseFloat($('#detail-table tr').eq(row_count).find('td').eq(6).find("input").val());

            //set id to last and add 1
            var id=old_id+1;

//            alert(old_id);

            var qty=0;
            var subtotal='0.00';
            var profit='0.00';

            //set new cost_price to old
            var cost_price=old_cost_price;

            //set new sell price to old
            var sell_price=old_sell_price;



            var remove_field="<td><a class='remove' data-id='" + id + "' data-name='" + id + "' href='javascript:void(0)'><i class='icon icon-cancel rm-icon '></i></a> </td>";
            var qty_field="<td class='text-center' width='150px'> <div class='qty-input'><i class='less' data-id='" + id + "' data-name='" + id + "'><i class='icon icon-minus qty-size'></i></i> <input type='text' class='qty"+id+" input_qty' data-id='" + id + "' data-name='" + id + "' value='"+qty+"'/><i class='more' data-id='" +id+ "' data-name='" + id + "'><i class='icon icon-plus qty-size'></i></i> </div> </td> ";
            var cost_price_field="<td class='text-center'><input class='form-control cost_price"+id+" cost_price' data-id='" + id + "' data-name='" + id + "' type='number' placeholder='$0.00' value='"+cost_price+"'></td>";
            var subtotal_field="<td class='text-center'><span id='subtotal"+id+"'> $" + subtotal+ " </span></td>";
            var sell_price_field="<td><input name='sell_price' type='number' class='form-control sell_price"+id+" sell_price' data-id='" + id + "' data-name='" + id + "' placeholder='$0.00' value='"+sell_price+"'></td>";
            var profit_field="<td class='text-center'><span id='profit_price"+id+"'> $" + profit+ " </span></td>";

            //display default field
            $('#detail-table').append("<tr class=' pro-remove product" + id + "'> + <!--ID--> <td style='display: none'><input type='hidden' value='"+id+"'></td> <!--Remove button--> "+remove_field+"+ <!--Qty--> "+qty_field+"<!--Cost Price--> "+cost_price_field+" "+subtotal_field+" <!--Profit--> "+profit_field+"  <!--Sell Price--> "+sell_price_field+"  </tr>");

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
                document.getElementById('subtotal'+last_id).innerHTML = '$0.00';
                document.getElementById('profit_price'+last_id).innerHTML = '$0.00';
            }else{
                $('.product' + $(this).data('id')).remove();
            }

            grand_total();
            $('#delete').val('true');
        });

        //Subtotal
        function subtotal(cost_price,qty,id) {
            var subtotal=cost_price*qty;
            if (isNaN(subtotal)){
                document.getElementById('subtotal'+id).innerHTML = '$0.00';
            }else{
                document.getElementById('subtotal'+id).innerHTML = "$" + parseFloat(subtotal).format(2);
            }
        }

        //Profit
        function profit(cost_price,sell_price,qty,id) {
            //find total cost
            var total=(sell_price-cost_price)*qty;

            //display total cost
            //if cost price no value
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
                var qty=parseInt($('#detail-table tr').eq(i).find('td').eq(2).find("input").val());
                //get cost price
                var cost_price=parseFloat($('#detail-table tr').eq(i).find('td').eq(3).find("input").val());

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

        }

    </script>
@endsection


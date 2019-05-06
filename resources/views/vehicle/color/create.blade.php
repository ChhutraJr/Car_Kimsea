@extends('master')
@section('content')
    <div class="page has-sidebar-left  height-full">

        <div class="container-fluid animatedParent animateOnce">
            <div class="animated fadeInUpShort ">
                <div class="row my-3">
                    <div class="col-md-7  offset-md-2">
                        <form id="form-master">
                            {{csrf_field()}}
                            <div class="card no-b  no-r shadow">
                                <div class="card-body">
                                    <div class="form-row">
                                        <div class="col-md-12">
                                            <div class="form-group m-0">
                                                <label for="name" class="col-form-label s-12">Vehicle Color <span class="required">*</span></label>
                                                    <input name="name"  id="color" placeholder="Enter Color Name" class="form-control-lg r-0 light s-12 input1" type="text">
                                            </div>
                                            <span class="text-danger">
                                                    <strong id="error1"></strong>
                                                </span>

                                            <div class="form-group m-0 mt-3">
                                                <button type="submit" class="btn btn-primary btn-lg"><i class="icon-save mr-2"></i>Save</button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('data')
    <script type="text/javascript">

        $(document).ready(function() {
            //add active on nav bar
            $('.no-active2').removeClass('no-active2').addClass('active');
            $('.no-active2-5').removeClass('no-active2-5').addClass('active');
        });

        //  cus_Color_validate //
        $("#color").on("input", function(e) {
            var name=$('#color').val();
            clear_border(['input1']);
            clear_error(['error1']);
            $.ajax({
                /* location to go*/
                url: "{{route('vehicle_color.validate')}}",
                method: "POST",
                dataType: 'json',
                data: {
                    'name':name,
                    '_token': "{{ csrf_token()}}"
                },
                success: function(data){
                    /* When controller is complete it send back value to data*/
//                    console.log(data);

                    if ((data.errors)) {
                        data_error(data.errors.name, 'error1', 'input1');
                    }
                },
                error: function(er){}
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
//                    console.log(data);


                    if ((data.errors)) {

                        data_error(data.errors.name,'error1','input1');

                    }

                    if(data.verify=='true'){
                        window.location.href='{{url(config('global.index_link'))}}';
                    }
                },
                error: function(er){}
            });
        })
    </script>
@endsection


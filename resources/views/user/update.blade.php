@extends('master')
@section('content')
    <div class="page has-sidebar-left">

        <div class="container-fluid animatedParent animateOnce my-3">
            <div class="animated fadeInUpShort shadow">
                <form id="form-user">
                    {{csrf_field()}}

                    <input type="hidden" name="update_id" value="{{$master->id}}">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card no-b">
                                <div class="card-body">
                                    <div class="row">

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="pro_cat">Role <span class="required">*</span></label>
                                                <!--<input type="text" class="form-control"  placeholder="Mobile Phones" required>-->

                                                <select name="role"  class="custom-select select2 form-control input-role">
                                                    <option value="">Select User Role</option>
                                                    @foreach($roles as $r)
                                                        @if($master->role_id==$r->id)
                                                            <option selected value="{{$r->id}}">{{$r->name}}</option>
                                                        @else
                                                            <option value="{{$r->id}}">{{$r->name}}</option>
                                                        @endif
                                                    @endforeach
                                                </select>

                                                <span class="text-danger">
                                                <strong id="role-error"></strong>
                                            </span>

                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label >First Name <span class="required">*</span></label>

                                                <input name="first_name" type="text" class="form-control input-first-name" id="first-name" placeholder="First Name" value="{{$master->first_name}}">

                                                <span class="text-danger">
                                                            <strong id="first-name-error"></strong>
                                                        </span>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label >Last Name</label>

                                                <input name="last_name" type="text" class="form-control input-last-name" id="last-name" placeholder="Last Name" value="{{$master->last_name}}" >

                                                <span class="text-danger">
                                                            <strong id="last-name-error"></strong>
                                                        </span>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="pro_name">Username <span class="required">*</span></label>

                                                <input name="username" type="text" class="form-control input-username" placeholder="Username" value="{{$master->username}}">
                                                <span class="text-danger">
                                                    <strong id="username-error"></strong>
                                                </span>
                                            </div>

                                        </div>


                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label >Password</label>
                                                <input name="password" type="password" class="form-control input-pass" placeholder="Password">
                                                <span class="text-danger">
                                                <strong id="pass-error"></strong>
                                            </span>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Confirm Password</label>
                                                <input name="confirm_password" type="password" class="form-control input-confirm-pass" placeholder="Confirm Password">
                                                <span class="text-danger">
                                                <strong id="confirm-pass-error"></strong>
                                            </span>
                                            </div>

                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="pro_cost_unit">Image</label>
                                                <div class="row">
                                                    <div class="col-10">
                                                        <div class="input-group image-preview">
                                                            <input type="text" class="form-control image-preview-filename" disabled="disabled"> <!-- don't give a name === doesn't send on POST/GET -->
                                                            <span class="input-group-btn">
                                                        <!-- image-preview-clear button -->
                                                        <button type="button" class="btn btn-default image-preview-clear" style="display:none;font-size: 17px">
                                                            <span class="glyphicon glyphicon-remove"></span> Clear
                                                        </button>
                                                                <!-- image-preview-input -->
                                                        <div class="btn btn-default image-preview-input">
                                                            <span class="glyphicon glyphicon-folder-open"></span>
                                                            <span class="image-preview-input-title" style="font-size: 17px;">Browse</span>
                                                            <input type="file" accept="image/png, image/jpeg, image/gif" name="image"/> <!-- rename it -->
                                                        </div>
                                                        </span>
                                                        </div><!-- /input-group image-preview [TO HERE]-->
                                                    </div>

                                                    <div class="col-2">
                                                        <div class="text-center">
                                                            <figure class="avatar">
                                                                <img src="{{url('/storage/'.$master->image)}}" alt="">
                                                            </figure>
                                                        </div>
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


                </form>
            </div>
        </div>
    </div>

@endsection

@section('data')
    <script type="text/javascript">

        $("#form-user").submit(function (e) {
            e.preventDefault();
            var form = new FormData($("#form-user")[0]);

            clear_border(['input-username',
                'input-first-name',
                'input-last-name',
                'input-role',
                'input-current-pass',
                'input-new-pass',
                'input-pass',
                'input-confirm-pass']);
            clear_error(['username-error',
                'first-name-error',
                'last-name-error',
                'role-error',
                'current-pass-error',
                'new-pass-error',
                'pass-error',
                'confirm-pass-error']);

            $.ajax({
                /* location to go*/
                url: "{{route('save_update.user')}}",
                method: "POST",
                dataType: 'json',
                data: form,
                processData: false,
                contentType: false,
                success: function (data) {

                    /* When controller is complete it send back value to data*/
//                    console.log(data);

                    if ((data.errors)) {

                        if (data.errors.username) {
                            errors('#username-error', data.errors.username[0], '.input-username');
                        }

                        if (data.errors.first_name) {
                            errors('#first-name-error', data.errors.first_name[0], '.input-first-name');
                        }

                        if (data.errors.last_name) {
                            errors('#last-name-error', data.errors.last_name[0], '.input-last-name');
                        }

                        if (data.errors.role) {
                            errors('#role-error', data.errors.role[0], '.input-role');
                        }

                        if (data.errors.current_password) {
                            errors('#current-pass-error', data.errors.current_password[0], '.input-current-pass');
                        }

                        if (data.errors.new_password) {
                            errors('#new-pass-error', data.errors.new_password[0], '.input-new-pass');
                        }

                        if (data.errors.password) {
                            errors('#pass-error', data.errors.password[0], '.input-pass');
                        }

                        if (data.errors.confirm_password) {
                            errors('#confirm-pass-error', data.errors.confirm_password[0], '.input-confirm-pass');
                        }

                    }
                    if (data.verify == 'true') {
//                        $("#form-product")[0].reset();
                        window.location.href='{{url(config('global.index_link'))}}';
                    }

                },
                error: function (er) {
                }
            });
        })
    </script>
@endsection


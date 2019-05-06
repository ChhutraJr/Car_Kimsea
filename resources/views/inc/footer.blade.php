

<!-- Add the sidebar's background. This div must be placed
         immediately after the control sidebar -->
<div class="control-sidebar-bg shadow white fixed"></div>
</div>
{{--</div>--}}
<!--/#app -->

<script src="{{url('/js/jquery/jquery-2.2.1.js')}}"></script>
{{--<script src="{{url('js/jquery3/jquery-3.1.0.min.js')}}"></script>--}}

<script src="{{url('plugins/toastr/toastr.min.js')}}"></script>

<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/paper.js') }}"></script>
{{--<script src="{{url('/js/paper.js')}}"></script>--}}
<script src="{{url('/js/print/jquery.printPage.js')}}"></script>
<script src="{{url('/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js')}}"></script>
<script src="{{url('/plugins/daterangepicker-master/moment.min.js')}}"></script>
<script src="{{url('/plugins/daterangepicker-master/daterangepicker.js')}}"></script>
<script src="{{url('plugins/sweetalert2/sweetalert.min.js')}}"></script>
<script src="{{url('/plugins/modal-master/jquery.modal.js')}}"></script>
<script src="{{url('/plugins/tagsinput/jquery.tagsinput.min.js')}}"></script>
<script src="{{url('/plugins/phone-format/phone.js')}}"></script>
<script src="{{url('/js/custom.js')}}"></script>

@yield('data')

<script type="text/javascript">

    //Alert Message
    @if(Session::has('message'))
    var type = "{{ Session::get('alert-type', 'info') }}";
    switch(type){
        case 'info':
            toastr["info"]("{{Session::get('message')}}", "{{Session::get('title')}}");
            break;

        case 'warning':
            toastr["warning"]("{{Session::get('message')}}", "{{Session::get('title')}}");
            break;

        case 'success':
            toastr["success"]("{{Session::get('message')}}", "{{Session::get('title')}}");
            break;

        case 'error':
            toastr["error"]("{{Session::get('message')}}", "{{Session::get('title')}}");
            break;
    }
    @endif

</script>


</body>
</html>
<style>

    ul li a.toggle {
        width: 100%;
        display: block;
        /*background: rgba(0, 0, 0, 0.78);*/
        color: #6583b5;
        padding: .75em;
        border-radius: 0.15em;
        transition: background .3s ease;
    }


    .form-control:focus{
        border: 1px solid #e1e8ee;
        -webkit-box-shadow: inset 0 1px 1px rgba(92, 119, 164, 0.07), 0 0 6px  #ebeef0;
        box-shadow: inset 0 1px 1px rgba(92, 119, 164, 0.07), 0 0 6px  #ebeef0;
    }

    .blue.accent-3{
        background-color: #6583b5!important;
        max-height: 50px;
    }

    .form-control-lg:focus{
        -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 6px #ebeef0;
        box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 6px #ebeef0;
    }

    .form-control-lg, .input-group-lg>.form-control, .input-group-lg>.input-group-addon, .input-group-lg>.input-group-append>.btn, .input-group-lg>.input-group-append>.input-group-text, .input-group-lg>.input-group-prepend>.btn, .input-group-lg>.input-group-prepend>.input-group-text{
        border: 1px solid #e1e8ee;
    }

    /*Show shadow on search datatable*/
    div.dataTables_wrapper div.dataTables_filter input:focus{
        -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 6px #ebeef0;
        box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 6px #ebeef0;
    }

    /*Show shadow on show entries datatable*/
    div.dataTables_wrapper div.dataTables_length select:focus{
        -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 6px #ebeef0;
        box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 6px #ebeef0;
    }

    .select2-container--default .select2-selection--single:focus{
        outline: none;
        -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 6px #ebeef0;
        box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 6px #ebeef0;
        border: 1px solid #e1e8ee;
    }


    .select2-container--default.select2-container--open.select2-container--above .select2-selection--multiple, .select2-container--default.select2-container--open.select2-container--above .select2-selection--single{
        -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 6px #ebeef0;
        box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 6px #ebeef0;
    }

    .select2-container--default .select2-results__option[aria-selected=true]{
        background-color: #f5f8fa;
        color: #6583b5;
        border-radius: 4px;
        margin: 4px;
    }

    .select2-container--default .select2-results__option[aria-selected=true]{
        background-color: #f5f8fa;
        color: #6583b5;
        border-radius: 4px;
        margin: 4px;
    }

    .select2-container--default.select2-container--open.select2-container--below .select2-selection--multiple, .select2-container--default.select2-container--open.select2-container--below .select2-selection--single{
        -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 6px #ebeef0;
        box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 6px #ebeef0;
    }


    .select2-container--default .select2-results__option[aria-selected=true]:hover{
        color: #6583b5;
    }

    .select2-container--default .select2-results__option--highlighted[aria-selected]:hover{
        color: #6583b5;
    }

    .dropdown-action >li>a:hover{
        color: #6583b5;
    }

    .btn-primary{
        background: #6583b5;
        border-color:#6583b5;
    }

    .btn-primary:focus{
        background: #6583b5;
        border-color:#6583b5;
    }

    .btn-primary:not(:disabled):not(.disabled).active:focus, .btn-primary:not(:disabled):not(.disabled):active:focus, .show>.btn-primary.dropdown-toggle:focus{

        -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 6px #ebeef0;
        box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 6px #ebeef0;
    }

    .btn-primary:focus, .btn-primary:hover{
        background: #6583b5;
        border-color:#6583b5;
    }

    .btn-primary:not(:disabled):not(.disabled).active, .btn-primary:not(:disabled):not(.disabled):active, .show>.btn-primary.dropdown-toggle{
        background: #6583b5;
        border-color:#6583b5;
    }

    .btn-default:hover{
        background: #6583b5;
        border-color:#6583b5;
    }

    .btn-default:focus{
        background: #6583b5;
        border-color:#6583b5;
    }

    .page-item.active .page-link{
        background: #6583b5;
        border-color:#6583b5;
    }

    .select2-container--default .select2-selection--multiple{
        border: 1px solid #e1e8ee;
        box-shadow: none;
        border-radius: 4px;
    }

    .select2-container--default.select2-container--focus .select2-selection--multiple{
        border: 1px solid #e1e8ee;
        -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 6px #ebeef0;
        box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 6px #ebeef0;
    }


    .select2-container--default.select2-container--focus .select2-selection--multiple{
        border: 1px solid #e1e8ee !important;
    }

    .select2-container .select2-search--inline .select2-search__field{
        margin-top: 3px;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice{
        border: 1px solid #e1e8ee;
    }

    div.tagsinput input{
        padding: 0px;
        width: 100%;
        font-family: 'Roboto', sans-serif !important;
        font-size: 17px;
        font-weight: 300;
        margin: 0 0px 0px 0;
        color: rgb(109, 118, 125) !important;
    }

    div.tagsinput{
        border-radius: 4px;
        border: 1px solid #e1e8ee !important;

    }

    div.tagsinput span.tag{
        font-family: 'Roboto', sans-serif !important;
        font-size: 17px;
        font-weight: 300;
        padding: 0px;
        background: #ffffff;
        color: rgb(109, 118, 125);
        margin-right: 5px;
        margin-bottom: 0px;

        border: 1px solid #e1e8ee;
        -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 6px #ebeef0;
        box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 6px #ebeef0;

        padding-left: 5px;
        padding-right: 5px;
        border-radius: 4px;
    }


    div.tagsinput span.tag a{
        color: #6583b5;
        margin-bottom: 2px !important;
    }

    div.tagsinput span.tag:focus{
        border: 1px solid #e1e8ee;
        -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 6px #ebeef0;
        box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 6px #ebeef0;
    }

    .border-shadow{
        border: 1px solid #e1e8ee;
        -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 6px #ebeef0;
        box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 6px #ebeef0;
    }

    a {
        color: #7c8994;

    }

    a:hover{
        color: #656f78;
    }

    .breadcrumb{
        padding: 0.75rem 0rem;
        margin-bottom: 0rem;
        background-color: transparent;
    }

    .navbar li a{
        color: #ffffff;
    }

    .breadcrumb-item+.breadcrumb-item::before{
        color: #ffffff;
    }

    .navbar li a:focus, .navbar li a:hover{
        color: #ffffff;
    }

    .breadcrumb-item.active{
        color: #f0f0f0;
    }

    .mg-t-29{
        margin-top: 29px;
    }

    .nav-r-cl{
        color: #86939e;
    }
    .nav-r-cl:hover{
        color: #76818b;
    }

    .act-icon{
        font-size: 8px;
    }

    .card{
        border-radius: 0px;
    }

    .fw-500{
        font-weight: 500;
    }

    .text-danger{
        color: #e6808a!important;
    }
</style>
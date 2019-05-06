//Counter
/*$('.qty-input i').click(function() {
    val = parseInt($('.qty-input input').val());

    if ($(this).hasClass('less')) {
        val = val - 1;
    } else if ($(this).hasClass('more')) {
        val = val + 1;
    }

    if (val < 1) {
        val = 1;
    }

    $('.qty-input input').val(val);
});*/


//on the same page when refresh
if (location.hash) {
    $('a[href=\'' + location.hash + '\']').tab('show');
}
var activeTab = localStorage.getItem('activeTab');
if (activeTab) {
    $('a[href="' + activeTab + '"]').tab('show');
}

$('body').on('click', 'a[data-toggle=\'tab\']', function (e) {
    e.preventDefault()
    var tab_name = this.getAttribute('href')
    if (history.pushState) {
        history.pushState(null, null, tab_name)
    }
    else {
        location.hash = tab_name
    }
    localStorage.setItem('activeTab', tab_name)

    $(this).tab('show');
    return false;
});


$(window).on('popstate', function () {
    var anchor = location.hash ||
        $('a[data-toggle=\'tab\']').first().attr('href');
    $('a[href=\'' + anchor + '\']').tab('show');
});

//close on the same page refresh

function clear_val(params) {
    for (var i=0;i<params.length;i++){
        $('#'+params[i]+'').val('');
    }

}

//Convert string to capital letter
function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}


//Validation

//Clear validate text
function has_errors(input_name,label_error) {
    $(input_name).parent().removeClass('has-error');
    $(label_error).html( "" );
}

//Add validate text
function errors(label_error,error_text,input_name) {
    $(input_name).parent().addClass('has-error');
    $(label_error).html(error_text);

}

//Clear date
function clear_date(params) {
    for (var i=0;i<params.length;i++){
        var $dates = $('#'+params[i]+'').datepicker();
        $dates.datepicker('setDate', null);
    }
}


//Change image when input file
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#pic')
                .attr('src', e.target.result)
                .width(67)
                .height(67)
        };

        reader.readAsDataURL(input.files[0]);
    }
}

//Notification
toastr.options = {
    "closeButton": true,
    "debug": false,
    "newestOnTop": true,
    "progressBar": false,
    "positionClass": "toast-top-right",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "6000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
};

//format two digits
function twoDigit(number) {
    var twodigit = number >= 10 ? number : "0"+number.toString();
    return twodigit;
}


//price format
Number.prototype.format = function(n, x) {
    var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\.' : '$') + ')';
    return this.toFixed(Math.max(0, ~~n)).replace(new RegExp(re, 'g'), '$&,');
};

//Popover Preview Image
$(document).on('click', '#close-preview', function(){
    $('.image-preview').popover('hide');
    // Hover befor close the preview
    $('.image-preview').hover(
        function () {
            $('.image-preview').popover('show');
        },
        function () {
            $('.image-preview').popover('hide');
        }
    );
});

$(function() {
    // Create the close button
    var closebtn = $('<button/>', {
        type:"button",
        text: 'x',
        id: 'close-preview',
        style: 'font-size: initial;',
    });
    closebtn.attr("class","close pull-right");
    // Set the popover default content
    $('.image-preview').popover({
        trigger:'manual',
        html:true,
        title: "<strong>Preview</strong>"+$(closebtn)[0].outerHTML,
        content: "There's no image",
        placement:'bottom'
    });
    // Clear event
    $('.image-preview-clear').click(function(){
        $('.image-preview').attr("data-content","").popover('hide');
        $('.image-preview-filename').val("");
        $('.image-preview-clear').hide();
        $('.image-preview-input input:file').val("");
        $(".image-preview-input-title").text("Browse");
    });
    // Create the preview image
    $(".image-preview-input input:file").change(function (){
        var img = $('<img/>', {
            id: 'dynamic',
            width:250,
            height:200
        });
        var file = this.files[0];
        var reader = new FileReader();
        // Set preview image into the popover data-content
        reader.onload = function (e) {
            $(".image-preview-input-title").text("Change");
            $(".image-preview-clear").show();
            $(".image-preview-filename").val(file.name);
            img.attr('src', e.target.result);
            $(".image-preview").attr("data-content",$(img)[0].outerHTML).popover("show");
        }
        reader.readAsDataURL(file);
    });
});

//input only numbers
function num_only(params) {
    for (var i=0;i<params.length;i++){
        $('input'+'#'+params[i]+'').on('input', function() {

            this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');
        });
    }
}

//input only numbers
function float_only(params) {
    for (var i=0;i<params.length;i++){
        $('input'+'#'+params[i]+'').on('input', function() {

            this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');
        });
    }
}

//format price when input
function price_only(params) {
    for (var i=0;i<params.length;i++){
        $('input'+'#'+params[i]+'').on('input', function() {

            this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1').replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") ;

            if (this.value.length>21){

                var cut= $('#'+params[i]+'').val().substring(0,21);
                $('#'+params[i]+'').val(cut);
            }

        });
    }
}


//Validation v2.0

//alert border has error
function alert_border(params) {
    for (var i=0;i<params.length;i++){
        $('.'+params[i]).parent().addClass('has-error');
    }
}

//clear border has error
function clear_border(params) {
    for (var i=0;i<params.length;i++){
        $('.'+params[i]).parent().removeClass('has-error');
    }
}

//clear message error
function clear_error(params) {
    for (var i=0;i<params.length;i++){
        $('#'+params[i]).html('');
    }
}

//alert message error with laravel
function data_error(name,text_id,border_id) {
    if (name) {
        errors('#'+text_id, name[0], '.'+border_id);
    }
}


//alert toastr error
function alert_toast_error(text) {
    Command: toastr["error"](text);
}


//auto close date after select
/*$('.date').datepicker()
    .on('changeDate', function(ev){
        $('.date').datepicker('hide');
});*/

$('.datepicker-custom').datepicker({
    format: 'dd/MM/yyyy',
    todayHighlight:'TRUE',
    autoclose: true,
});

//range date
/*
$(function() {

    var start = moment();
    var end =  moment();
/!*
    function cb(start, end) {

        var s=start.format('D MMMM, YYYY');
        var e=end.format('D MMMM, YYYY');

        //get current start and end date now
        var now_start=moment().subtract(1, 'month').startOf('month').format('D MMMM, YYYY');
        var now_end=moment().endOf('month').format('D MMMM, YYYY');

        //set to all time when load equal to two months
        if (s==now_start&&e==now_end){
            $('#date-range span').html('All Time');
        }else{
            $('#date-range span').html(start.format('D MMMM, YYYY') + ' - ' + end.format('D MMMM, YYYY'));
        }



    }*!/

/!*    function df() {

        if (filter_date<1){
            $('#reportrange span').html('Filter by date');
        }else{
            cb(start, end);
        }

        filter_date++;

    }*!/


/!*    $('#date-range').daterangepicker({
        "showDropdowns": true,
        "autoApply": true,
         startDate: start,
         endDate: end,
         ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
            'This Year': [moment().startOf('year'), moment().endOf('year')]
        }

    }, cb);

    cb(start, end);*!/



});
*/

function filter_date(start_date,end_date) {

    $('#date-range').daterangepicker({
        "showDropdowns": true,
        "autoApply": true,
        startDate: start_date,
        endDate: end_date,
        ranges: {
            'All Time': [start_date,end_date],
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
            'This Year': [moment().startOf('year'), moment().endOf('year')]
        }

    }, cb);

    cb(start_date, end_date);
}

function filter_date_no_all(start_date,end_date) {
    $('#date-range').daterangepicker({
        "showDropdowns": true,
        "autoApply": true,
        startDate: start_date,
        endDate: end_date,
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
            'This Year': [moment().startOf('year'), moment().endOf('year')]

        }

    }, cb);

    cb(start_date, end_date);
}

function cb(start, end) {
        $('#date-range span').html(start.format('D MMM, YYYY') + ' - ' + end.format('D MMM, YYYY'));
}


// On the same page when refresh on nav
/*jQuery(function ($) {
    $("ul a")
        .click(function(e) {
            var link = $(this);

            var item = link.parent("li");

            if (item.hasClass("active")) {
                item.removeClass("active").children("a").removeClass("active");
            } else {
                item.addClass("active").children("a").addClass("active");
            }

            if (item.children("ul").length > 0) {
                var href = link.attr("href");
                link.attr("href", "#");
                setTimeout(function () {
                    link.attr("href", href);
                }, 300);
                e.preventDefault();
            }
        })
        .each(function() {
            var link = $(this);
            if (link.get(0).href === location.href) {
                link.addClass("active").parents("li").addClass("active");
                return false;
            }
        });
});*/


//Accordions
$('.toggle').click(function(e) {
    e.preventDefault();

    var $this = $(this);

    if ($this.next().hasClass('show')) {
        $this.next().removeClass('show');
        $this.next().slideUp(350);
    } else {
        $this.parent().parent().find('li .inner').removeClass('show');
        $this.parent().parent().find('li .inner').slideUp(350);
        $this.next().toggleClass('show');
        $this.next().slideToggle(350);
    }
});

//Display list by route and choose a select to change
function listing(route,select) {
    var sl=$('#'+select+'');
    sl.empty();
    var url_req=route;

    $.get(url_req,function (data,status) {
        console.log(data);
        var option='';
        for (var i=0;i<data.length;i++){
            option+='<option value="">Select an option...</option>';
            option+='<option value="'+data[i].id+'">'+data[i].name +'</option>';
        }

        sl.html(option);
    });
}

//Delete by route and id
function master_delete(route,id,token,text_deleted,text_cant_delete,refresh_route) {

    //delete from database
    $.ajax({
        type: 'post',
        url: route,
        data: {
            "_token":token,
            'id': id
        },
        success: function (data) {
            console.log(data);

            //alert error if delete = false
            if (data.delete=='false'){
                swal_alert('Can\'t delete!',text_cant_delete,'error');
            }else{
                //alert successful deleted
                swal_alert('Deleted',text_deleted,'success');

                master(refresh_route);


            }

        }
    });
}

//Delete Master Alert
function master_delete_with_alert(text,route,id,token,text_deleted,text_cant_delete,refresh_route) {
            swal({
                    title: "Are you sure?",
                    text: text,
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes, delete it!",
                    closeOnConfirm: false
                },
                function(){

                    master_delete(route,id,token,text_deleted,text_cant_delete,refresh_route);

                    /*,function() {
                        location.reload();
                    });*/

                });
}


/*allow add new when no select on select2*/
$(".tags").select2({
    tags: true
});

//disable search on select2
$('.no-search').select2({
    minimumResultsForSearch: -1
});

//remove no refresh to refresh to make it go back side
function refresh() {
    $('.no-refresh').removeClass('no-refresh').addClass('refresh');
}

//remove refresh to no refresh
function no_refresh() {
    $('.refresh').removeClass('refresh').addClass('no-refresh');
}

//error box sweetalert2
function swal_alert(title,text,type) {
    swal(title, text, type);
    refresh();
}

//error box sweetlert wtih auto close
function swal_alert_autoclose(title,text,type,timer,showConfirm) {
    swal({
        title: title,
        text: text,
        type: type,
        timer: timer,
        showConfirmButton: showConfirm
    });
}

function swal_alert_no_button(title,text,type) {
    swal({
        title: title,
        text: text,
        timer: 2000,
        showCancelButton: false,
        showConfirmButton: false
    });

    refresh();
}

//customize input tag on contact phone
$('.tagsinput').tagsInput({
    'defaultText':'Contact Number',
    'placeholderColor' : 'rgb(109, 118, 125)',
    'width':'100%',
    'height':'100%',
    'removeWithBackspace' : false

});

//on focus add shadow
$('div.tagsinput input').focus(function() {
    $('div.tagsinput').addClass('border-shadow');
});

//off focus remove shadow
$('div.tagsinput input').focusout(function () {
    $('div.tagsinput').removeClass('border-shadow');
});

//on type format phone
$('div.tagsinput input').keydown(function() {
    javascript:backspacerDOWN(this,event);
});

$('div.tagsinput input').keyup(function() {
    javascript:backspacerUP(this,event);
});

//clear input placeholder on focus
clear_placeholder_on_focus('input');

//clear textarea placeholder on focus
clear_placeholder_on_focus('textarea');

//Clear placeholder when focus start

function clear_placeholder_on_focus(key) {
    jQuery(document).ready(function()
    {
        jQuery(key).each(function()
        {
            if (jQuery(this).attr('placeholder') && jQuery(this).attr('placeholder') != '')
            {
                jQuery(this).attr( 'data-placeholder', jQuery(this).attr('placeholder') );
            }
        });

        jQuery(key).focus(function()
        {
            if (jQuery(this).attr('data-placeholder') && jQuery(this).attr('data-placeholder') != '')
            {
                jQuery(this).attr('placeholder', '');
            }
        });

        jQuery(key).blur(function()
        {
            if (jQuery(this).attr('data-placeholder') && jQuery(this).attr('data-placeholder') != '')
            {
                jQuery(this).attr('placeholder', jQuery(this).attr('data-placeholder'));
            }
        });
    });
}

//Clear placeholder when focus end

//Show N/A if empty
function show_na_empty($val) {
    if ($val==''||$val==null){
        return 'N/A';
    }else{
        return $val;
    }
}

//add z index back when click on profile nav right
$('#user-r').click(function () {
   no_refresh();
});

//add z index back when click on notification nav right
$('#notify-r').click(function () {
    no_refresh();
});

//set placeholder to select2
$('.select-none').select2({
    placeholder: {
        id: '',
        text: '  Select None'
    }
});

//Change selected on select2 to default option
function clear_select(params) {
    for (var i=0;i<params.length;i++){
        $('#'+params[i]+'').val("").change();
    }
}

//Add and clear error on type
function on_change_input(id,input_id,error_id,error_text) {
    if ($('#'+id+'').val()==''){
        $('.'+input_id+'').parent().addClass('has-error');
        $('#'+error_id+'').html(error_text);
    }else{
        clear_border([input_id]);     //Chart on load
        clear_error([error_id]);
    }
}

//Enable select2
function enable_select(params) {
    for (var i=0;i<params.length;i++){
        // $('#'+params[i]+'').val("").change();
        $(''+params[i]+'').prop("disabled", false);
    }
}

function scroll_to_top(number) {
    $('html, body').animate({ scrollTop: number }, 'fast');
}

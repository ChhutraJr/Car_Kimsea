<!DOCTYPE>
<html>
<head>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <title>Receipt Order</title>
    <link rel="stylesheet" media="screen" href="">
    <script src="{{url('/js/jquery/jquery-2.2.1.js')}}"></script>
    <style>
        @import url('https://fonts.googleapis.com/css?family=Hanuman');
        @import url('https://fonts.googleapis.com/css?family=Battambang');
        @import url('https://fonts.googleapis.com/css?family=Content');
        @import url('https://fonts.googleapis.com/css?family=Moul');
        @import url('https://fonts.googleapis.com/css?family=Ubuntu|Ubuntu+Condensed|Ubuntu+Mono');
        @page { size: auto;  margin: 5.5mm;margin-left: 3.5mm }
 
    </style>
 
    <style>
        .text-right{
            text-align: right;
            font-family: "Times New Roman";
        }
        .center{
            text-align: center;
            font-family: "Kh Battambang";
            font-size: 16px;
        }
        table tr td.text-under{
            text-decoration: underline;   
        }
        .border-bot{
            border-bottom: 1px solid;
        }
        .border{
            border: 1px solid;
        }
        .fs-12{
            font-size: 12px;
        }
        .fs-13{
            font-size: 20px;
            line-height: 40px;
        }
        .fs-10{
            font-size: 10px;
        }
        .fs-8{
            font-size: 8px;
        }
        .noborder{
            border: 0;
        }
        .all-border-bot td{
            border-bottom: 1px solid;
        }
        .all-border-bot th{
            border-bottom: 1px solid;
        }
        .noborder-left{
            border-left: 0;
        }
        .border-left{
            border-left: 1px solid;
        }
        .fs-9{
            font-size: 9px;
        }
        table{
            border: 1px black;

        }
        .font-btb{
            font-family: 'Battambang', cursive;
        }
        .font-content{
            font-family: 'Content', cursive;
        }
        .font-ubuntu{
            font-family: 'Ubuntu', sans-serif;
        }

        .cus-color{
            color: #ff6054;
        }

    </style>
</head>
<body >
    <div class="container font-btb" >
        {{--<img src="{{url('storage/invoice/car-garage.png')}}" alt="" width="100%" height="100px">--}}
                <table border="0" style="width: 100%;margin-top: 10px" id="table_header">
                    <tr>
                        <td  align = "left" colspan="1" class="">
                        <span style="text-align: left; font-family: 'Kh Battambang'">
                          <img src="{{url('storage/logo/logo-kimsea.png')}}" alt="" width="600px" height="120px">
                        </span>
                        </td>
                        <td align = "right"  colspan="2" >
                        <span class="fs-13">
                                   <b class="font-ubuntu"> Tel : 077 43 00 77 / 010 43 00 77 / 017 54 32 56 <br> </b>
                                              ផ្ទះលេខ 274 ផ្លូវលេខ 58 សង្កាត់ភ្នំពេញថ្មី​​ <br>
                                                ខណ្ឌសែនសុខ រាជធានីភ្នំពេញ
                        </span>
                        </td>
                    </tr>

                    <tr>
                        <td  align = "center" colspan="2" class="center">
                        <span class="font-content" style="font-size: 19px;letter-spacing: 0.6px;line-height: 60px;">
                            <b> ជួសជុលគ្រឿងក្រោមរថយន្ត​ មាសុីនត្រជាក់ ប្រព័ន្ធភ្លើង តោនផ្សារបាញ់ថ្នាំ ប្តូរប្រេងមាសុីន(លក់ដុំ & រាយ) ប៉ូលា និងអូសរថយន្ត24ម៉ោង </b>
                        </span>
                        </td>
                    </tr>
                <tr >
                    </td>
                    <td colspan="1">
                        <span class="fs-13 font-ubuntu">
                            <b style="margin-left:-3px">Repair Order</b>
                        </span>
                    </td>
                    
                    <td align = "right" colspan="1">
                        <span class="fs-13 font-ubuntu">
                            <b style="margin-left: 5px">Nº <span class="cus-color">{{str_pad($ro_no, 6, '0', STR_PAD_LEFT)}}</span></b>
                        </span>
                    </td>
                </tr>
            </table>
            <table border= "1" cellpadding="3" style=" border-collapse: collapse;" id="table_header" width="100%">
 
                <tr>
                    <td width="50%">
                        <span class="fs-13">
                            ថ្ងៃណាត់ឆែក​​​ <span style="letter-spacing: 30px;margin-left: 40px;margin-right: 30px">/ /</span>ម៉ោង:
                           
                        </span>
                    </td>
                    <td width="50%">
                        <span class="fs-13">
                             ថ្ងៃចូល  <span style="letter-spacing: 30px;margin-left: 40px;margin-right: 30px">/ /</span>ម៉ោង:
                        </span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="fs-13">
                            អ្នកទទួល/ទីប្រឺក្សាសេវាកម្ម: ..............................................................
                        </span>
                    </td>
					<td>
                        <span class="fs-13">
                            ថ្ងៃប្រគល់ឡាន:​​​ <span style="letter-spacing: 30px;margin-left: 40px;margin-right: 30px">/ /</span>ម៉ោង:
                        </span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="fs-13">
                            ឈ្មោះអតិថិជន:  <span class="font-ubuntu cus-color">{{$master->name}}</span>
                        </span>
                    </td>
					<td>
                        <span class="fs-13">
                            ទូរសព័្ទលេខ:  <span class="font-ubuntu cus-color">{!!get_customer_multi_tel($master->id)!!}</span>
                        </span>
                    </td>
                </tr>
              <tr>
                    <td>
                        <span class="fs-13">
                            អាស័យដ្អាន: @if(!is_null($master->address)) <span class="font-ubuntu cus-color">{{$master->address}}</span> @endif
                        </span>
                    </td>
					<td>
                        <span class="fs-13 font-ubuntu">
                             Email: @if(!is_null($master->email)) <span class="font-ubuntu cus-color">{{$master->email}}</span> @endif
                        </span>
                    </td>
                </tr>
                <tr>
                     <td>
                            <span class="fs-13">
                                ម៉ូឌែលឡាន:@if(!is_null($master->vm_name)) <span class="font-ubuntu cus-color">{{$master->vm_name}}</span> @endif
                             </span>

                        <span class="fs-13" style="margin-left: 135px">
                                 <span class="font-btb">ឆ្នាំផលិត:</span>  <span class="font-ubuntu cus-color">{{$master->year}}</span>
                             </span>
                    </td>
					<td>
                        <span class="fs-13">
		<span class="font-btb">ស្លាកលេខ:</span> <span class="font-ubuntu cus-color">{{$master->plate_no}}</span>

                        </span>

                        <span class="fs-13 font-ubuntu" style="margin-left: 135px">
                            Check KM:
                        </span>
                    </td>
                </tr>
                <tr>
                         <td colspan="2">
                        <span class="fs-13">
                            ពត៍មានដែលបានធ្វើពីមុន: ...............................................................................................................................................................................<br>
                            .........................................................................................................................................................................................................................
                        </span>
                    </td>

                </tr>
                <tr>
                    <td colspan="2">
                        <span class="fs-13">
                            សំនើររបស់អតិថិជន:........................................................................................................................................................................................ <br>
                            ......................................................................................................................................................................................................................... <br>
                            ......................................................................................................................................................................................................................... <br>
                            .........................................................................................................................................................................................................................
                        </span>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center">
                        <span class="fs-13">
                            គំរោងជាងឆែកតាមសំនើររបស់អតិថិជន
                        </span>
                    </td>

                    <td style="text-align: center">
                        <span class="fs-13" >
                            គំរោងជាងឆែកក្រៅសំនើររបស់អតិថិជន
                        </span>
                    </td>

                </tr>
                <tr>
                    <td style="text-align: center">
                        <span class="fs-13" >
                            ............................................................................................................ <br>
                        ............................................................................................................ <br>
                        ............................................................................................................ <br>
                        ............................................................................................................ <br>
                        ............................................................................................................ <br>
                        ............................................................................................................ <br>
                        ............................................................................................................ <br>
                        ............................................................................................................ <br>
                        ............................................................................................................ <br>
                        ............................................................................................................ <br>
                        ............................................................................................................ <br>
                        ............................................................................................................ <br>
                        ............................................................................................................

                        </span>
                    </td>
                    <td style="text-align: center">
                        <span class="fs-13">
                         ............................................................................................................ <br>
                        ............................................................................................................ <br>
                        ............................................................................................................ <br>
                        ............................................................................................................ <br>
                        ............................................................................................................ <br>
                        ............................................................................................................ <br>
                        ............................................................................................................ <br>
                        ............................................................................................................ <br>
                        ............................................................................................................ <br>
                        ............................................................................................................ <br>
                        ............................................................................................................ <br>
                        ............................................................................................................ <br>
                        ............................................................................................................
                        </span>
                    </td>
                </tr>


                </table>
        <table border= "1" cellpadding="3" style=" border-collapse: collapse;border-top: 0px" id="table_header" width="1091px">
            <tr>
                <td colspan="1" style="border-right: 0px" >
                        <span class="fs-13">
                            <img src="{{url('storage/logo/car.png')}}" alt="" width="273px" height="150px">
                        </span>
                </td>
                <td colspan="1" style="border-left:0;" >
                    <span class="fs-13">
                        ....................................................<br>
                        ....................................................<br>
                        ....................................................<br>
                        ....................................................<br>
                        ....................................................<br>
                        ....................................................
                    </span>
                </td>
                <td colspan="1" style="margin-bottom: 5px">
                        <span class="fs-13" >
								តម្លៃប្រហែលលើការជួសជុល​ : <span class="font-ubuntu">USD $</span>................................................<br>
								អតិថិជនបានយល់ព្រមចំពោះតម្លៃខាងលើ:.........................................<br>
							សេវ៉ាកម្មថែទាំ​​ នឺងជួសជុលរថយន្តដោយក្ដីសោមន្សរីករាយ។
                            <br>
							<span class="font-ubuntu">Accounting purpose</span><br>
							<span class="font-ubuntu">Invoice No:</span>.......................................................................................<br>
							<span class="font-ubuntu" >Invoice Date:</span>...................................................................................

                            <br>

                        </span>
                </td>
            </tr>
        </table>
    </div>

    <input type="hidden" id="cus_id" value="{{$master->id}}">

<p><a class="btnPrint"></a></p>
   <script type="text/javascript">
       window.onload= function () {
           window.print();
           window.close();
       };

       window.onafterprint = function(){
           $.ajax({
               type: 'post',
               url: "{{route('store.ro_no')}}",
               data: {
                   "_token": "<?=csrf_token()?>",
                   'cus_id':$('#cus_id').val()
               },
               success: function (data) {
                   console.log(data);

               }
           });
       }
    </script>
</body>
</html>
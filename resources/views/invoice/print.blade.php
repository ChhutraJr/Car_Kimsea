<!DOCTYPE>
<html>
<head>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <title>Invoice</title>
    <script src="{{url('Admin/print/jquery-1.4.4.min.js')}}jquery.min.js" type="text/javascript"></script>
    <script src="{{url('Admin/print/jquery.printPage.js')}}" type="text/javascript"></script>
    <script src="{{url('Admin/js/jquery/jquery-2.2.1.min.js')}}" type="text/javascript"></script>
    <link rel="stylesheet" media="screen" href="">
    <link rel="icon" href="{{url('/storage/logo/edgesight_notext.ico')}}" type="image/x-icon">
    <style>


        @import url('https://fonts.googleapis.com/css?family=Hanuman');
        @import url('https://fonts.googleapis.com/css?family=Battambang');
        @import url('https://fonts.googleapis.com/css?family=Content');
        @import url('https://fonts.googleapis.com/css?family=Moul');
        @import url('https://fonts.googleapis.com/css?family=Ubuntu|Ubuntu+Condensed|Ubuntu+Mono');
        @page { size: auto;  margin: 0mm; }

        .hr_top{
            display: block;
            height: 1px;
            background: transparent;
            width: 100%;
            border: none;
            /*border-top: solid 4px black;*/
        }

        .invoice-title h2, .invoice-title h3 {
            display: inline-block;
        }

        .table > tbody > tr > .no-line {
            border-top: none;
        }

        .table > thead > tr > .no-line {
            border-bottom: none;
        }

        .table > tbody > tr > .thick-line {
            border-top: 1px solid #cccccc;
        }
        .font-ubuntu{
            font-family: 'Ubuntu', sans-serif;
            font-size: 13px;
        }
        table tr td span{
            font-size: 10px;
        }
        .text-right{
            text-align: right;
            font-family: "Ubuntu";
        }
        .text-center{
            text-align: left;

        }
        .text-center{
            text-align: center;
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
            font-size: 13px;
        }

        .font-content{
            font-family: 'Content', cursive;
        }
        .font-btb{
            font-family: 'Battambang', cursive;
        }

    </style>
    <script type="text/javascript">
       window.onload= function () { window.print();window.close();  }
    </script>
</head>
{{--<body style=" background-color: #d1ead1; color:#0b0b94;">--}}
<body>
    <div class="container font-btb" style="font-size: 9px; padding:0 30px">
        <div class="row col-md-12" style="margin-top: 28px">
             <img src="{{url('storage/invoice/car-garage.png')}}" alt="" width="630px" height="100px">

            <table border="0" style="width: 100% !important;" id="table_header">
                <tr>
                    <td colspan="5" class="">
                        <span style="text-align: left; font-size: 11px;">
                         ជួសជុលគ្រឿងក្រោមរថយន្ត​ មាសុីនត្រជាក់ ប្រព័ន្ធភ្លើង តោនផ្សារបាញ់ថ្នាំ ប្តូរប្រេងមាសុីន(លក់ដុំ&រាយ) ប៉ូលា និងអូសរថយន្ត 24ម៉ោង
                        </span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="fs-9" width="40%">
                            ឈ្មោះអតិថិជន: <span class="font-ubuntu">{{Liseng::getCustomerBySellID($id)->name}}</span>
                        </span>
                    </td>
                    <td rowspan="4" class="text-left text-under" width="40%">
                        <span style="font-family: 'Moul', cursive;font-size: 18px;margin-left: 39px">
                            វិក័យប័ត្រ
                        </span>
                    </td>
                    <td class="text-right" width="100px">
                        <span class="fs-9 font-ubuntu" style="margin-right: 39px">
                       <b> No:  {{str_pad(Liseng::getInvoiceBySellID($id)->invoice_no, 6, '0', STR_PAD_LEFT)}} &nbsp; </b>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="fs-9">
                            លេខទូរសព្ទ័:
                            @php $tel=Liseng::getCustomerTelBySellID($id); @endphp
                            <span class="font-ubuntu">{{$tel}}</span>

                        </span>
                    </td>
                    <td class="text-right" rowspan="3">
                        <span  class="fs-9 font-ubuntu" style="letter-spacing: 0.4px;">
                          <b> Tel : 077 43 00 77 <br>  </b>
                              <b> : 010 43 00 77 <br> </b>
                              <b> : 017 54 32 56 <br> </b>
                              <b style="margin-right: 3px"> : 098 22 29 66 </b>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="fs-9">
                            ផ្លាកលេខ:
                            @php $plate=Liseng::getCustomerPlateBySellID($id); @endphp
                            @if ( $plate!= '')
                                <span class="font-ubuntu">{{$plate->plate_no}}</span>

                            @endif
                        </span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="fs-9">
                            ម៉ាករថយន្ត:
                            @php $model=Liseng::getCustomerModelBySellID($id); @endphp
                            @if ($model!='')
                                <span class="font-ubuntu">{{$model->name}}</span>

                            @endif
                        </span>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <span class="fs-9">
                            ផ្ទះលេខ 274​ ផ្លូវលេខ 58 សង្កាត់ភ្នំពេញថ្មី ខណ្ឌសែនសុខ  រាជធានីភ្នំពេញ
                        </span>
                    </td>
                    <td class="text-right">
                        <span class="fs-9">
                           <span class="font-btb fs-9"> ថ្ងៃទី  </span>  <span class="font-ubuntu fs-9">{{date('d', strtotime(Liseng::getInvoiceBySellID($id)->date))}}</span>  <span class="font-btb fs-9"> ខែ </span> <span class="font-ubuntu fs-9">{{date('m', strtotime(Liseng::getInvoiceBySellID($id)->date))}}</span> <span class="font-btb fs-9">ឆ្នាំ </span> <span class="font-ubuntu fs-9">{{date('Y', strtotime(Liseng::getInvoiceBySellID($id)->date))}}</span>

                        </span>
                    </td>
                </tr>
            </table>
            <table border="1" style="    margin-left: 3px;width: 99%; margin-bottom: 35px; border-collapse: collapse; border-bottom: 0; border-left: 0;border-right: 1px solid black" id="table_content">
                <thead>
                <tr class="fs-9 all-border-bot">
                    <th width="15px" class="border-left">
                        <span>ល.រ</span>
                    </th>
                    <th>
                        <span>ឈ្មោះទំនិញ</span>
                    </th>
                    <th>
                        <span>ចំនួន</span>
                    </th>
                    <th>
                        <span>តំលៃរាយ</span>
                    </th>
                    <th>
                        <span>តំលៃសរុប</span>
                    </th>
                </tr>
                </thead>
                <tbody>
                @php $detail = Liseng::getInvoiceDetailBySellID($id);$n=0;$last=0; @endphp
                @foreach ($detail as $item)
                    <tr class="fs-9 text-center all-border-bot">
                        <td class="border-left font-ubuntu">{{$loop->iteration}}</td>
                        <td align="left" class="font-btb">{{Liseng::getProductByInvoiceDetailID($item->id)}}</td>
                        <td class="font-ubuntu">{{$item->qty}}</td>
                        <td class="font-ubuntu">{{'$'.number_format($item->price, 2)}}</td>
                        <td class="font-ubuntu">{{'$'.number_format($item->total, 2)}}</td>
                    </tr>

                    @if($loop->iteration==$detail->count())
                        @if($loop->iteration<=15)
                            @php
                                $n=15-$loop->iteration;
                                $last=$loop->iteration;
                            @endphp

                            @for($i=1;$i<=$n;$i++)
                                <tr class="fs-9 text-center all-border-bot" height="23px">
                                    <td width="5px" class="border-left font-ubuntu">{{$last+$i}}</td>
                                    <td class="font-btb"></td>
                                    <td class="font-ubuntu"></td>
                                    <td class="font-ubuntu"></td>
                                    <td class="font-ubuntu"></td>
                                </tr>
                            @endfor
                        @endif
                    @endif
                @endforeach

                </tbody>
                <tfoot>
                <tr class="fs-9 text-center">
                    <td class="noborder text-right font-btb" style="padding-right: 10px;" colspan="4"><b>សរុប<span class="font-ubuntu">/Total</span></b></td>
                    <td class="border-bot border-left font-ubuntu fs-9">{{'$'.number_format(Liseng::getInvoiceBySellID($id)->amount, 2)}} </td>
                </tr>
                @if(Liseng::getInvoiceBySellID($id)->dis_total_amount>0)
                    <tr class="fs-9 text-center">
                        <td class="noborder text-right font-btb" style="padding-right: 10px;" colspan="4"><b> បញ្ចុះតំលៃ<span class="font-ubuntu">/Discount</span></b></td>
                        @if(Liseng::getInvoiceBySellID($id)->dis_type=='fixed')
                            <td class="border-bot border-left font-ubuntu fs-9">{{'$'.number_format(Liseng::getInvoiceBySellID($id)->dis_total_amount, 2)}} </td>
                        @else
                            <td class="border-bot border-left font-ubuntu fs-9">{{'%'.number_format(Liseng::getInvoiceBySellID($id)->dis_amount, 2)}} </td>
                        @endif
                    </tr>

                    <tr class="fs-9 text-center">
                        <td class="noborder text-right font-btb" style="padding-right: 10px;" colspan="4"><b> តំលៃសរុប<span class="font-ubuntu">/Total Amount</span></b></td>
                        <td class="border-bot border-left font-ubuntu fs-9">{{'$'.number_format(Liseng::getInvoiceBySellID($id)->total_amount, 2)}} </td>
                    </tr>
                @endif
                <tr class="fs-9 text-center" height="23px">
                    <td class="noborder text-right" colspan="4"></td>
                    <td class="border-bot border-left font-ubuntu fs-9">{{'$'.number_format(Liseng::getInvoiceBySellID($id)->total_paid, 2)}}</td>
                </tr>
                <tr class="fs-9 text-center">
                    <td class="noborder text-right font-btb fs-9" colspan="4" style="padding-right: 10px;"><b>នៅសល់<span class="font-ubuntu">/Balance</span></b></td>
                    <td class="border-bot border-left font-ubuntu">{{'$'.number_format(Liseng::getInvoiceBySellID($id)->total_remaining, 2)}}</td>
                </tr>
                </tfoot>
            </table>
            <table border="0" style="width: 100% !important;" id="table_header">
                <tr >
                    <th class="fs-9" style="padding-left: 76px; text-align: left; ">អតិថិជន<span class="font-ubuntu">/Customer</span></th>
                    <th class="fs-9" style="padding-right: 76px; text-align: right; ">អ្នកលក់<span class="font-ubuntu">/Seller</span></th>
                </tr>
                <tr>
                    <td style="padding-top: 30px; padding-left: 55px;">......................................</td>
                    <td style="padding-top: 30px; padding-right: 40px; text-align: right;">......................................</td>
                </tr>
            </table>
        </div>
    </div>

<p><a class="btnPrint"></a></p>
</body>
</html>
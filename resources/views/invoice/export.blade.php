<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style>
    tr > td,tr >th {
        border: 1px solid #000000;
    }
</style>

<body>
    <table border="1">
    <tr>
        <th colspan="5" style="border: 1px solid #000000;"><h3>ជួសជុលគ្រឿងក្រោមរថយន្ត​ មាសុីនត្រជាក់ ប្រព័ន្ធភ្លើង តោនផ្សារបាញ់ថ្នាំ ប្តូរប្រេងមាសុីន(លក់ដុំ&រាយ) ប៉ូលា និងអូសរថយន្ត 24ម៉ោង</h3></th>
    </tr>
    <tr>
        <td colspan="2" >ឈ្មោះអតិថិជន: {{Liseng::getCustomerBySellID($id)->name}}</td>
        <td colspan="1" ></td>
        <td colspan="2" align="right">No:  {{str_pad(Liseng::getInvoiceBySellID($id)->invoice_no, 6, '0', STR_PAD_LEFT)}} &nbsp;</td>

    </tr>
    <tr>
        @php $tel=Liseng::getCustomerTelBySellID($id); @endphp
        <td colspan="2" >លេខទូរសព្ទ័: {{$tel}} </td>
        <td colspan="1" ><h3>វិក័យប័ត្រ</h3></td>
        <td colspan="2" align="right">Tel : 077 43 00 77</td>

    </tr>
    <tr>
        @php $plate=Liseng::getCustomerPlateBySellID($id); @endphp
        <td colspan="2">ផ្លាកលេខ: @if ( $plate!= '') {{$plate->plate_no}} @endif</td>
        <td colspan="1"></td>
        <td colspan="2" align="right">: 010 43 00 77</td>

    </tr>
    <tr>
        @php $model=Liseng::getCustomerModelBySellID($id); @endphp
        <td colspan="2">ម៉ាករថយន្ត: @if ($model!='') {{$model->name}} @endif</td>
        <td colspan="1"></td>
        <td colspan="2" align="right">: 017 54 32 56</td>

    </tr>
   <tr>
        <td colspan="3"></td>
        <td colspan="2" align="right">: 098 22 29 66 </td>
    </tr>
    <tr>
         <td colspan="3">ផ្ទះលេខ 274​ ផ្លូវលេខ 58 សង្កាត់ភ្នំពេញថ្មី ខណ្ឌសែនសុខ  រាជធានីភ្នំពេញ</td>
        <td colspan="2" align="right">ថ្ងៃទី  </span>  <span class="font-ubuntu fs-9">{{date('d', strtotime(Liseng::getInvoiceBySellID($id)->date))}}</span>  <span class="font-btb fs-9"> ខែ </span> <span class="font-ubuntu fs-9">{{date('m', strtotime(Liseng::getInvoiceBySellID($id)->date))}}</span> <span class="font-btb fs-9">ឆ្នាំ </span> <span class="font-ubuntu fs-9">{{date('Y', strtotime(Liseng::getInvoiceBySellID($id)->date))}}</td>
    </tr>
    <tr></tr>
    <thead>
    <tr>
         <th>
            <span>ល.រ</span>
        </th>
        <th>
            <span>ឈ្មោះទំនិញ</span>
        </th>
        <th align="center">
            <span>ចំនួន</span>
        </th>
        <th align="center">
            <span>តំលៃរាយ</span>
        </th>
        <th align="center">
            <span>តំលៃសរុប</span>
        </th>

    </tr>
</thead>
  <tbody>
                @php $detail = Liseng::getInvoiceDetailBySellID($id);$n=0;$last=0; @endphp
                @foreach ($detail as $item)
                    <tr>
                        <td align="center">{{$loop->iteration}}</td>
                        <td align="left">{{Liseng::getProductByInvoiceDetailID($item->id)}}</td>
                        <td align="center">{{$item->qty}}</td>
                        <td align="center">{{'$'.number_format($item->price, 2)}}</td>
                        <td align="center">{{'$'.number_format($item->total, 2)}}</td>
                    </tr>

                    @if($loop->iteration==$detail->count())
                        @if($loop->iteration<=15)
                            @php
                                $n=15-$loop->iteration;
                                $last=$loop->iteration;
                            @endphp

                            @for($i=1;$i<=$n;$i++)
                                <tr >
                                    <td align="center">{{$last+$i}}</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            @endfor
                        @endif
                    @endif
                @endforeach

                </tbody>
                <tfoot>
                <tr>
                    <td  colspan="4" align="right"><b>សរុប/Total</b></td>
                    <td align="center">{{'$'.number_format(Liseng::getInvoiceBySellID($id)->amount, 2)}} </td>
                </tr>
                @if(Liseng::getInvoiceBySellID($id)->dis_total_amount>0)
                    <tr>
                        <td colspan="4" align="right"><b> បញ្ចុះតំលៃ/Discount</b></td>
                        @if(Liseng::getInvoiceBySellID($id)->dis_type=='fixed')
                            <td align="center">{{'$'.number_format(Liseng::getInvoiceBySellID($id)->dis_total_amount, 2)}} </td>
                        @else
                            <td align="center">{{'%'.number_format(Liseng::getInvoiceBySellID($id)->dis_amount, 2)}} </td>
                        @endif
                    </tr>

                    <tr>
                        <td colspan="4" align="right"><b>តំលៃសរុប/Total Amount</b></td>
                        <td align="center">{{'$'.number_format(Liseng::getInvoiceBySellID($id)->total_amount, 2)}} </td>
                    </tr>
                @endif
                <tr>
                    <td colspan="4" align="right"></td>
                    <td align="center">{{'$'.number_format(Liseng::getInvoiceBySellID($id)->total_paid, 2)}}</td>
                </tr>
                <tr>
                    <td  colspan="4" align="right"><b>នៅសល់/Balance</b></td>
                    <td align="center">{{'$'.number_format(Liseng::getInvoiceBySellID($id)->total_remaining, 2)}}</td>
                </tr>
                <tr >
                    <th colspan="2" align="center">អតិថិជន/Customer</span></th>
                    <th colspan="1" ></th>
                    <th  colspan="2" align="center">អ្នកលក់/Seller</span></th>
                </tr>
                </tfoot>
                
</table>
</body>
</html>
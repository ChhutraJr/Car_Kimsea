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
        <th colspan="10" align="center"  style="border: 1px solid #000000;"><h1>Maintenance & Service Record</h1></th>
    </tr>
    <tr>
        <td colspan="3" align="center">Kim Sea 2</td>
        <td colspan="4" align="center">The Only Official</td>
        <td colspan="3" align="center">យានដ្ធាន គីមសៀរ ២</td>

    </tr>
    <tr>
        <td colspan="3" align="center">#58P, Phnom Penh Thmey, Khan Sen Sok</td>
        <td colspan="4" align="center">Certified all model</td>
        <td colspan="3" align="center">ផ្ទះលេខ​ ២៧៤ ផ្លូវលេខ ៥៦ សង្កាត់ភ្នំពេញថ្មី</td>

    </tr>
    <tr>
        <td colspan="3" align="center">Phnom Penh, Cambodia</td>
        <td colspan="4" align="center">Workshop In</td>
        <td colspan="3" align="center">ខណ្ឌសែនសុខ រាជធានីភ្នំពេញ។</td>

    </tr>
    <tr>
        <td colspan="3" align="center">077 010/430 077</td>
        <td colspan="4" align="center">Cambodia</td>
        <td colspan="3" align="center">Tell: 077 010/434 007</td>

    </tr>
  
    <tr>
        <td colspan="5">Customer Name : {{$data['customer_data']->name}}</td>
        <td colspan="5">Contact Number : {!!get_customer_multi_tel($data['customer_data']->id)!!}</td>
    </tr>
    <tr>
        <td colspan="5">Address :@if(!is_null($data['customer_data']->address)){{$data['customer_data']->address}}@else N/A @endif</td>
        <td colspan="5">Email :@if(!is_null($data['customer_data']->email)){{$data['customer_data']->email}}@else N/A @endif</td>
    </tr>
    <tr>
        <td colspan="5">Vehicle Model : @if(!is_null($data['customer_data']->vm_name)){{$data['customer_data']->vm_name}}@else N/A @endif</td>
        <td colspan="5">Plate No : @if(!is_null($data['customer_data']->vm_name)){{$data['customer_data']->plate_no}}@else N/A @endif</td>
    </tr>
    <tr>
        <td colspan="5">Year : @if(!is_null($data['customer_data']->vm_name)){{$data['customer_data']->year}}@else N/A @endif</td>
        <td colspan="5">First Service : {{$data['first_service']}}</td>
    </tr>
    <tr>
        <td colspan="10" align="center">Details of Historical Maintenance/Service Performed</td>
    </tr>
    <tr>
        <th>Date</th>
        <th width="30">Description</th>
        <th>QTY</th>
        <th>Price</th>
        <th>Amount</th>
        <th>RO</th>
        <th>Invoice</th>
        <th width="30">Mechanic</th>
        <th width="30">SA</th>
        <th>KM</th>

    </tr>
   @include('inc.export_customer')
</table>
</body>
</html>
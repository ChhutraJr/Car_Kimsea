@php  $i=0;@endphp
    @foreach($data['invoice_detail'] as $item)
        <tr>
           
            <td>@if($i>0) @if($data['invoice_detail'][$i-1]['date']==$item['date']) @else{{\Carbon\Carbon::parse($item['date'])->format('d M, Y')}}@endif @else{{\Carbon\Carbon::parse($item['date'])->format('d M, Y')}}@endif</td>
            <td width="30"> @if($item['type']=='other'){{$item['des']}}@else {{get_product_description($item['pro_id'])}}@endif</td>
            <td>{{$item['qty']}}</td>
            <td>
                @php
                $price = '$0.00';
                if (!empty($item['price'])){
                    $price =  '$'.number_format($item['price'], 2);
                }
                @endphp
                {{$price}}
            </td>
            <td>
                @php
                $total = '$0.00';
                if (!empty($item['total'])){
                    $total =  '$'.number_format($item['total'], 2);
                }
                @endphp
                {{$total}}
            </td>
            <td> @if($i>0) @if($data['invoice_detail'][$i-1]['ro']==$item['ro']) @else{{$item['ro']}}@endif @else{{$item['ro']}}@endif</td>
            <td>
                @php
                $invoice_no = '';
                if (!empty($item['invoice_no'])){
                    $invoice_no = str_pad($item['invoice_no'], 6, '0', STR_PAD_LEFT);
                    
                     if($i>0){
                        if($data['invoice_detail'][$i-1]['invoice_no']==$item['invoice_no']){
                            $invoice_no = '';
                        }
                    }
                    
                    
                }
                @endphp
                {{$invoice_no}}
            </td>
            <td width="30">
               
                @if($i>0)
                    @if($data['invoice_detail'][$i-1]['invoice_no']==$item['invoice_no'])
                    @else
                    {{ get_multi_mechanic_name($item['invoice_id'])}} 
                    @endif 
                @else
                {{ get_multi_mechanic_name($item['invoice_id'])}} 
                @endif
            </td>
            <td width="30">
            @if($i>0)
                    @if($data['invoice_detail'][$i-1]['invoice_no']==$item['invoice_no'])
                    @else
                    {{ get_multi_sa_name($item['invoice_id'])}} 
                    @endif 
                @else
                {{ get_multi_sa_name($item['invoice_id'])}} 
                @endif
            </td>
            <td>
              @if($i>0)
                    @if($data['invoice_detail'][$i-1]['invoice_no']==$item['invoice_no'])
                    @else{{$item['km']}}@endif @else{{$item['km']}}
                    @endif
            </td>

        </tr>
        @php $i++;  @endphp
    @endforeach
@php  $i=0;@endphp
@foreach($data['details'] as $item)
    <tr>
        <td>
            @php
                $name = '';
                if (!empty($item['name'])){
                     $name  = $item['name'];
                }
            @endphp
            {{$name}}
        </td>
        <td>
            @php
                $code_part = '';
                if (!empty($item['code_part'])){
                      $code_part  = $item['code_part'];
                }
            @endphp
            {{$code_part}}
        </td>
        <td>{{$item['m_name']}}</td>
        <td>{{$item['c_name']}}</td>
        <td>{{$item['qty']}}</td>
    <td>
        @php
            $invoice_no = '';
            if (!empty($item['invoice_no'])){
                $invoice_no = str_pad($item['invoice_no'], 6, '0', STR_PAD_LEFT);
            }
        @endphp
        {{$invoice_no}}
    </td>
    </tr>
    @php $i++;  @endphp
@endforeach
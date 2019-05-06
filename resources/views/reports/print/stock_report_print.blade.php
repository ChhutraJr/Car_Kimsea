<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{url('/storage/logo/edgesight_notext.ico')}}" type="image/x-icon">

    <title>Stock Report</title>
    <style>
        @import url('https://fonts.googleapis.com/css?family=Content');

        @page { size: auto;  margin: 0mm; }
        table{
            border-collapse: collapse;
        }
        td,th{
            border: 1px solid;
            font-size: 11px;
        }

        body{
            font-family: 'Ubuntu', sans-serif;
        }

        .font-content{
            font-family: 'Content', cursive;
        }

    </style>

    <style>
        .page-break {
            page-break-after: always;
        }
    </style>


</head>
<script type="text/javascript">
    window.onload= function () { window.print();window.close();  }
</script>

<body style="padding: 25px">

<h3 style="text-align: center"><span style="font-size: 20px"><b>Stock Report</b></span></h3>

<table cellpadding="2">
    <thead>
    <tr>
        <th width="19px" align="center">No</th>
        <th>Product</th>
        <th>Code Part</th>
        <th>Model</th>
        <th>Use For</th>
        <th>Cost Price</th>
        <th>Sell Price</th>
        <th>Stock Total</th>
        <th>Stock Out</th>
        <th>Current Stock</th>
    </tr>
    </thead>
    <tbody>
    @foreach($master as $item)
    <tr>
        <td align="center">{{$loop->iteration}}</td>
        <td align="left"  class="font-content">{{$item->name}}</td>
        <td>{{$item->code_part}}</td>
        <td >
            @if(!empty($item->model->name))
                {{$item->model->name}}
            @endif
        </td>
        <td >
            @if(!empty($item->cat->name))
                {{$item->cat->name}}
            @endif
        </td>
        <td align="center">
            {{'$'.number_format(Liseng::get_latest_cost_price($item->id), 2)}}
        </td>
        <td align="center">
            {{'$'.number_format(Liseng::get_latest_sell_price($item->id), 2)}}
        </td>
        <td align="center">
            @if(!empty($item->total_qty))
                {{$item->total_qty}}
            @else
                0
            @endif
        </td>
        <td align="center">
            {{Liseng::get_stock_out($item->id)}}
        </td>
        <td align="center">
            @if(!empty($item->current_qty))
                {{$item->current_qty}}
            @else
                0
            @endif

        </td>

    </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
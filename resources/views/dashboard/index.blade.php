@extends('master')

@section('content')
    {{--Content--}}
    <div class="page has-sidebar-left height-full">

        <div class="container-fluid relative animatedParent animateOnce">
            <div class="row my-3">
                <div class="col-md-3">
                    <div class="counter-box white r-5 p-3">
                        <div class="p-4">
                            <div class="float-right">
                                <span class="icon icon-users s-48"></span>
                            </div>
                            <div class="counter-title">Total Users</div>
                            <span style="font-size:12px;">(Current users)</span>
                            <h5 class="sc-counter mt-3">{{config('global.user_count') }}</h5>
                        </div>
                        {{--<div class="progress progress-xs r-0">
                            <div class="progress-bar" role="progressbar" style="width: 100%;" aria-valuenow="{{config('global.user_count') }}" aria-valuemin="0" aria-valuemax="168"></div>
                        </div>--}}
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="counter-box white r-5 p-3">
                        <div class="p-4">
                            <div class="float-right">
                                <span class="icon icon-package2 s-48"></span>
                            </div>
                            <div class="counter-title ">Total Products</div>
                            <span style="font-size:12px;">({{ $model }} Models)</span>
                            <h5 class="sc-counter mt-3">{{ $product }}</h5>
                        </div>
                        {{--<div class="progress progress-xs r-0">
                            <div class="progress-bar" role="progressbar" style="width: 100%;" aria-valuenow="{{ $product }}" aria-valuemin="0" aria-valuemax="168"></div>
                        </div>--}}
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="counter-box white r-5 p-3">
                        <div class="p-4">
                            <div class="float-right">
                                <span class="icon icon-attach_money s-48"></span>
                            </div>
                            <div class="counter-title">Daily Invoices</div>
                            <span style="font-size:12px;">(Today)</span>
                            <h5 class="sc-counter mt-3">{{config('global.today_sale_amount') }}</h5>
                        </div>
                        {{--<div class="progress progress-xs r-0">
                            <div class="progress-bar" role="progressbar" style="width: 100%;" aria-valuenow="{{config('global.today_sale_amount') }}" aria-valuemin="0" aria-valuemax="168"></div>
                        </div>--}}
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="counter-box white r-5 p-3">
                        <div class="p-4">
                            <div class="float-right">
                                <span class="icon icon-ticket s-48"></span>
                            </div>
                            <div class="counter-title">Total Invoices</div>
                            <span style="font-size:12px;">(All times)</span>
                            <h5 class="sc-counter mt-3">{{ config('global.total_sale_amount') }}</h5>
                        </div>
                     {{--   <div class="progress progress-xs r-0">
                            <div class="progress-bar" role="progressbar" style="width: 100%;" aria-valuenow="{{ config('global.total_sale_amount') }}" aria-valuemin="0" aria-valuemax="168"></div>
                        </div>--}}
                    </div>
                </div>
            </div>
               <div class="row">
                    <div class="col-md-6">
                        <div class="white ">
                                <div class="card my-3 no-b">
                                    <div class="card-header white b-0 p-3">
                                        <div class="card-handle">
                                            <a data-toggle="collapse" href="#salesCard" aria-expanded="false"
                                               aria-controls="salesCard">
                                                <i class="icon-menu"></i>
                                            </a>
                                        </div>
                                        <h4 class="">Daily Invoice Report</h4>
                                    </div>
                                    <div class="collapse show" id="salesCard">
                                        <div class="card-body p-0">
                                            <div class="table-responsive">
                                                <table class="table table-hover earning-box table-daily">
                                                    <thead class="bg-light">
                                                    <tr>
                                                        <th></th>
                                                        <th>Name</th>
                                                        <th>Invoice No</th>
                                                        <th>Product Sold</th>
                                                        <th>Price</th>
                                                        <th>Date</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($invoices as $item)
                                                    <tr>
                                                        <td width="50px">
                                                            <img  class="avatar" src="{{url('/storage/'.$item->user->image)}}" alt=""></td>
                                                        <td class="w-15">

                                                            <h6>{{$item->user->first_name}} {{$item->user->last_name}}</h6>
                                                            <small class="text-muted">{{$item->user->role->name}}</small>
                                                        </td>
                                                        <td>{{str_pad($item->invoice_no, 6, '0', STR_PAD_LEFT)}}</td>
                                                        <td>{{$item->detail->sum('qty')}}</td>
                                                        <td>
                                                            ${{ number_format($item->total_amount, 2) }}
                                                        </td>
                                                        <td>
                                                            <span><i class="icon icon-timer"></i> {{\Carbon\Carbon::parse($item->date)->format('d M, Y')}}</span>
                                                        </td>
                                                    </tr>
                                                    @endforeach

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>

                   <div class="col-md-6">
                       <div class="white ">
                           <div class="card my-3 no-b">
                               <div class="card-header white b-0 p-3">
                                   <div class="card-handle">
                                       <a data-toggle="collapse" href="#salesCard2" aria-expanded="false"
                                          aria-controls="salesCard">
                                           <i class="icon-menu"></i>
                                       </a>
                                   </div>
                                   <h4 class="">Daily Purchase Report</h4>
                               </div>
                               <div class="collapse show" id="salesCard2">
                                   <div class="card-body p-0">
                                       <div class="table-responsive">
                                           <table class="table table-hover earning-box table-daily">
                                               <thead class="bg-light">
                                               <tr>
                                                   <th></th>
                                                   <th>Name</th>
                                                   <th>Reference No</th>
                                                   <th>Product Purchase</th>
                                                   <th>Price</th>
                                                   <th>Date</th>
                                               </tr>
                                               </thead>
                                               <tbody>
                                               @foreach($purchases as $item)
                                                   <tr>
                                                       <td width="50px">
                                                           <img  class="avatar" src="{{url('/storage/'.$item->user->image)}}" alt=""></td>
                                                       <td class="w-15">

                                                           <h6>{{$item->user->first_name}} {{$item->user->last_name}}</h6>
                                                           <small class="text-muted">{{$item->user->role->name}}</small>
                                                       </td>
                                                       <td>{{str_pad($item->ref_no, 6, '0', STR_PAD_LEFT)}}</td>
                                                       <td>{{$item->detail->sum('qty')}}</td>
                                                       <td>
                                                           ${{ number_format($item->total_amount, 2) }}
                                                       </td>
                                                       <td>
                                                           <span><i class="icon icon-timer"></i> {{\Carbon\Carbon::parse($item->date)->format('d M, Y')}}</span>
                                                       </td>
                                                   </tr>
                                               @endforeach

                                               </tbody>
                                           </table>
                                       </div>
                                   </div>
                               </div>
                           </div>
                       </div>
                   </div>
                </div>
        </div>
    </div>
    {{--Close Content--}}
@endsection
@extends('layouts.default')
@section('script')
@stop
@section('content')

@include('inc.flash')

<div>
    @if (isset($loan))
        <h2 style="color: green">Loan</h2>
        <table border="1">
            <thead>
                <tr>
                    <th>id</th>
                    <th>amount</th>
                    <th>duration</th>
                    <th>repayment frequency</th>
                    <th>interest rate</th>
                    <th>arrangement fee</th>
                    <th>remarks</th>
                    <th>date contract start</th>
                    <th>date contract end</th>
                    <th>last updated</th>
                    <th>created</th>
                    <th>action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{$loan->id}}</td>
                    <td>${{$loan->amount}}</td>
                    <td>{{$loan->duration}}months</td>
                    <td>{{$loan->repayment_frequency}}</td>
                    <td>{{$loan->interest_rate}}%</td>
                    <td>${{$loan->arrangement_fee}}</td>
                    <td>{{$loan->remarks}}</td>
                    <td>{{$loan->date_contract_start}}</td>
                    <td>{{$loan->date_contract_end}}</td>
                    <td>{{$loan->updated_at}}</td>
                    <td>{{$loan->created_at}}</td>
                </tr>
            </tbody>
        </table>
        <h2>Repayments</h2>
        <table border="1">
            <thead>
                <tr>
                    <th>id</th>
                    <th>amount</th>
                    <th>payment status</th>
                    <th>due date</th>
                    <th>date of payment</th>
                    <th>remarks</th>
                    <th>last updated</th>
                    <th>created</th>
                    <th>action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($loan->repayments as $repayment)
                <tr>
                    <td>{{$repayment->id}}</td>
                    <td>${{$repayment->amount}}</td>
                    <td>{{$repayment->payment_status}}</td>
                    <td>{{$repayment->due_date . ''}}</td>
                    <td>{{$repayment->date_of_payment . ''}}</td>
                    <td>{{$repayment->remarks}}</td>
                    <td>{{$repayment->last_updated_time . ''}}</td>
                    <td>{{$repayment->created_time}}</td>
                    <td>
                        {!! Form::open(['route' => ['loans.pay', $repayment->id], 'method' => 'post', 'class' => '']) !!}
                            {!! Form::submit('Pay', ['class' => '']) !!}
                            <input type="text" name="remarks" placeholder="remarks">
                        {!! Form::close() !!}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
<hr>
<a href="/">Home</a>
&nbsp;&nbsp;<a href="{{route('clients.index')}}">Clients</a>
@if (isset($client))
    &nbsp;&nbsp;<a href="{{route('loans.index')}}">Loans</a>
@endif
@stop

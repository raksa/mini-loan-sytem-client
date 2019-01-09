@extends('layouts.default')
@section('script')
@stop
@section('content')

@include('inc.flash')

<div>
    @if (isset($loan))
        <h2 style="color: green">Created Loan</h2>
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
                    <td>
                        <a href="{{route('repayments.get', $loan->id)}}">Get Repayment</a>
                    </td>
                </tr>
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

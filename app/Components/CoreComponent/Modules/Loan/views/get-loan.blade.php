@extends('layouts.default')
@section('script')
@stop
@section('content')

@include('inc.flash')

<h1>Get Loans</h1>

<a href="{{route('clients.create')}}">Go Create Client</a>
&nbsp;&nbsp;<a href="{{route('clients.get')}}">Get Clients</a>
&nbsp;&nbsp;<a href="/">Home</a>
@if (isset($client))
    &nbsp;&nbsp;<a href="{{route('loans.create', $client->getId())}}">Go Create Loan</a>
    <hr>
    client code: {{$client->getClientCode()}}
    <br>
    client name: {{$client->getFirstName()}} {{$client->getLastName()}}
    <hr>
@endif
<div>
    <h1>Data</h1>
    <div>
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
                @foreach ($loans as $loan)
                <tr>
                    <td>{{$loan->getId()}}</td>
                    <td>${{$loan->getAmount()}}</td>
                    <td>{{$loan->getMonthsDuration()}}months</td>
                    <td>{{$loan->getRepaymentFrequencyType()}}</td>
                    <td>{{$loan->getMonthlyInterestRate()}}%</td>
                    <td>${{$loan->getArrangementFee()}}</td>
                    <td>{{$loan->getRemarks()}}</td>
                    <td>{{$loan->getDateContractStart()}}</td>
                    <td>{{$loan->getDateContractEnd()}}</td>
                    <td>{{$loan->getLastUpdatedTime()}}</td>
                    <td>{{$loan->getCreatedTime()}}</td>
                    <td>
                        <a href="{{route('repayments.get', $loan->getId())}}">Get Repayment</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{$loans->links()}}
    </div>
</div>
@stop

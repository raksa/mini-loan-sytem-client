@extends('layouts.default')
@section('script')
@stop
@section('content')

@include('inc.flash')

<h1>Get Repayment</h1>

<a href="{{route('clients.create')}}">Go Create Client</a>
&nbsp;&nbsp;<a href="{{route('clients.index')}}">Clients</a>
&nbsp;&nbsp;<a href="/">Home</a>
@if (isset($client))
    &nbsp;&nbsp;<a href="{{route('loans.create', ['client_id' => $client->id])}}">Go Create Loan</a>
    <hr>
    client code: {{$client->client_code}}
    <br>
    client name: {{$client->first_name}} {{$client->last_name}}
    <hr>
@endif
@if (isset($loan))
    <div>
        <h1>Data</h1>
        <div>
            <h2>Loan</h2>
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
            <h2>Repayment</h2>
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
                        <td>{{$repayment->getId()}}</td>
                        <td>${{$repayment->getAmount()}}</td>
                        <td>{{$repayment->getPaymentStatus()}}</td>
                        <td>{{$repayment->getDueDate()}}</td>
                        <td>{{$repayment->getDateOfPayment()}}</td>
                        <td>{{$repayment->getRemarks()}}</td>
                        <td>{{$repayment->getLastUpdatedTime()}}</td>
                        <td>{{$repayment->getCreatedTime()}}</td>
                        <td>
                            {!! Form::open(['route' => ['repayments.pay', $repayment->getId()], 'method' => 'POST', 'class' => '']) !!}
                                {!! Form::submit('Pay', ['class' => '']) !!}
                                <input type="text" name="remarks" placeholder="remarks">
                            {!! Form::close() !!}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif
@stop

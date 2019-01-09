@extends('layouts.default')
@section('script')
@stop
@section('content')

@include('inc.flash')

<div>
    <h2>Client</h2>
    <table border="1">
        <thead>
            <tr>
                <th>id</th>
                <th>client code</th>
                <th>first name</th>
                <th>last name</th>
                <th>phone number</th>
                <th>address</th>
                <th>last updated</th>
                <th>created</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{$client->id}}</td>
                <td>{{$client->client_code}}</td>
                <td>{{$client->first_name}}</td>
                <td>{{$client->last_name}}</td>
                <td>{{$client->phone_number}}</td>
                <td>{{$client->address}}</td>
                <td>{{$client->updated_at . ''}}</td>
                <td>{{$client->created_at . ''}}</td>
            </tr>
        </tbody>
    </table>
    <h2>Loans</h2>
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
                @foreach ($client->loans as $loan)
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
                        <a href="{{route('loans.show', $loan->id)}}">Show</a>
                        <a href="{{route('loans.edit', $loan->id)}}">Edit</a>
                        {!! Form::open(['route' => ['loans.destroy', $loan->id], 'method' => 'delete', 'class' => '']) !!}
                            {!! Form::submit('Delete', ['class' => '']) !!}
                        {!! Form::close() !!}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<hr>
<a href="/">Home</a>
&nbsp;&nbsp;<a href="{{route('clients.index')}}">Clients</a>
&nbsp;&nbsp;<a href="{{route('loans.create', ['client_id' => $client->id])}}">Create Loan</a>
@stop

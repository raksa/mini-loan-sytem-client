@extends('layouts.app')
@section('script')
@stop
@section('content')

<div class="container">
    {{ Breadcrumbs::render('client', $client) }}
    @include('inc.flash')
    <h2>Client</h2>
    <div>
        @can('view', $clientModelClass)
            <table class="table table-striped able-bordered">
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
                <table class="table table-striped able-bordered">
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
                    @can('view', $loanModelClass)
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
                                    @can('update', $loan)
                                        <a href="{{route('loans.edit', $loan->id)}}">Edit</a>
                                    @endcan
                                    @can('delete', $loan)
                                        {!! Form::open(['route' => ['loans.destroy', $loan->id],
                                            'method' => 'delete', 'class' => '']) !!}
                                            {!! Form::submit('Delete', ['class' => '']) !!}
                                        {!! Form::close() !!}
                                    @endcan
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    @endcan
                </table>
                <hr>
                @can('create', $loanModelClass)
                    <a href="{{route('loans.create', ['client_id' => $client->id])}}">Create Loan</a>
                @endcan
            </div>
        @endcan
    </div>
</div>
@stop

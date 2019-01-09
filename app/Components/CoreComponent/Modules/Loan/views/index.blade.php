@extends('layouts.app')
@section('script')
@stop
@section('content')

<div class="container">
    @include('inc.flash')
    <h2>Clients</h2>
    @if (isset($client))
        client code: {{$client->client_code}}
        <br>
        client name: {{$client->first_name}} {{$client->last_name}}
        <hr>
    @endif
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
            <tbody>
                @foreach ($loans as $loan)
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
        {{$loans->links()}}
    </div>
</div>
<hr>
&nbsp;&nbsp;<a href="/">Home</a>
@stop

@extends('layouts.default')
@section('script')
@stop
@section('content')

@include('inc.flash')

<div>
    {!! Form::open(['route' => 'loans.store', 'method' => 'post', 'class' => '']) !!}
        <input type="hidden" name="client_id" value="{{$client->id}}">
        <div>
            <label for="amount">Amount:</label>
            $<input id="amount" name="amount" type="number" value="1000" required>
        </div>
        <div>
            <label for="duration">Month Duration:</label>
            <input id="duration" name="duration" type="number" value="12" required>months
        </div>
        <div>
            <label for="repayment_frequency">Repayment Frequency:</label>
            <select name="repayment_frequency" id="repayment_frequency">
                @foreach ($freqTypes as $key => $value)
                    <option value="{{$key}}">{{$value}}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="interest_rate">Interest Rate:</label>
            <input id="interest_rate" name="interest_rate" type="number" value="0.1" required>%
        </div>
        <div>
            <label for="arrangement_fee">Arrangement Fee:</label>
            $<input id="arrangement_fee" name="arrangement_fee" type="number" value="10" required>
        </div>
        <div>
            <label for="remarks">Remarks:</label>
            <input id="remarks" name="remarks" type="text" value="this is remarks">
        </div>
        <div>
            <label for="date_contract_start">Date Contract Start:</label>
            <input id="date_contract_start" name="date_contract_start" type="date"
                min="{{Carbon\Carbon::now()->format('Y-m-d')}}"
                max="{{Carbon\Carbon::now()->addYear(50)->format('Y-m-d')}}"
                value="{{Carbon\Carbon::now()->format('Y-m-d')}}">
        </div>
        <div>
            {!! Form::submit('Create', ['class' => '']) !!}
        </div>
    {!! Form::close() !!}
</div>
<hr>
<a href="/">Home</a>
&nbsp;&nbsp;<a href="{{route('clients.index')}}">Clients</a>
&nbsp;&nbsp;<a href="{{route('loans.index', ['client_id' => $client->id])}}">Loans</a>
@stop
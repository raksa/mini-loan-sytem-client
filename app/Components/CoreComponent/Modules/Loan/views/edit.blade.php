@extends('layouts.default')
@section('script')
@stop
@section('content')

@include('inc.flash')

<div>
    {!! Form::open(['route' => ['loans.update', $loan->id], 'method' => 'patch', 'class' => '']) !!}
        <input type="hidden" name="client_id" value="{{$loan->client_id}}">
        <div>
            <label for="amount">Amount:</label>
            $<input id="amount" name="amount" type="number" value="{{old('amount') ?? $loan->amount}}" required>
        </div>
        <div>
            <label for="duration">Month Duration:</label>
            <input id="duration" name="duration" type="number" value="{{old('duration') ?? $loan->duration}}" required>months
        </div>
        <div>
            <label for="repayment_frequency">Repayment Frequency:</label>
            <select name="repayment_frequency" id="repayment_frequency">
                @foreach ($freqTypes as $key => $value)
                    <option {{(old('repayment_frequency') ?? $loan->repayment_frequency) == $key ? 'selected' : ''}}
                        value="{{$key}}">{{$value}}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="interest_rate">Interest Rate:</label>
            <input id="interest_rate" name="interest_rate" type="number"
                value="{{old('interest_rate') ?? $loan->interest_rate}}" required>%
        </div>
        <div>
            <label for="arrangement_fee">Arrangement Fee:</label>
            $<input id="arrangement_fee" name="arrangement_fee" type="number"
                value="{{old('arrangement_fee') ?? $loan->arrangement_fee}}" required>
        </div>
        <div>
            <label for="remarks">Remarks:</label>
            <input id="remarks" name="remarks" type="text" value="{{old('remarks') ?? $loan->remarks}}">
        </div>
        <div>
            <label for="date_contract_start">Date Contract Start:</label>
            <input id="date_contract_start" name="date_contract_start" type="date"
                min="{{Carbon\Carbon::now()->format('Y-m-d')}}"
                max="{{Carbon\Carbon::now()->addYear(50)->format('Y-m-d')}}"
                value="{{old('date_contract_start') ?? $loan->date_contract_start}}">
        </div>
        <div>
            {!! Form::submit('Update', ['class' => '']) !!}
        </div>
    {!! Form::close() !!}
</div>
<hr>
<a href="/">Home</a>
&nbsp;&nbsp;<a href="{{route('clients.index')}}">Clients</a>
&nbsp;&nbsp;<a href="{{route('loans.index', ['client_id' => $loan->client_id])}}">Loans</a>
@stop

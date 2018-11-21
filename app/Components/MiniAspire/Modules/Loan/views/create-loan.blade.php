@extends('resources.views.layouts.default')
@section('script')
@stop
@section('content')

<h1>Create Loan</h1>
<div>
    {!! Form::open(['route' => 'loans.create', 'method' => 'POST', 'class' => '']) !!}
        <div>
            <label for="amount">Amount:</label>
            <input id="amount" name="amount" type="number" required>
        </div>
        <div>
            {!! Form::submit('Create', ['class' => '']) !!}
        </div>
    {!! Form::close() !!}
</div>

<hr>
<a href="/">Home</a>
&nbsp;&nbsp;<a href="{{route('loans.get')}}">Get Loans</a>
@stop

@extends('layouts.default')
@section('script')
@stop
@section('content')

@include('inc.flash')

<h2>Edit Client</h2>
<div>
    @if ($client)
        {!! Form::open(['route' => ['clients.update', $client->id], 'method' => 'patch', 'class' => '']) !!}
            <div>
                <label for="client_code">Cient Code:</label>
                <input id="client_code" name="client_code" type="text" value="{{old('client_code') ?? $client->client_code}}" disabled>
            </div>
            <div>
                <label for="first_name">First Name:</label>
                <input id="first_name" name="first_name" type="text" value="{{old('first_name') ?? $client->first_name}}" required>
            </div>
            <div>
                <label for="last_name">Last Name:</label>
                <input id="last_name" name="last_name" type="text" value="{{old('last_name') ?? $client->last_name}}" required>
            </div>
            <div>
                <label for="phone_number">Phone Number:</label>
                <input id="phone_number" name="phone_number" type="text" value="{{old('phone_number') ?? $client->phone_number}}" required>
            </div>
            <div>
                <label for="address">Address:</label>
                <input id="address" name="address" value="{{old('address') ?? $client->address}}" type="text">
            </div>
            <div>
                {!! Form::submit('Update', ['class' => '']) !!}
            </div>
        {!! Form::close() !!}
    @else
        <h3>Client not found</h3>
    @endif
</div>
<hr>
<a href="/">Home</a>
&nbsp;&nbsp;<a href="{{route('clients.index')}}">Clients</a>
@stop

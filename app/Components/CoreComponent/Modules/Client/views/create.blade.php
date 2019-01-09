@extends('layouts.app')
@section('script')
@stop
@section('content')

<div class="container">
    @include('inc.flash')
    <h2>Edit Client</h2>
    <div>
        {!! Form::open(['route' => 'clients.store', 'method' => 'post', 'class' => '']) !!}
            <div>
                <label for="first_name">First Name:</label>
                <input id="first_name" name="first_name" type="text" value="fname" required>
            </div>
            <div>
                <label for="last_name">Last Name:</label>
                <input id="last_name" name="last_name" type="text" value="lname" required>
            </div>
            <div>
                <label for="phone_number">Phone Number:</label>
                <input id="phone_number" name="phone_number" type="text" value="012345678" required>
            </div>
            <div>
                <label for="address">Address:</label>
                <input id="address" name="address" value="address" type="text">
            </div>
            <div>
                {!! Form::submit('Create', ['class' => '']) !!}
            </div>
        {!! Form::close() !!}
    </div>
</div>
<hr>
<a href="/">Home</a>
&nbsp;&nbsp;<a href="{{route('clients.index')}}">Clients</a>
@stop

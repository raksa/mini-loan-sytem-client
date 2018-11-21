@extends('resources.views.layouts.default')
@section('script')
@stop
@section('content')

@include('resources.views.inc.flash')

<h1>Create User</h1>
<div>
    {!! Form::open(['route' => 'users.create', 'method' => 'POST', 'class' => '']) !!}
        <div>
            <label for="first_name">First Name:</label>
            <input id="first_name" name="first_name" type="text" required>
        </div>
        <div>
            <label for="last_name">Last Name:</label>
            <input id="last_name" name="last_name" type="text" required>
        </div>
        <div>
            <label for="phone_number">Phone Number:</label>
            <input id="phone_number" name="phone_number" type="text" required>
        </div>
        <div>
            <label for="address">Address:</label>
            <input id="address" name="address" type="text">
        </div>
        <div>
            {!! Form::submit('Create', ['class' => '']) !!}
        </div>
    {!! Form::close() !!}
</div>

<hr>
<a href="/">Home</a>
&nbsp;&nbsp;<a href="{{route('users.get')}}">Get Users</a>
@stop

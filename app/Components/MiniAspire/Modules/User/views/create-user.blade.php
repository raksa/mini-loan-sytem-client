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

<div>
    @if (isset($user))
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>USER_CODE</th>
                    <th>FIRST_NAME</th>
                    <th>LAST_NAME</th>
                    <th>PHONE_NUMBER</th>
                    <th>ADDRESS</th>
                    <th>LAST_UPDATED</th>
                    <th>CREATED</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{$user->getId()}}</td>
                    <td>{{$user->getUserCode()}}</td>
                    <td>{{$user->getFirstName()}}</td>
                    <td>{{$user->getLastName()}}</td>
                    <td>{{$user->getPhoneNumber()}}</td>
                    <td>{{$user->getAddress()}}</td>
                    <td>{{$user->getLastUpdatedTime()}}</td>
                    <td>{{$user->getCreatedTime()}}</td>
                </tr>
            </tbody>
        </table>
    @endif
</div>

<hr>
<a href="/">Home</a>
&nbsp;&nbsp;<a href="{{route('users.get')}}">Get Users</a>
@stop

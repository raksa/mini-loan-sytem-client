@extends('resources.views.layouts.default')
@section('script')
@stop
@section('content')

@include('resources.views.inc.flash')

<h1>Create Client</h1>
<div>
    @if (isset($client))
        <h2 style="color: green">Created Client</h2>
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
                    <th>actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{$client->getId()}}</td>
                    <td>{{$client->getClientCode()}}</td>
                    <td>{{$client->getFirstName()}}</td>
                    <td>{{$client->getLastName()}}</td>
                    <td>{{$client->getPhoneNumber()}}</td>
                    <td>{{$client->getAddress()}}</td>
                    <td>{{$client->getLastUpdatedTime()}}</td>
                    <td>{{$client->getCreatedTime()}}</td>
                    <td>
                        <a href="{{route('loans.create', $client->getId())}}">Go Create Loan</a>
                    </td>
                </tr>
            </tbody>
        </table>
    @endif
</div>
<hr>
<div>
    {!! Form::open(['route' => 'clients.create', 'method' => 'POST', 'class' => '']) !!}
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
<hr>
<a href="/">Home</a>
&nbsp;&nbsp;<a href="{{route('clients.get')}}">Get Clients</a>
@stop

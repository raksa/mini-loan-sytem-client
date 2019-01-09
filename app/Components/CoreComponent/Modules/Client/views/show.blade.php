@extends('layouts.default')
@section('script')
@stop
@section('content')

@include('inc.flash')

<div>
    @if ($client)
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
                    <td>{{$client->id}}</td>
                    <td>{{$client->client_code}}</td>
                    <td>{{$client->first_name}}</td>
                    <td>{{$client->last_name}}</td>
                    <td>{{$client->phone_number}}</td>
                    <td>{{$client->address}}</td>
                    <td>{{$client->updated_at . ''}}</td>
                    <td>{{$client->created_at . ''}}</td>
                    <td>
                        <a href="{{route('clients.edit', $client->id)}}">Edit</a>
                        <a href="{{route('loans.create', ['client_id' => $client->id])}}">Go Create Loan</a>
                    </td>
                </tr>
            </tbody>
        </table>
    @else
        <h3>Client not found</h3>
    @endif
</div>
<hr>
<a href="/">Home</a>
&nbsp;&nbsp;<a href="{{route('clients.index')}}">Clients</a>
@stop

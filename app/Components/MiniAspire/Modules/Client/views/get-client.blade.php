@extends('resources.views.layouts.default')
@section('script')
@stop
@section('content')

@include('resources.views.inc.flash')

<h1>Get Clients</h1>

<a href="{{route('clients.create')}}">Go Create Client</a>
&nbsp;&nbsp;<a href="/">Home</a>

<div>
    <h1>Data</h1>
    <div>
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
                    <th>loan count</th>
                    <th>actions</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($clients as $client)
                <tr>
                    <td>{{$client->getId()}}</td>
                    <td>{{$client->getClientCode()}}</td>
                    <td>{{$client->getFirstName()}}</td>
                    <td>{{$client->getLastName()}}</td>
                    <td>{{$client->getPhoneNumber()}}</td>
                    <td>{{$client->getAddress()}}</td>
                    <td>{{$client->getLastUpdatedTime()}}</td>
                    <td>{{$client->getCreatedTime()}}</td>
                    <td>{{\count($client->loans)}}</td>
                    <td>
                        <a href="{{route('loans.get', $client->getId())}}">Go Get Loans</a>
                        <br>
                        <a href="{{route('loans.create', $client->getId())}}">Go Create Loan</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{$clients->links()}}
    </div>
</div>
@stop

@extends('layouts.default')
@section('script')
@stop
@section('content')

@include('inc.flash')

<a href="{{route('clients.create')}}">Go Create Client</a>
&nbsp;&nbsp;<a href="/">Home</a>

<div>
    <h1>Clients</h1>
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
                    <td>{{$client->id}}</td>
                    <td>{{$client->client_code}}</td>
                    <td>{{$client->first_name}}</td>
                    <td>{{$client->last_name}}</td>
                    <td>{{$client->phone_number}}</td>
                    <td>{{$client->address}}</td>
                    <td>{{$client->updated_at . ''}}</td>
                    <td>{{$client->created_at . ''}}</td>
                    <td>{{\count($client->loans)}}</td>
                    <td>
                        <a href="{{route('clients.show', $client->id)}}">Show</a>
                        <a href="{{route('clients.edit', $client->id)}}">Edit</a>
                        {!! Form::open(['route' => ['clients.destroy', $client->id], 'method' => 'delete', 'class' => '']) !!}
                            {!! Form::submit('Delete', ['class' => '']) !!}
                        {!! Form::close() !!}
                        <br>
                        <a href="{{route('loans.get', $client->id)}}">Go Get Loans</a>
                        <br>
                        <a href="{{route('loans.create', $client->id)}}">Go Create Loan</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{$clients->links()}}
    </div>
</div>
@stop

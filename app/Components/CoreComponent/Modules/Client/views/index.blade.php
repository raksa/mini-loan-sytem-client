@extends('layouts.app')
@section('script')
@stop
@section('content')

<div class="container">
    {{ Breadcrumbs::render('clients') }}
    @include('inc.flash')
    <h2>Clients</h2>
    <div>
        @can('view', $clientModelClass)
            <table class="table table-striped able-bordered">
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
                            @can('update', $client)
                                <a href="{{route('clients.edit', $client->id)}}">Edit</a>
                            @endcan
                            @can('delete', $client)
                                {!! Form::open(['route' => ['clients.destroy', $client->id], 'method' => 'delete', 'class' => '']) !!}
                                    {!! Form::submit('Delete', ['class' => '']) !!}
                                {!! Form::close() !!}
                            @endcan
                            @can('cteate', $loanModelClass)
                                <br>
                                <a href="{{route('loans.create', ['client_id' => $client->id])}}">Create Loan</a>
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{$clients->links()}}
            <hr>
            @can('create', $clientModelClass)
                <a href="{{route('clients.create')}}">Create Client</a>
            @endcan
        @endcan
    </div>
</div>
@stop

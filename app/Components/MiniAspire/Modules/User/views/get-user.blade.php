@extends('resources.views.layouts.default')
@section('script')
@stop
@section('content')

@include('resources.views.inc.flash')

<h1>Get Users</h1>

<a href="{{route('users.create')}}">Go Create User</a>
&nbsp;&nbsp;<a href="/">Home</a>

<div>
    <h1>Data</h1>
    <div>
        <table border="1">
            <thead>
                <tr>
                    <th>id</th>
                    <th>user code</th>
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
                @foreach ($users as $user)
                <tr>
                    <td>{{$user->getId()}}</td>
                    <td>{{$user->getUserCode()}}</td>
                    <td>{{$user->getFirstName()}}</td>
                    <td>{{$user->getLastName()}}</td>
                    <td>{{$user->getPhoneNumber()}}</td>
                    <td>{{$user->getAddress()}}</td>
                    <td>{{$user->getLastUpdatedTime()}}</td>
                    <td>{{$user->getCreatedTime()}}</td>
                    <td>{{\count($user->loans)}}</td>
                    <td>
                        <a href="{{route('loans.get', $user->getId())}}">Go Get Loans</a>
                        <br>
                        <a href="{{route('loans.create', $user->getId())}}">Go Create Loan</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{$users->links()}}
    </div>
</div>
@stop

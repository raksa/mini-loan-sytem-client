@extends('resources.views.layouts.default')
@section('script')
@stop
@section('content')

@include('resources.views.inc.flash')

<h1>Get Loans</h1>

<a href="{{route('users.create')}}">Go Create User</a>
&nbsp;&nbsp;<a href="{{route('users.get')}}">Get Users</a>
&nbsp;&nbsp;<a href="{{route('repayments.get')}}">Get Repayments</a>
&nbsp;&nbsp;<a href="/">Home</a>
@if (isset($user))
    &nbsp;&nbsp;<a href="{{route('loans.create', $user->getId())}}">Go Create Loan</a>
    <hr>
    user code: {{$user->getUserCode()}}
    <br>
    user name: {{$user->getFirstName()}} {{$user->getLastName()}}
    <hr>
@endif
<div>
    <h1>Data</h1>
    <div>
        <table>
            <thead>
                <tr>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($loans as $loan)
                <tr>
                    <td>{{$loan->getAmount()}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{$loans->links()}}
    </div>
</div>
@stop

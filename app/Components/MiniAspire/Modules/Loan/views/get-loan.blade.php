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
        <table border="1">
            <thead>
                <tr>
                    <th>id</th>
                    <th>amount</th>
                    <th>duration</th>
                    <th>repayment frequency</th>
                    <th>interest rate</th>
                    <th>arrangement fee</th>
                    <th>remarks</th>
                    <th>date contract start</th>
                    <th>date contract end</th>
                    <th>last updated</th>
                    <th>created</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($loans as $loan)
                <tr>
                    <td>{{$loan->getId()}}</td>
                    <td>{{$loan->getAmount()}}</td>
                    <td>{{$loan->getMonthsDuration()}}</td>
                    <td>{{$loan->getRepaymentFrequencyTypeId()}}</td>
                    <td>{{$loan->getMonthlyInterestRate()}}</td>
                    <td>{{$loan->getArrangementFee()}}</td>
                    <td>{{$loan->getRemarks()}}</td>
                    <td>{{$loan->getDateContractStart()}}</td>
                    <td>{{$loan->getDateContractEnd()}}</td>
                    <td>{{$loan->getLastUpdatedTime()}}</td>
                    <td>{{$loan->getCreatedTime()}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{$loans->links()}}
    </div>
</div>
@stop

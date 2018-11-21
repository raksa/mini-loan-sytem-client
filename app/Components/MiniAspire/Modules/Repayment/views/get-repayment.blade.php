@extends('resources.views.layouts.default')
@section('script')
@stop
@section('content')

@include('resources.views.inc.flash')

<h1>Get Repayment</h1>

<a href="{{route('users.create')}}">Go Create User</a>
&nbsp;&nbsp;<a href="{{route('users.get')}}">Get Users</a>
&nbsp;&nbsp;<a href="/">Home</a>
@if (isset($user))
    &nbsp;&nbsp;<a href="{{route('loans.create', $user->getId())}}">Go Create Loan</a>
    <hr>
    user code: {{$user->getUserCode()}}
    <br>
    user name: {{$user->getFirstName()}} {{$user->getLastName()}}
    <hr>
@endif
@if (isset($loan))
    <div>
        <h1>Data</h1>
        <div>
            <h2>Loan</h2>
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
                </tbody>
            </table>
            <h2>Repayment</h2>
            <table border="1">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>amount</th>
                        <th>payment status</th>
                        <th>due date</th>
                        <th>date of payment</th>
                        <th>remarks</th>
                        <th>last updated</th>
                        <th>created</th>
                        <th>action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($loan->repayments as $repayment)
                    <tr>
                        <td>{{$repayment->getId()}}</td>
                        <td>${{$repayment->getAmount()}}</td>
                        <td>{{$repayment->getPaymentStatus()}}</td>
                        <td>{{$repayment->getDueDate()}}</td>
                        <td>{{$repayment->getDateOfPayment()}}</td>
                        <td>{{$repayment->getRemarks()}}</td>
                        <td>{{$repayment->getLastUpdatedTime()}}</td>
                        <td>{{$repayment->getCreatedTime()}}</td>
                        <td>
                            {!! Form::open(['route' => ['repayments.pay', $repayment->getId()], 'method' => 'POST', 'class' => '']) !!}
                                {!! Form::submit('Pay', ['class' => '']) !!}
                            {!! Form::close() !!}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif
@stop

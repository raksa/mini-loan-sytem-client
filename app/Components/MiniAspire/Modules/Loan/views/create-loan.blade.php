@extends('resources.views.layouts.default')
@section('script')
@stop
@section('content')

@include('resources.views.inc.flash')

<h1>Create Loan</h1>
@if (isset($user))
<hr>
user code: {{$user->getUserCode()}}
<br>
user name: {{$user->getFirstName()}} {{$user->getLastName()}}
<hr>
<div>
    {!! Form::open(['route' => ['loans.create', $user->getId()], 'method' => 'POST', 'class' => '']) !!}
        <div>
            <label for="amount">Amount:</label>
            $<input id="amount" name="amount" type="number" value="1000" required>
        </div>
        <div>
            <label for="duration">Month Duration:</label>
            <input id="duration" name="duration" type="number" value="12" required>months
        </div>
        <div>
            <label for="repayment_frequency">Repayment Frequency:</label>
            <select name="repayment_frequency" id="repayment_frequency">
                @foreach ($freqTypes as $key => $value)
                    <option value="{{$key}}">{{$value}}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="interest_rate">Interest Rate:</label>
            <input id="interest_rate" name="interest_rate" type="number" value="0.1" required>%
        </div>
        <div>
            <label for="arrangement_fee">Arrangement Fee:</label>
            $<input id="arrangement_fee" name="arrangement_fee" type="number" value="10" required>
        </div>
        <div>
            <label for="remarks">Remarks:</label>
            <input id="remarks" name="remarks" type="text" value="remark">
        </div>
        <div>
            <label for="date_contract_start">Date Contract Start:</label>
            <input id="date_contract_start" name="date_contract_start" type="date"
                min="{{Carbon\Carbon::now()->format('Y-m-d')}}" max="{{Carbon\Carbon::now()->addYear(50)->format('Y-m-d')}}"
                value="{{Carbon\Carbon::now()->format('Y-m-d')}}">
        </div>
        <div>
            {!! Form::submit('Create', ['class' => '']) !!}
        </div>
    {!! Form::close() !!}
</div>
@endif

<hr>
<div>
    @if (isset($loan))
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
                    <td>${{$loan->getAmount()}}</td>
                    <td>{{$loan->getMonthsDuration()}}months</td>
                    <td>{{$loan->getRepaymentFrequencyType()}}</td>
                    <td>{{$loan->getMonthlyInterestRate()}}%</td>
                    <td>${{$loan->getArrangementFee()}}</td>
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
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

<hr>
<a href="/">Home</a>
&nbsp;&nbsp;<a href="{{route('users.get')}}">Get Users</a>
@if (isset($user))
    &nbsp;&nbsp;<a href="{{route('loans.get', $user->getId())}}">Get Loans</a>
@endif
@stop

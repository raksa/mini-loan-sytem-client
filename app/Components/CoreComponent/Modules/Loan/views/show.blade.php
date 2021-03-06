@extends('layouts.app')
@section('script')
@stop
@section('content')

<div class="container">
    {{ Breadcrumbs::render('loan', $loan) }}
    @include('inc.flash')
    <h2>Client</h2>
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
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{$loan->client->id}}</td>
                        <td>{{$loan->client->client_code}}</td>
                        <td>{{$loan->client->first_name}}</td>
                        <td>{{$loan->client->last_name}}</td>
                        <td>{{$loan->client->phone_number}}</td>
                        <td>{{$loan->client->address}}</td>
                        <td>{{$loan->client->updated_at . ''}}</td>
                        <td>{{$loan->client->created_at . ''}}</td>
                    </tr>
                </tbody>
            </table>
            <h2>Loan</h2>
            @can('view', $loanModelClass)
                <table class="table table-striped able-bordered">
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
                            <td>{{$loan->id}}</td>
                            <td>${{$loan->amount}}</td>
                            <td>{{$loan->duration}}months</td>
                            <td>{{$loan->repayment_frequency}}</td>
                            <td>{{$loan->interest_rate}}%</td>
                            <td>${{$loan->arrangement_fee}}</td>
                            <td>{!!$loan->remarks!!}</td>
                            <td>{{$loan->date_contract_start}}</td>
                            <td>{{$loan->date_contract_end}}</td>
                            <td>{{$loan->updated_at}}</td>
                            <td>{{$loan->created_at}}</td>
                        </tr>
                    </tbody>
                </table>
            @endcan
            <h2>Repayments</h2>
            @can('view', $repaymentModelClass)
                <table class="table table-striped able-bordered">
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
                            <td>{{$repayment->id}}</td>
                            <td>${{$repayment->amount}}</td>
                            <td>{{$repayment->payment_status}}</td>
                            <td>{{$repayment->due_date . ''}}</td>
                            <td>{{$repayment->date_of_payment . ''}}</td>
                            <td>{!!$repayment->remarks!!}</td>
                            <td>{{$repayment->updated_at . ''}}</td>
                            <td>{{$repayment->created_at}}</td>
                            <td>
                                @can('pay', $repayment)
                                    {!! Form::open(['route' => ['loans.pay', $repayment->id], 'method' => 'post', 'class' => '']) !!}
                                        {!! Form::submit('Pay', ['class' => '']) !!}
                                        <input type="text" name="remarks" placeholder="remarks">
                                    {!! Form::close() !!}
                                @endcan
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endcan
        @endcan
    </div>
</div>
@stop

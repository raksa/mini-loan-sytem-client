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
        @endcan
    </div>
    <h2>Edit Loan</h2>
    @can('update', $loan)
        {!! Form::open(['route' => ['loans.update', $loan->id], 'method' => 'patch', 'class' => '']) !!}
            <input type="hidden" name="client_id" value="{{$loan->client_id}}">
            <div>
                <label for="amount">Amount:</label>
                $<input id="amount" name="amount" type="number" value="{{old('amount') ?? $loan->amount}}" required>
            </div>
            <div>
                <label for="duration">Month Duration:</label>
                <input id="duration" name="duration" type="number" value="{{old('duration') ?? $loan->duration}}" required>months
            </div>
            <div>
                <label for="repayment_frequency">Repayment Frequency:</label>
                <select name="repayment_frequency" id="repayment_frequency">
                    @foreach ($freqTypes as $key => $value)
                        <option {{(old('repayment_frequency') ?? $loan->repayment_frequency) == $key ? 'selected' : ''}}
                            value="{{$key}}">{{$value}}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="interest_rate">Interest Rate:</label>
                <input id="interest_rate" name="interest_rate" type="number"
                    value="{{old('interest_rate') ?? $loan->interest_rate}}" required>%
            </div>
            <div>
                <label for="arrangement_fee">Arrangement Fee:</label>
                $<input id="arrangement_fee" name="arrangement_fee" type="number"
                    value="{{old('arrangement_fee') ?? $loan->arrangement_fee}}" required>
            </div>
            <div>
                <label for="remarks">Remarks:</label>
                <input id="remarks" name="remarks" type="text" value="{{old('remarks') ?? $loan->remarks}}">
            </div>
            <div>
                <label for="date_contract_start">Date Contract Start:</label>
                <input id="date_contract_start" name="date_contract_start" type="date"
                    min="{{Carbon\Carbon::now()->format('Y-m-d')}}"
                    max="{{Carbon\Carbon::now()->addYear(50)->format('Y-m-d')}}"
                    value="{{old('date_contract_start') ?? $loan->date_contract_start}}">
            </div>
            <div>
                {!! Form::submit('Update', ['class' => '']) !!}
            </div>
        {!! Form::close() !!}
    @endcan
</div>
@stop

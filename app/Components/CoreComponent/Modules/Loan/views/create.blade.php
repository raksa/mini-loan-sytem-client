@extends('layouts.app')

@section('style')
<link href="{{ asset('summernote/summernote-lite.css') }}" rel="stylesheet">
@stop

@section('script')
<script src="{{ asset('jquery/dist/jquery.js') }}"></script>
<script src="{{ asset('summernote/summernote-lite.js') }}"></script>
<script>
$(document).ready(function() {
    $('#remarks').summernote({
        placeholder: 'Remarks',
        tabsize: 2,
        height: 100
    });
});
</script>
@stop

@section('content')

<div class="container">
    {{ Breadcrumbs::render('loan.create', $client) }}
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
                        <td>{{$client->id}}</td>
                        <td>{{$client->client_code}}</td>
                        <td>{{$client->first_name}}</td>
                        <td>{{$client->last_name}}</td>
                        <td>{{$client->phone_number}}</td>
                        <td>{{$client->address}}</td>
                        <td>{{$client->updated_at . ''}}</td>
                        <td>{{$client->created_at . ''}}</td>
                    </tr>
                </tbody>
            </table>
        @endcan
    </div>
    <h2>Create Loan</h2>
    @can('create', $loanModelClass)
        {!! Form::open(['route' => 'loans.store', 'method' => 'post', 'class' => '']) !!}
            <input type="hidden" name="client_id" value="{{$client->id}}">
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
                <label for="date_contract_start">Date Contract Start:</label>
                <input id="date_contract_start" name="date_contract_start" type="date"
                    min="{{Carbon\Carbon::now()->format('Y-m-d')}}"
                    max="{{Carbon\Carbon::now()->addYear(50)->format('Y-m-d')}}"
                    value="{{Carbon\Carbon::now()->format('Y-m-d')}}">
            </div>
            <div>
                <label for="remarks">Remarks:</label>
                <textarea id="remarks" name="remarks"></textarea>
            </div>
            <div>
                {!! Form::submit('Create', ['class' => '']) !!}
            </div>
        {!! Form::close() !!}
    @endcan
</div>
@stop

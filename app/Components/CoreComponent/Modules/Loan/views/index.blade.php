@extends('layouts.app')
@section('script')
@stop
@section('content')

<div class="container">
    {{ Breadcrumbs::render('loans') }}
    @include('inc.flash')
    <h2>Loans</h2>
    <div>
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
                        <th>action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($loans as $loan)
                    <tr>
                        <td>{{$loan->id}}</td>
                        <td>${{$loan->amount}}</td>
                        <td>{{$loan->duration}}months</td>
                        <td>{{$loan->repayment_frequency}}</td>
                        <td>{{$loan->interest_rate}}%</td>
                        <td>${{$loan->arrangement_fee}}</td>
                        <td>{{$loan->remarks}}</td>
                        <td>{{$loan->date_contract_start}}</td>
                        <td>{{$loan->date_contract_end}}</td>
                        <td>{{$loan->updated_at}}</td>
                        <td>{{$loan->created_at}}</td>
                        <td>
                            @can('view', $loan)
                                <a href="{{route('loans.show', $loan->id)}}">Show</a>
                            @endcan
                            @can('update', $loan)
                                <a href="{{route('loans.edit', $loan->id)}}">Edit</a>
                            @endcan
                            @can('delete', $loan)
                                {!! Form::open(['route' => ['loans.destroy', $loan->id], 'method' => 'delete', 'class' => '']) !!}
                                    {!! Form::submit('Delete', ['class' => '']) !!}
                                {!! Form::close() !!}
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{$loans->links()}}
        @endcan
    </div>
</div>
@stop

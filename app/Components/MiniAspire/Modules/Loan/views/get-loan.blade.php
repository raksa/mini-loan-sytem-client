@extends('resources.views.layouts.default')
@section('script')
@stop
@section('content')

<a href="{{route('loans.create')}}">Go Create Loan</a>
&nbsp;&nbsp;<a href="/">Home</a>

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

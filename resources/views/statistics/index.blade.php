@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    Orders Statistics
                </div>
                <div class="card-body">
                    @if(count($statistics) > 0)
                        @foreach($statistics as $statistic)
                            <div class="mb-4">
                                <p><strong>Date:</strong> {{ $statistic->order_date }}</p>
                                <p><strong>Total Earnings:</strong> {{ $statistic->total_earnings }}</p>
                                <p><strong>Total Hours Worked:</strong> {{ $statistic->total_hours_worked }}</p>
                            </div>
                        @endforeach
                    @else
                        <p>
                            No orders have been completed.
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

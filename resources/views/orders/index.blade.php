@extends('layouts.app')

@section('content')
<div class="container">
    <h1>My Orders</h1>

    @if($orders->isEmpty())
        <div class="alert alert-info">You haven't placed any orders yet.</div>
    @else
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Order #</th>
                        <th>Date</th>
                        <th>Items</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->created_at->format('M d, Y') }}</td>
                        <td>{{ $order->items->sum('quantity') }}</td>
                        <td>₱{{ number_format($order->total_amount, 2) }}</td>
                        <td>
                            <span class="badge bg-{{ $order->status === 'completed' ? 'success' : 'warning' }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-primary">
                                View Details
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection

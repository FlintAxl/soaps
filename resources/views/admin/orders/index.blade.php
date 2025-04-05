@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Manage Orders</h1>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Order #</th>
                    <th>Customer</th>
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
                    <td>{{ $order->user->name }}</td>
                    <td>{{ $order->created_at->format('M d, Y') }}</td>
                    <td>{{ $order->items->sum('quantity') }}</td>
                    <td>₱{{ number_format($order->total_amount, 2) }}</td>
                    <td>
                        <span class="badge bg-{{ 
                            $order->status === 'completed' ? 'success' : 
                            ($order->status === 'cancelled' ? 'danger' : 'warning') 
                        }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-primary">
                            View/Update
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center">
        {{ $orders->onEachSide(1)->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
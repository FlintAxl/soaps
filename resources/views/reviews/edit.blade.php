@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Update Review for {{ $product->name }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('reviews.update', [
    'order' => $order->id, 
    'product' => $product->id, 
    'review' => $review->id
]) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="rating" class="form-label">Rating</label>
                            <select class="form-select" id="rating" name="rating" required>
                                @for($i = 1; $i <= 5; $i++)
                                    <option value="{{ $i }}" {{ $i == $review->rating ? 'selected' : '' }}>
                                        {{ $i }} Star{{ $i > 1 ? 's' : '' }}
                                    </option>
                                @endfor
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="comment" class="form-label">Review</label>
                            <textarea class="form-control" id="comment" name="comment" rows="3" required>{{ $review->comment }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Update Review</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Review for {{ $product->name }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('reviews.store', ['order' => $order->id, 'product' => $product->id]) }}">
                        @csrf

                        <div class="mb-3">
                            <label for="rating" class="form-label">Rating</label>
                            <select class="form-select" id="rating" name="rating" required>
                                <option value="">Select rating</option>
                                <option value="1">1 Star</option>
                                <option value="2">2 Stars</option>
                                <option value="3">3 Stars</option>
                                <option value="4">4 Stars</option>
                                <option value="5">5 Stars</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="comment" class="form-label">Review</label>
                            <textarea class="form-control" id="comment" name="comment" rows="3" required></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Submit Review</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
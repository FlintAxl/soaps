@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Manage Reviews</div>

                <div class="card-body">
                    <table class="table table-bordered" id="reviews-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>User</th>
                                <th>Product</th>
                                <th>Rating</th>
                                <th>Comment</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
$(function() {
    $('#reviews-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! route('admin.reviews.index') !!}',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'user_name', name: 'user.name' },
            { data: 'product_name', name: 'product.name' },
            { data: 'rating', name: 'rating' },
            { data: 'comment', name: 'comment' },
            { data: 'created_at', name: 'created_at' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        dom: 'Bfrtip', // This removes the default controls
        paging: false, // This disables pagination completely
        info: false, // This removes "Showing X of Y entries"
        lengthChange: false // This removes the "Show [X] entries" dropdown
    });

    // Delete review
    $('#reviews-table').on('click', '.delete-review', function() {
        if (confirm('Are you sure you want to delete this review?')) {
            var reviewId = $(this).data('id');
            $.ajax({
                url: '/admin/reviews/' + reviewId,
                type: 'DELETE',
                data: {
                    "_token": "{{ csrf_token() }}"
                },
                success: function(response) {
                    $('#reviews-table').DataTable().ajax.reload();
                    alert(response.message);
                },
                error: function(xhr) {
                    alert('Error: ' + xhr.responseJSON.message);
                }
            });
        }
    });
});
</script>
@endpush

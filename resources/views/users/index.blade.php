@extends('layouts.app')

@section('content')
<div class="container">
    <h2>User List</h2>
    <a href="{{ route('users.create') }}" class="btn btn-primary">Add User</a>
    <table class="table mt-3">
        <tr>
            <th>Photo</th>
            <th>Name</th>
            <th>Email</th>
            <th>Action</th>
        </tr>
        @foreach($users as $user)
        <tr>
            <td>
                <img src="{{ asset('storage/' . $user->photo) }}" width="50" alt="Profile Photo">
            </td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>
                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning">Edit</a>
                <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger">Delete</button>
                </form>
            </td>

            <td>
                <form action="{{ route('users.updateStatus', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <select name="status" onchange="this.form.submit()">
                        <option value="1" {{ $user->status ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ !$user->status ? 'selected' : '' }}>Inactive</option>
                    </select>
                </form>
            </td>

            <td>
                <form action="{{ route('users.updateRole', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <select name="role" onchange="this.form.submit()">
                        <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                </form>
            </td>

        </tr>
        @endforeach
    </table>
</div>
<style>
    .user-table-container {
        background: #fff;
        padding: 2rem;
        border-radius: 16px;
        box-shadow: 0 4px 12px rgba(147, 112, 219, 0.1);
    }

    .user-table-container h2 {
        color: #9370db;
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
    }

    .user-table .btn-primary {
        background-color: #9370db;
        border: none;
        font-weight: 500;
        padding: 0.5rem 1rem;
        border-radius: 10px;
    }

    .user-table .btn-primary:hover {
        background-color: #7b5fb0;
    }

    .user-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 1.5rem;
    }

    .user-table th {
        background-color: #f8f5ff;
        color: #9370db;
        font-weight: 600;
        padding: 0.75rem;
        border-bottom: 2px solid #e6e6fa;
    }

    .user-table td {
        padding: 0.75rem;
        vertical-align: middle;
        border-bottom: 1px solid #f0f0f0;
    }

    .user-table img {
        border-radius: 50%;
        border: 2px solid #e6e6fa;
    }

    .user-table .btn-warning {
        background-color: #ffd966;
        border: none;
        color: #444;
        font-weight: 500;
        padding: 0.4rem 0.75rem;
        border-radius: 8px;
    }

    .user-table .btn-warning:hover {
        background-color: #ffcc33;
    }

    .user-table .btn-danger {
        background-color: #ff6b6b;
        border: none;
        color: white;
        padding: 0.4rem 0.75rem;
        border-radius: 8px;
    }

    .user-table .btn-danger:hover {
        background-color: #e05252;
    }

    .user-table select {
        border: 1px solid #e6e6fa;
        border-radius: 6px;
        padding: 0.25rem 0.5rem;
        font-size: 0.85rem;
        color: #343a40;
        background-color: #f8f5ff;
    }

    .user-table select:focus {
        outline: none;
        border-color: #9370db;
        box-shadow: 0 0 0 2px rgba(147, 112, 219, 0.2);
    }
</style>

@endsection

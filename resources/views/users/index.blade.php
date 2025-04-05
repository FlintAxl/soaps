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
@endsection

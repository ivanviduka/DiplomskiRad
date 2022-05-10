@extends('layouts.header')

@section('title')
    <title>Admin</title>
@endsection

@section('description')
    <meta name="description" content="Display of all users">
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/table_style.css') }}"/>
@endsection

@section('content')
    @if (count($users) > 0)
        <div class="container mt-5 mb-5">
            <div class="panel panel-default">
                <div class="panel-body">

                    @if ($errors->has('role_id'))
                        <div class="alert alert-danger ms-3 me-3" role="alert">
                            {{ $errors->first('role_id') }}
                        </div>
                    @endif

                    <div class="container table-responsive py-5">
                        <table class="table admin-table">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Role</th>
                                <th scope="col">Number of files</th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <th scope="row">{{$users->firstItem() + $loop->index}}</th>

                                    <td class="table-text">
                                        <div>{{ $user->first_name }} {{$user->last_name}}</div>
                                    </td>

                                    <td class="table-text">
                                        <div>{{ $user->email }}</div>
                                    </td>

                                    <td class="table-text">
                                        <div>{{ $user->is_admin? "Admin" : "Student"}}</div>
                                    </td>

                                    <td class="table-text">
                                        <div>{{ $user->files->count() }}</div>
                                    </td>

                                    <td>

                                        <form class="d-flex" action="{{route('update.role', [$user])}}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <select style="width:auto;" class="form-select me-4"
                                                    name="role_id" aria-label="Role selection">
                                                <option value="#" selected>Select Role</option>
                                                <option value="0">Student</option>
                                                <option value="1">Admin</option>
                                            </select>

                                            <input type="submit" class="btn btn-outline-dark" value="Change">

                                        </form>
                                    </td>

                                    <td>

                                        <form action="{{route('delete.user', [$user])}}" method="POST">
                                            @csrf
                                            {{ method_field('DELETE') }}

                                            <button class="btn btn-outline-danger"
                                                    onclick="return confirm('Are you sure you want to delete this user?')">
                                                Delete user
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        <div style="width: 200px; height: 200px;">
                            {{ $users->links() }}
                        </div>

                    </div>
                </div>
            </div>
    @endif




@endsection

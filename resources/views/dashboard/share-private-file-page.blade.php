@extends('layouts.header')

@section('title')
    <title>Share private files</title>
@endsection
@section('description')
    <meta name="description" content="Private file share page">
@endsection

@section('content')
    <main class="login-form">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Select person to share <strong>{{$file->user_file_name}} </strong> with</div>

                        <div class="card-body">

                            @if (Session::has('message'))

                                <div class="alert alert-success" role="alert">
                                    {{ Session::get('message') }}
                                </div>

                            @endif

                            <form action="{{ route('private.file.share.post', [$file]) }}" method="POST">
                                @csrf

                                <div class="form-group row">
                                    <label for="email_address" class="col-md-4 col-form-label">E-mail address of file
                                        receiver:</label>
                                    <div class="col-md-4">
                                        <input type="text" id="email_address" class="form-control" name="email" required
                                               autofocus>
                                        @if ($errors->has('email'))
                                            <span class="text-danger">{{ $errors->first('email') }}</span>
                                        @endif
                                    </div>
                                    <div class="col-md-3">
                                        <button type="submit" class="btn btn-primary">Send download link</button>
                                    </div>
                                </div>

                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        @if(count($existingShares) > 0)
                <div class="container table-responsive py-5">
                    <table class="table admin-table">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Shared With</th>
                            <th scope="col"></th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach ($existingShares as $share)
                            <tr>
                                <th scope="row">{{$existingShares->firstItem() + $loop->index}}</th>

                                <td class="table-text">
                                    <div>{{ $share->receiver_email }}</div>
                                </td>

                                <td>
                                    <form action="{{route('delete.private.share', [$share->id])}}" method="POST">
                                        @csrf
                                        {{ method_field('DELETE') }}

                                        <button class="btn btn-outline-danger"
                                                onclick="return confirm('Are you sure you want to remove this user?')">
                                            Delete user
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <div style="width: 200px; height: 200px;">
                        {{ $existingShares->links() }}
                    </div>
                </div>
        @endif

    </main>
@endsection

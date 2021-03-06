@extends('layouts.header')

@section('title')
    <title>Public files</title>
@endsection

@section('description')
    <meta name="description" content="Homepage with shared public files">
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/table_style.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/button_style.css') }}"/>
@endsection

@section('content')

    @if (count($files) > 0)

        <div class="container-fluid w-75">

            <div>
                <input type="text" class="float-end mb-4" id="searchByName" onkeyup="myFunction()" placeholder="Search by filename...">
            </div>

            <div class="panel-body">

                <table id="filesTable" class="table styled-table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">
                            <a class="{{request()->query('sort') == 'name'? 'active-sort' : ''}}"
                               href="{{ route('homepage', array('sort' => 'name')) }}">File</a>
                        </th>
                        <th scope="col">
                            <a class="{{request()->query('sort') == '' ? "active-sort" : ""}}"
                               href="{{ route('homepage') }}">Likes</a>
                        </th>
                        <th scope="col">Description</th>
                        <th scope="col">Subject</th>
                        <th scope="col">
                            <a class="{{request()->query('sort') == 'new'? 'active-sort' : ''}}"
                               href="{{ route('homepage', array('sort' => 'new')) }}">Date</a>
                        </th>
                        <th scope="col">
                            <a class="{{request()->query('sort') == 'size'? 'active-sort' : ''}}"
                               href="{{ route('homepage', array('sort' => 'size')) }}">Size</a>
                        </th>
                        <th scope="col">
                            <a class="{{request()->query('sort') == 'owner'? 'active-sort' : ''}}"
                               href="{{ route('homepage', array('sort' => 'owner')) }}">Owner</a>
                        </th>
                        <th scope="col"></th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach ($files as $file)

                        <tr>
                            <th scope="row">{{$files->firstItem() + $loop->index}}</th>
                            <td class="table-text">
                                <a class="me-2" href="{{ route('file.download', [$file]) }}"
                                   aria-label="link to download file">
                                    {{ $file->user_file_name . "." . $file->file_type }}
                                </a>

                                @if(auth()->user()->is_admin)
                                    <form action="{{route('delete.file', [$file])}}" method="POST"
                                          style="display: inline;">
                                        @csrf
                                        {{ method_field('DELETE') }}
                                        <button class="btn btn-default btn-sm" aria-label="delete file"
                                                onclick="return confirm('Are you sure you want to delete this file?')">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                 fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                <path
                                                    d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5
                                                 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3
                                                  .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                                <path fill-rule="evenodd"
                                                      d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1
                                                   1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1
                                                    0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0
                                                     1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                            </svg>
                                        </button>
                                    </form>
                                @endif
                            </td>

                            <td>

                                @if( $file->checkLike($file->likes->where('likeable_id', $file->id)->all()) )
                                    <form class="form-inline" action="{{ route('unlike.file', [$file])}}" method="POST"
                                          style="display: inline;">
                                        @csrf
                                        <button class="btn btn-outline-primary btn-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                 fill="currentColor"
                                                 class="bi bi-hand-thumbs-down" viewBox="0 0 16 16">
                                                <path d="M8.864 15.674c-.956.24-1.843-.484-1.908-1.42-.072-1.05-.23-2.015-.428-2.59-.125-.36-.479-1.012-1.04-1.638-.557-.624-1.282-1.179-2.131-1.41C2.685
                                                 8.432 2 7.85 2 7V3c0-.845.682-1.464 1.448-1.546 1.07-.113 1.564-.415 2.068-.723l.048-.029c.272-.166.578-.349.97-.484C6.931.08
                                                  7.395 0 8 0h3.5c.937 0 1.599.478 1.934 1.064.164.287.254.607.254.913
                                                   0 .152-.023.312-.077.464.201.262.38.577.488.9.11.33.172.762.004 1.15.069.13.12.268.159.403.077.27.113.567.113.856
                                                    0 .289-.036.586-.113.856-.035.12-.08.244-.138.363.394.571.418 1.2.234 1.733-.206.592-.682 1.1-1.2 1.272-.847.283-1.803.276-2.516.211a9.877
                                                     9.877 0 0 1-.443-.05 9.364 9.364 0 0 1-.062 4.51c-.138.508-.55.848-1.012.964l-.261.065zM11.5
                                                      1H8c-.51 0-.863.068-1.14.163-.281.097-.506.229-.776.393l-.04.025c-.555.338-1.198.73-2.49.868-.333.035-.554.29-.554.55V7c0 .255.226.543.62.65 1.095.3
                                                       1.977.997 2.614 1.709.635.71 1.064 1.475 1.238 1.977.243.7.407
                                                        1.768.482 2.85.025.362.36.595.667.518l.262-.065c.16-.04.258-.144.288-.255a8.34
                                                         8.34 0 0 0-.145-4.726.5.5 0 0 1 .595-.643h.003l.014.004.058.013a8.912 8.912
                                                          0 0 0 1.036.157c.663.06 1.457.054 2.11-.163.175-.059.45-.301.57-.651.107-.308.087-.67-.266-1.021L12.793
                                                           7l.353-.354c.043-.042.105-.14.154-.315.048-.167.075-.37.075-.581 0-.211-.027-.414-.075-.581-.05-.174-.111-.273-.154-.315l-.353-.354.353-.354c.047-.047.109-.176.005-.488a2.224
                                                            2.224 0 0 0-.505-.804l-.353-.354.353-.354c.006-.005.041-.05.041-.17a.866.866 0 0 0-.121-.415C12.4 1.272 12.063 1 11.5 1z"/>
                                            </svg>
                                            {{ $file->likeCount }}
                                        </button>
                                    </form>
                                @else
                                    <form class="form-inline" action="{{ route('like.file', [$file]) }}" method="POST"
                                          style="display: inline;">
                                        @csrf
                                        <button class="btn btn-outline-primary btn-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                 fill="currentColor"
                                                 class="bi bi-hand-thumbs-up" viewBox="0 0 16 16">
                                                <path d="M8.864.046C7.908-.193 7.02.53 6.956 1.466c-.072 1.051-.23
                                             2.016-.428 2.59-.125.36-.479 1.013-1.04 1.639-.557.623-1.282 1.178-2.131
                                              1.41C2.685 7.288 2 7.87 2 8.72v4.001c0 .845.682 1.464 1.448 1.545 1.07
                                              .114 1.564.415 2.068.723l.048.03c.272.165.578.348.97.484.397.136.861.217
                                               1.466.217h3.5c.937 0 1.599-.477 1.934-1.064a1.86 1.86 0 0 0
                                                .254-.912c0-.152-.023-.312-.077-.464.201-.263.38-.578.488-.901.11-.33.172-.762.004-1.149.069-.13.12-.269.159-.403.077-.27.113-.568.113-.857 0-.288-.036-.585-.113-.856a2.144 2.144
                                                 0 0 0-.138-.362 1.9 1.9 0 0 0
                                                  .234-1.734c-.206-.592-.682-1.1-1.2-1.272-.847-.282-1.803-.276-2.516-.211a9.84
                                                   9.84 0 0 0-.443.05 9.365 9.365 0 0 0-.062-4.509A1.38 1.38 0 0 0
                                                    9.125.111L8.864.046zM11.5 14.721H8c-.51 0-.863-.069-1.14-.164-.281-.097-.506-.228-.776-.393l-.04-.024c-.555-.339-1.198-.731-2.49-.868-.333-.036-.554-.29-.554-.55V8.72c0-.254.226-.543.62-.65 1.095-.3
                                                     1.977-.996 2.614-1.708.635-.71 1.064-1.475 1.238-1.978.243-.7.407-1.768.482-2.85.025-.362.36-.594.667-.518l.262.066c.16.04.258.143.288.255a8.34
                                                      8.34 0 0 1-.145 4.725.5.5 0 0 0 .595.644l.003-.001.014-.003.058-.014a8.908 8.908 0 0 1 1.036-.157c.663-.06 1.457-.054 2.11.164.175.058.45.3.57.65.107.308.087.67-.266
                                                       1.022l-.353.353.353.354c.043.043.105.141.154.315.048.167.075.37.075.581 0
                                                        .212-.027.414-.075.582-.05.174-.111.272-.154.315l-.353.353.353.354c.047.047.109.177.005.488a2.224
                                                         2.224 0 0 1-.505.805l-.353.353.353.354c.006.005.041.05.041.17a.866.866
                                                          0 0 1-.121.416c-.165.288-.503.56-1.066.56z"/>
                                            </svg>
                                            {{ $file->likeCount }}
                                        </button>

                                    </form>
                                @endif

                            </td>

                            <td class="table-text" style="width: 25%;">
                                <div>{{ $file->description }}</div>
                            </td>

                            <td class="table-text">
                                <div>{{ $file->subject->subject_name}}</div>
                            </td>

                            <td class="table-text">
                                <div>
                                    {{ isset($file->created_at)? \Carbon\Carbon::parse($file->created_at)->format('d.m.Y') : "" }}
                                </div>
                            </td>

                            <td class="table-text">
                                <div>

                                    @if($file->file_size < 1024)
                                        {{$file->file_size}} B
                                    @elseif($file->file_size > 1000000)
                                        {{round($file->file_size / (1024.0*1024.0)) }} MB
                                    @else
                                        {{round($file->file_size / (1024.0)) }} kB
                                    @endif

                                </div>
                            </td>

                            <td class="table-text">
                                <div>{{ $file->user->email }}</div>
                            </td>

                            <td>
                                <a class="d-block text-center mt-2" aria-label="link to file details"
                                   href="{{route('file.details', [$file])}}"> More info </a>
                            </td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div style="width: 200px; height: 200px; margin-left: auto; margin-right: auto;">
                {{ $files->links() }}
            </div>
        </div>
    @else
        <div class="container">
            <div class="alert alert-dark d-flex align-items-center" role="alert">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                     class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img"
                     aria-label="Warning:">
                    <path
                        d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0
                        1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1
                        5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                </svg>
                <div>
                    There are no uploaded public files</a>.
                </div>
            </div>
        </div>
    @endif
@endsection


<script>
    function myFunction() {
        // Declare variables
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("searchByName");
        filter = input.value.toUpperCase();
        table = document.getElementById("filesTable");
        tr = table.getElementsByTagName("tr");

        // Loop through all table rows, and hide those who don't match the search query
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[0];
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }
</script>






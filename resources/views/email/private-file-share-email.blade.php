<h1>Download File Link</h1>

You can download file send from {{$sender_email}} from this link

<a href="{{ route('download.private.file.get', [$file, $receiver_email]) }}">Download link</a>

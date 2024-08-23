@extends('admin.app')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <table class="table table-bordered table-responsive">
                <thead>
                    <tr>
                        <th>To</th>
                        <th>Subject</th>
                        <th>Message</th>
                        <th>File</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($mails as $mail)
                    <tr>
                        <td>{{ $mail->to }}</td>
                        <td>{{ $mail->subject }}</td>
                        <td>
                            <p title="{{ $mail->subject }}">View</p>
                        </td>
                        <td>
                            <img src='/{{$mail->file ? $mail->file : "dummy.jpg"  }}' width="50">
                        </td>
                        <td>
                            <a class="btn btn-primary" href="{{ route('admin.mail.delete', $mail->id) }}">Delete</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
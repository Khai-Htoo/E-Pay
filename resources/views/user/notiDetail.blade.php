@extends('user.Layouts.app')
@section('title', 'Notification Detail')
@section('content')

   <div class="card">
    <a href="{{ route('notification') }}"><i class=" p-3 fas fa-angle-left"></i></a>
    <div class="card-body text-center">
        <img src="{{ asset('img/voting-d.svg') }}" style=" width : 350px ; height : 300px">
        <h5>Title : {{ $notification->data['title'] }}</h5>
        <p>Message : {{ $notification->data['message'] }}</p>
        <p>{{ $notification->created_at->format('j-F-Y (h-s-a)') }}</p>
    </div>
   </div>

@endsection

@section('script')

    <script>
        $(document).ready(function() {

        })
    </script>

@endsection

@extends('user.Layouts.app')
@section('title', 'Notification')
@section('content')

    @foreach ($notification as $noti)
        <a href="{{ route('notiDetail',$noti->id) }}" class=" transaction">
            <div class="card mb-1 @if ($noti->read_at === null ) unread @endif">
                <div class="card-body d-flex justify-content-between">
                   <div class="">
                    <h5>{{ $noti->data['title'] }}</h5>
                   <p>{{ $noti->data['message'] }}</p>
                   <p class=" text-muted">{{ $noti->created_at->format('j-F-Y') }}</p>
                   </div>
                   @if ($noti->read_at === null)
                   <img src="{{ asset('img/circle.svg') }}">
                   @endif
                </div>

            </div>
        </a>
    @endforeach


@endsection

@section('script')

    <script>
        $(document).ready(function() {

        })
    </script>

@endsection

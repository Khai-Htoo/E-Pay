@extends('user.Layouts.app')
@section('title', 'Confirmation')
@section('content')
    <div class="">
        <div class="card">
            <a href="{{ route('userHomePage') }}">
                <i class=" fas fa-angle-left px-3 p-1"></i>
            </a>
            <div class="card-body text-secondary">
                <h5>Name : {{ Auth::user()->name }}</h5>
                <h5 class=" mb-4">Phone : {{ Auth::user()->phone }} </h5>
                <form action="{{ route('completed') }}" method="post" id="submit">
                    @csrf
                    <input type="hidden" value="{{ $hashValue }}" name="hashValue">
                    <div class=" mb-3">
                        <label for="">from :</label>
                        <input type="text" class=" form-control" name="from_phone" disabled
                            value="{{ Auth::user()->phone }}">
                        <input type="hidden" class=" form-control" name="from_phone" value="{{ Auth::user()->phone }}">
                    </div>

                    <div class=" mb-3">
                        <label for="">To :</label>
                        <input type="text" class=" form-control" name="to_phone" disabled value="{{ $to_phone }}">
                        <input type="hidden" class=" form-control" name="to_phone" value="{{ $to_phone }}">
                    </div>

                    <div class=" mb-3">
                        <label for="">Amount (mmk) :</label>
                        <input type="text" class=" form-control" name="amount" disabled value="{{ $amount }}">
                        <input type="hidden" class=" form-control" name="amount" value="{{ $amount }}">
                    </div>

                    <label for="">Note :</label>
                    <textarea name="note" class=" form-control" name="note" disabled>{{ $note }}</textarea>
                    <input type="hidden" class=" form-control" name="note" value="{{ $note }}">
                    <button type="submit" class=" mt-3 btn btn-primary w-100 submitBtn">Continue</button>

                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('.submitBtn').on('click', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: '<small>Enter Your Password</small>',
                    icon: 'info',
                    html: '  <input type="password" class="password form-control" name="passsword">',
                    showCloseButton: true,
                    showCancelButton: true,
                    reverseButtons: true,
                    Button: true,
                    focusConfirm: false,
                    confirmButtonText: 'Comfirm',
                    confirmButtonAriaLabel: 'Thumbs up, great!',
                    cancelButtonText: 'Cancel',
                    cancelButtonAriaLabel: 'Thumbs down'
                }).then((result) => {
                    let password = $('.password').val()
                    $.ajax({
                        type: 'GET',
                        url: 'checkPassword?password=' + password,
                        success: function(res) {
                            if (res.status == 'success') {
                                $('#submit').submit()
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: res.msg,
                                })
                            }
                        }
                    })
                })
            })
            @if (session('fail'))
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: "{{ session('fail') }}"
                })
            @endif
        })
    </script>
@endsection

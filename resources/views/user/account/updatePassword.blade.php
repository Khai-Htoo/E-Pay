@extends('user.Layouts.app')
@section('title', 'Update Password')
@section('content')

    <div class=" updatePassword">
        <div class="card p-3 px-5 mb-5">
            <a href="{{ route('user#account') }}"><i class="fas fa-angle-left"></i></a>
            <div class=" mx-auto">
                <img src="{{ asset('img/password.png') }}" alt="">
            </div>
            <form action="{{ route('account#changePassword') }}" method="post">
                @csrf
                <label for="">Old Password</label>
                <input type="password" class=" form-control @error('oldPassword') is-invilid @enderror my-2"
                    name="oldPassword">
                @error('oldPassword')
                    <strong class=" text-danger">{{ $message }}</strong>
                    <br>
                @enderror

                <label for="">New Password</label>
                <input type="password" class=" form-control @error('newPassword') is-invilid @enderror my-2"
                    name="newPassword">
                @error('newPassword')
                    <strong class=" text-danger">{{ $message }}</strong>
                    <br>
                @enderror

                <label for="">Confirm Password</label>
                <input type="password" class=" form-control @error('confirmPassword') is-invilid @enderror my-2"
                    name="confirmPassword">
                @error('confirmPassword')
                    <strong class=" text-danger">{{ $message }}</strong>
                    <br>
                @enderror

                <button class=" btn btn-primary mt-3 w-100 mb-3">Update Password</button>
            </form>
        </div>
    </div>

@endsection

@section('script')
    <script>
        $(document).ready(function() {
            @if (session('success'))
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })

                Toast.fire({
                    icon: 'success',
                    title: "{{ session('success') }}"
                })
            @endif

            @if (session('fail'))
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: "{{ session('fail') }}",
                })
            @endif
        })
    </script>

@endsection

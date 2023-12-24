@extends('user.Layouts.app')
@section('title', 'User Profile')
@section('content')

    <div class=" account">
        <div class="mb-3 d-flex justify-content-center ">
            <img class=" img-thumbnail" src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}"
                alt="">
        </div>

        <div class=" d-flex justify-content-center">
            <div class="col-md-6">
                <div class="card mb-5 py-3">
                    <div class="card-body">
                        <div class=" row p-2 px-md-5 ">
                            <div class=" d-flex mb-2 ">
                                <h5 style="width: 35%">UserName :</h5>
                                <h5>{{ Auth::user()->name }}</h5>
                            </div>
                            <hr>
                            <div class=" d-flex mb-2 ">
                                <h5 style="width: 35%">Email :</h5>
                                <h5>{{ Auth::user()->email }}</h5>
                            </div>
                            <hr>
                            <div class=" d-flex mb-2 ">
                                <h5 style="width: 35%">Phone :</h5>
                                <h5>{{ Auth::user()->phone }}</h5>
                            </div>
                            <hr>
                            <a href="{{ route('account#updatePassword') }}" class=" d-flex mb-2 justify-content-between">
                                <h5>Change Password</h5>
                                <i class=" fas fa-angle-right"></i>
                            </a>
                            <hr>
                            <div class=" d-flex mb-2 justify-content-between logout">
                                <h5>Logout</h5>
                                <i class=" fas fa-angle-right"></i>
                            </div>
                            <hr>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $(document).on('click', '.logout', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Are you sure Logout?',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Confirm',
                    reverseButtons : true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "POST",
                            url: "{{ route('logout') }}",
                        })
                        window.location.reload();
                    }
                })
            })
        })
    </script>

@endsection

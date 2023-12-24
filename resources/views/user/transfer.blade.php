@extends('user.Layouts.app')
@section('title', 'Transfer')
@section('content')
    <div class="">
        <div class="card">
            <a href="{{ route('userHomePage') }}">
                <i class=" fas fa-angle-left p-3"></i>
            </a>
            <div class="card-body text-secondary">
                <h5>Name : {{ Auth::user()->name }}</h5>
                <h5 class=" mb-4">Phone : {{ Auth::user()->phone }} </h5>
                <form action="{{ url('user/transferConfirm') }}" method="get" class="transfer-form">
                    <input type="hidden" name="hashValue" value="" class="hashValue">
                    <label for="">To Phone: <span class="ShowMsg text-primary"></span></label>
                    <div class="input-group mb-3">
                        <input type="number" value="{{ $toPhone}}" @if ($toPhone) @endif class="form-control to_phone  @error('to_phone') is-invalid @enderror"
                            name="to_phone">
                        <div class="input-group-append">
                            <span class="input-group-text btn btn-primary verifyBtn"><i
                                    class=" fas fa-check-circle "></i></span>
                        </div>
                    </div>
                    @error('to_phone')
                        <strong class=" text-danger">{{ $message }}</strong>
                    @enderror

                    <div class=" mb-3">
                        <label for="">Amount (mmk) :</label>
                        <input type="number" class=" form-control amount @error('amount') is-invalid @enderror" name="amount">
                        @error('amount')
                            <strong class=" text-danger">{{ $message }}</strong>
                        @enderror
                    </div>

                    <label for="">Note :</label>
                    <textarea name="note" class=" form-control note @error('note') is-invalid @enderror"></textarea>
                    @error('note')
                        <strong class=" text-danger">{{ $message }}</strong>
                    @enderror
                    <button class=" mt-3 btn btn-primary w-100 continue-btn">Continue</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {

            $('.continue-btn').on('click',function(e){
                e.preventDefault();
                let to_phone = $('.to_phone').val();
                let amount = $('.amount').val();
                let note = $('.note').val();

                $.ajax({
                    type : "GET",
                    url : `transferHash?to_phone=${to_phone}&amount=${amount}&note=${note}`,
                    success : function(res){
                     if(res.status == 'success'){
                        $('.hashValue').val(res.data)
                        $('.transfer-form').submit();
                     }
                    }
                })

            })

            @if (session('fail'))
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: "{{ session('fail') }}",
                })
            @endif

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

            $('.verifyBtn').on('click', function() {
                let phone = $('.to_phone').val()

                $.ajax({
                    type: 'GET',
                    url: 'verifyPhone?phone=' + phone,
                    success: function(res) {
                        if (res.msg === 'success') {
                            $('.ShowMsg').html(res.user.name)
                        } else if (res.status == '404') {
                            $('.ShowMsg').html(res.msg)
                        } else if (res.status == 'same') {
                            $('.ShowMsg').html(res.msg)
                        }
                    }
                })
            })
        })
    </script>
@endsection

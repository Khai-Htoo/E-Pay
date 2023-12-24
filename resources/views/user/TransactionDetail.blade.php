@extends('user.Layouts.app')
@section('title', 'Transaction Detail')
@section('content')

    <div class=" card">
        <div class="card-header">
            <div class=" text-center">
                <img src="{{ asset('img/transaction.svg') }}" style="width: 100px ; height : 100px" alt=""> <br>
                <h5 class=" mt-3 @if ($t->type === 2) text-danger @endif text-success">
                    @if ($t->type === 2) - @endif
                    @if ($t->type === 1) + @endif
                    {{ $t->amount }} <small>MMK</small></h5>
            </div>
        </div>
        <div class="card-body text-muted">
           <div class=" d-flex justify-content-between">
            <h5>Trx-Id</h5>
            <h5>{{ $t->trx_no }}</h5>
           </div>
           <hr>
           <div class=" d-flex justify-content-between">
            <h5>Ref Number</h5>
            <h5>{{ $t->ref_no }}</h5>
           </div>
           <hr>
           <div class=" d-flex justify-content-between">
            <h5>Type</h5>
            <h5>
                @if ($t->type === 2) <strong class=" text-danger">Expense</strong> @endif
                @if ($t->type === 1) <strong class=" text-success">Expense</strong> @endif
            </h5>
           </div>
           <hr>
           <div class=" d-flex justify-content-between">
            <h5>Date</h5>
            <div class="">
                <h5>{{ $t->created_at->format('j-F-Y') }}</h5>
                <p class=" float-end">{{ $t->created_at->format('h-i-sa') }}</p>
            </div>
           </div>
           <hr>
           <div class=" d-flex justify-content-between">
            <h5>To</h5>
            <h5>{{ $t->source->name }}</h5>
           </div>
           <hr>
           <div class=" d-flex justify-content-between">
            <h5>Note</h5>
            <h5>{{ $t->note }}</h5>
           </div>
           <hr>

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

        })
    </script>
@endsection

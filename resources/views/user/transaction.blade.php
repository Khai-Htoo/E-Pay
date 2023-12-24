@extends('user.Layouts.app')
@section('title', 'Transaction')
@section('content')
    <div class=" d-flex justify-content-between">
        <div class=" mb-2 d-flex align-items-center gap-2">
            <label for="">Type: </label>
            <select class="type form-control" style=" width : 100px">
                <option value="">All</option>
                <option value="1" @if (request()->type == 1) selected @endif>Income</option>
                <option value="2" @if (request()->type == 2) selected @endif>Expense</option>
            </select>
        </div>

        <div class=" d-flex align-items-center" style=" width : 150px">
            <label>Date: </label>
            <input type="text" class=" form-control date" value="{{ request()->date }}" placeholder="All">
        </div>
    </div>
    @foreach ($transaction as $t)
        <a href="{{ route('user#transactionDetail', $t->trx_no) }}" class=" transaction">
            <div class="card mb-1">
                <div class="card-body ">
                    <div class=" d-flex mb-2 justify-content-between">
                        <h6 class=" ">Trx-no: {{ $t->trx_no }}</h6>
                        <strong class=" @if ($t->type === 2) text-danger @endif text-success">
                            @if ($t->type === 2)
                                -
                            @endif
                            @if ($t->type === 1)
                                +
                            @endif
                            {{ $t->amount }} <small>MMK</small>
                        </strong>
                    </div>
                    <p>To:{{ $t->user ? $t->user->name : '' }}</p>
                    <p>From: {{ $t->source ? $t->source->name : '' }}</p>
                </div>
            </div>
        </a>
    @endforeach
    {{-- <div class="">
        {{ $transaction->appends(request()->query())->links() }}
    </div> --}}

@endsection

@section('script')

    <script>
        $(document).ready(function() {
            $('.type').change(function() {
                let date = $('.date').val();
               let type = $('.type').val();
               history.pushState(null,'',`?date=${date}&type=${type}`)
               window.location.reload()
            })

            $('.date').daterangepicker({
                "singleDatePicker": true,
                "autoApply": false,
                "autoUpdateInput" : false,
                "locale": {
                    "format": "YYYY-MM-DD",
                    "separator": " - ",
                },
            })

            $('.date').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('YYYY-MM-DD HH:mm:ss'))
               let date = $('.date').val();
               let type = $('.type').val();
               history.pushState(null,'',`?date=${date}&type=${type}`)
               window.location.reload()
            });

            $('.date').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('')
               let date = $('.date').val();
               let type = $('.type').val();
               history.pushState(null,'',`?date=${date}&type=${type}`)
               window.location.reload()
            });
        })
    </script>

@endsection

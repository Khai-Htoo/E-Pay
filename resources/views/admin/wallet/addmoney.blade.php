@extends('admin.layouts.app')
@section('content')
    <div class=" container-fluid">
        <div class="card text-black mt-3">
            <div class=" card-body">
                <form action="{{ route('addMoneyCreate') }}" method="POST">
                    @csrf
                    <label for="">User</label>
                    <select name="user_id" id="" class=" form-control">
                        @foreach ($user as $u)
                            <option value="{{ $u->id }}">{{ $u->name }}( {{ $u->phone }})</option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <strong class=" text-danger">{{ $message }}</strong>
                    @enderror
                    <label for="">Amount</label>
                    <input type="text" class=" form-control" name="amount">
                    @error('amount')
                        <strong class=" text-danger">{{ $message }}</strong> <br>
                    @enderror
                    <label for="">Note</label>
                    <input type="text" class=" form-control" name="note">
                    @error('note')
                        <strong class=" text-danger">{{ $message }}</strong> <br>
                    @enderror
                    <button class=" btn btn-primary mt-3 " type="submit">Add Money</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {



        })
    </script>
@endsection

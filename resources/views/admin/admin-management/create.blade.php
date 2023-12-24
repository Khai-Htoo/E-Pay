@extends('admin.layouts.app')
@section('content')
    <div class=" container-fluid">
        <div class="card text-black">
            <a href="{{ route('management.index') }}"><i class="fa-solid fa-arrow-left mt-1 ml-2"></i></a>
            <div class=" card-header">Account Edit Page</div>
            <div class=" card-body">
               <form action="{{ route('management.store') }}" method="POST">
                @csrf
                <label for="">Name</label>
                <input type="text" class=" form-control @error('name') is-invalid @enderror" name="name">
                @error('name')
                    <strong class=" text-danger">{{ $message }}</strong> <br>
                @enderror

                <label for="">Email</label>
                <input type="email" class=" form-control @error('email') is-invalid @enderror" name="email">
                @error('email')
                    <strong class=" text-danger">{{ $message }}</strong> <br>
                @enderror

                <label for="">Phone</label>
                <input type="number" class=" form-control @error('phone') is-invalid @enderror" name="phone">
                @error('phone')
                    <strong class=" text-danger">{{ $message }}</strong> <br>
                @enderror

                <label for="">Password</label>
                <input type="text" class=" form-control @error('password') is-invalid @enderror" name="password">
                @error('password')
                    <strong class=" text-danger">{{ $message }}</strong> <br>
                @enderror

                <button class=" btn btn-sm btn-primary mt-3">Create <i class=" fa fa-plus-circle"></i> </button>
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

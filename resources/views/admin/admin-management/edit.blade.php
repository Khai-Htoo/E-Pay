@extends('admin.layouts.app')
@section('content')
    <div class=" container-fluid">
        <div class="card text-black">
            <a href="{{ route('management.index') }}"><i class="fa-solid fa-arrow-left mt-1 ml-2"></i></a>
            <div class=" card-header">Account Edit Page</div>
            <div class=" card-body">
               <form action="{{ route('management.update',$user->id) }}" method="POST">
                @csrf
                @method('PUT')
                <label for="">Name</label>
                <input type="text" class=" form-control @error('name') is-invalid @enderror" name="name" value="{{ $user->name }}">
                @error('name')
                    <strong class=" text-danger">{{ $message }}</strong> <br>
                @enderror

                <label for="">Email</label>
                <input type="email" class=" form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email }}">
                @error('email')
                    <strong class=" text-danger">{{ $message }}</strong> <br>
                @enderror

                <label for="">Phone</label>
                <input type="number" class=" form-control @error('phone') is-invalid @enderror" name="phone" value="{{ $user->phone }}">
                @error('phone')
                    <strong class=" text-danger">{{ $message }}</strong> <br>
                @enderror

                <input type="hidden" class=" form-control @error('password') is-invalid @enderror" name="password" value="{{ $user->password }}">
                @error('password')
                    <strong class=" text-danger">{{ $message }}</strong> <br>
                @enderror

                <button class=" btn btn-sm btn-primary mt-3">Update <i class=" fa fa-plus-circle"></i> </button>
               </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>


    </script>
@endsection

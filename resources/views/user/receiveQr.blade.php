@extends('user.Layouts.app')
@section('title','User Wallet')
@section('content')
   <div class=" card">
    <div class="card-body">
     <div class=" text-center">
      <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(300)->generate(Auth::user()->phone)) !!} ">
      <h1>{{ Auth::user()->phone }}</h1>
      <p>{{ Auth::user()->wallet->amount }}MMK</p>
     </div>
    </div>
   </div>
@endsection

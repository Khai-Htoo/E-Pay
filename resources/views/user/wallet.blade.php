@extends('user.Layouts.app')
@section('title','User Wallet')
@section('content')
   <div class="card wallet">
    <div class="card-body p-3 px-5 ">
        <span>Name</span>
        <h4 class=" mb-3 mt-2" >{{ Auth::user()->name}}</h4>
       <span>Balance</span>
       <h4 class=" mb-3 mt-2">{{ number_format(Auth::user()->wallet->amount,2) }}MMK</h4>
       <span>Account-Number</span>
       <h4 class=" mt-2">{{ Auth::user()->wallet->account_number  }}</h4>
    </div>
   </div>
@endsection

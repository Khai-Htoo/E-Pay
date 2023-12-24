@extends('user.Layouts.app')
@section('title','E-pay')
@section('content')
   <div class="home">
    <div class=" d-flex justify-content-center home-pp">
        <div class=" text-center">
            <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}" class=" img-thumbnail" alt="">
            <h3 class=" mt-1">{{ Auth::user()->name }}</h3>
            <h5 class=" text-secondary">{{ number_format(Auth::user()->wallet->amount,2) }} mmk</h5>
        </div>
    </div>
    <div class=" row qr mt-3">
        <div class="col-6">
            <a href="{{ route('scanQr') }}">
                <div class="card">
                    <div class="card-body">
                      <div class=" d-flex align-items-center gap-3">
                        <img src="{{ asset('img/qr-code-scan.png') }}" alt="">
                        <h5>Scan & Pay</h5>
                      </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-6 ">
            <a href="{{ route('receiveQr') }}">
                <div class="card">
                    <div class="card-body">
                     <div class=" d-flex align-items-center gap-3">
                        <img src="{{ asset('img/qr-code.png') }}" alt="">
                        <h5>Receive QR</h5>
                     </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class=" mt-3 ">
        <div class="card">
            <div class="card-body">
               <a href="{{ route('user#transfer') }}" class=" d-flex align-items-center justify-content-between">
                <h5>Transfer</h5>
                <i class=" fas fa-angle-right"></i>
               </a>
               <hr>
               <a href="{{ route('user#wallet') }}" class=" d-flex align-items-center justify-content-between">
                <h5>Wallet</h5>
                <i class=" fas fa-angle-right"></i>
               </a>
               <hr>
               <a href="{{ route('user#transaction') }}" class=" d-flex align-items-center justify-content-between">
                <h5>Transaction</h5>
                <i class=" fas fa-angle-right"></i>
               </a>
            </div>
        </div>
    </div>
   </div>
@endsection

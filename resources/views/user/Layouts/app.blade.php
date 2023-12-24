<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    {{-- bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    {{-- font awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    {{-- custom --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <title>Wallet</title>
</head>

<body>

   <div>
    <div class="header-menu">
        <div class=" row d-felx justify-content-center align-items-center">
            <div class="col-md-8 py-2">
                <div class="d-flex justify-content-center mb-0 ">
                    <div class="col-2">
                        <a href="" class=" text-black">

                        </a>
                    </div>
                    <div class="col-8 text-center">
                        <a href="" class=" text-secondary">
                            <p class=" mb-0 ">@yield('title')</p>
                        </a>
                    </div>
                    <div class="col-2 d-flex">
                        <a href="{{ route('notification') }}" class=" text-secondary">
                            <i class="fas fa-bell mt-2"></i>
                        </a>
                        <small class=" text-danger">{{ $count }}</small>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="content">
        <div class="row d-flex justify-content-center p-2">
            <div class=" col-md-8">
                @yield('content')
            </div>
        </div>
    </div>


    <div class="bottom-menu">
       <a href="{{ route('scanQr') }}" class="scanTab">
        <div class=" inside">
            <i class=" fas fa-qrcode"></i>
        </div>
       </a>
        <div class="row d-felx justify-content-center py-2">
            <div class="col-md-8 p-1">
                <div class="d-flex mb-0 text-center ">
                    <div class="col-3">
                        <a href="{{ route('userHomePage') }}" class=" text-secondary">
                            <i class="fas fa-home mb-0"></i>
                            <p class=" mb-0">Home</p>
                        </a>
                    </div>
                    <div class="col-3">
                        <a href="{{ route('user#wallet') }}" class=" text-secondary">
                            <i class="fas fa-wallet mb-0"></i>
                            <p class=" mb-0">Wallet</p>
                        </a>
                    </div>
                    <div class="col-3">
                        <a href="{{ route('user#transaction') }}" class=" text-secondary">
                            <i class="fas fa-exchange mb-0"></i>
                            <p class=" mb-0">Transaction</p>
                        </a>
                    </div>
                    <div class="col-3">
                        <a href="{{ route('user#account') }}" class=" text-secondary">
                            <i class="fas fa-user mb-0"></i>
                            <p class=" mb-0">Profile</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

   </div>

</body>
    {{-- sweet alert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- jquery --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
{{-- bootstrap js --}}
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js"
    integrity="sha384-Rx+T1VzGupg4BHQYs2gCW9It+akI2MM/mndMCy36UVfodzcJcF0GGLxZIzObiEfa" crossorigin="anonymous">
</script>
{{-- date range --}}
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>


@yield('script')
<script>
    $(document).ready(function(){
        let token = document.head.querySelector('meta[name="csrf-token"]')
            if (token) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': token.content
                    }
                });
            }
    })
</script>

</html>

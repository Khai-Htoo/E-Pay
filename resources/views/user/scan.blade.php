@extends('user.Layouts.app')
@section('title', 'User Wallet')
@section('content')
    <div class=" card">
        <div class="card-body">
            <div class=" text-center">
                <img src="{{ asset('img/scan.svg') }}" style=" width:330px ; height :300px" alt=""> <br>
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    scan and QRpay

                </button>

                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Scan & Qr Pay</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <video id="scan" style="width: 300px ; heught : 300px"></video>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" id="close"
                                    data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('user/qr-scanner.umd.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            let videoElem = document.getElementById('scan')
            const qrScanner = new QrScanner(
                videoElem,
                function(result) {
                    if (result) {
                        qrScanner.stop();
                        let to_phone = result
                        window.location.replace(`transfer${to_phone? `?to_phone=${to_phone}` : ''}`);
                    }
                },
            );
            $('#exampleModal').on('shown.bs.modal', function(event) {
                qrScanner.start();
            })

            $('#exampleModal').on('hidden.bs.modal', function(event) {
                qrScanner.stop();
            })

            @if (session('fail'))
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: "{{ session('fail') }}",
                })
            @endif
        })
    </script>
@endsection

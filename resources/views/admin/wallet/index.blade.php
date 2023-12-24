@extends('admin.layouts.app')
@section('content')
    <div class=" container-fluid">
       <a href="{{ route('addMoney') }}">
        <button class=" btn btn-primary">Add Money <i class=" fas fa-plus-circle"></i></button>
       </a>
        <div class="card text-black mt-3">
            <div class=" card-body">

                <table class="display datatable table table-bordered" style="width:100%">
                    <thead>
                        {{-- hello --}}
                        <tr>
                            <th>Account Number</th>
                            <th>Account person</th>
                            <th>Amount(MMK)</th>
                            <th>Created_at</th>
                            <th>Updated_at</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {

            $('.datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '/admin/wallet/dataTable/ssd',
                columns: [{
                        data: "account_number",
                        name: "account_number"
                    },
                    {
                        data: "account_person",
                        name: "account_person"
                    },
                    {
                        data: "amount",
                        name: "amount"
                    },
                    {
                        data: "created_at",
                        name: "created_at"
                    },
                    {
                        data: "updated_at",
                        name: "updated_at"
                    }
                ],
                order: [
                    [4, "desc"]
                ]
            })

        })
    </script>
@endsection

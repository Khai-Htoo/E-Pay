@extends('admin.layouts.app')
@section('content')
    <div class=" container-fluid">
        <a href="{{ route('management.create') }}">
            <button class=" btn btn-sm btn-primary mb-3">Create New Account <i class=" fa fa-plus"></i></button>
        </a>
        <div class="card text-black">
            <div class=" card-body">
                <table class="display datatable table table-striped" style="width:100%">
                    <thead>
                        {{-- hello --}}
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Role</th>
                            <th>Created_at</th>
                            <th>Action</th>
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
                ajax: '/admin/dataTable/ssd',
                columns: [{
                        data: "name",
                        name: "name"
                    },
                    {
                        data: "email",
                        name: "email",
                    },
                    {
                        data: "phone",
                        name: "phone"
                    },
                    {
                        data: "created_at",
                        name: "created_at"
                    },
                    {
                        data: "role",
                        name: "role"
                    },
                    {
                        data: "action",
                        name: "action"
                    },
                ],
                order : [
                    [ 3,'desc']
                ]
            })

            @if (session('create'))
                // sweet alert
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })

                Toast.fire({
                    icon: 'success',
                    title: "{{ session('create') }}"
                })
            @endif

            @if (session('update'))
                // sweet alert
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })

                Toast.fire({
                    icon: 'success',
                    title: "{{ session('update') }}"
                })
            @endif

            @if (session('delete'))
                // sweet alert
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })

                Toast.fire({
                    icon: 'success',
                    title: "{{ session('delete') }}"
                })
            @endif



        })
    </script>
@endsection

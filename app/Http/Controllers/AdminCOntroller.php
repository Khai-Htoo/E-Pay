<?php

namespace App\Http\Controllers;

use App\Helper\CodeGenerate;
use App\Models\User;
use App\Models\wallet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class AdminCOntroller extends Controller
{

    public function index()
    {
        return view('admin.admin-management.index');
    }

    // dataTable
    public function ssd()
    {
        $data = User::all();
        return DataTables::of($data)
            ->editColumn('created_at', function ($each) {
                return Carbon::parse($each->created_at)->format('j-F-Y');
            })
            ->addColumn('action', function ($each) {
                $editIcon = '<a href=" ' . route('management.edit', $each->id) . ' " class=" btn btn-sm btn-info mx-3"> <i class=" fas fa-edit"></i> </a>';
                $deleteIcon = '<a href=" ' . route('admin#delete', $each->id) . ' "  class=" btn btn-sm btn-danger delete"><i class=" fas fa-trash"></i></a>';

                return $editIcon . $deleteIcon;
            })
            ->make(true);
    }


    public function create()
    {
        return view('admin.admin-management.create');
    }


    public function store(Request $request)
    {
        $data = $this->userData($request);
        $this->validateData($request);
        $user = User::create($data);
        wallet::firstOrCreate(
            [
                'user_id' => $user->id,
            ],
            [
                'account_number' => CodeGenerate::accountNumber()  ,
                'amount' => 0,
            ]
        );
        return redirect()->route('management.index')->with(['create' => "Account create success"]);
    }

    public function delete(string $id)
    {
        User::where('id', $id)->delete();
        return back()->with(['delete' => 'Account Delete Success']);
    }

    public function edit(string $id)
    {
        $user = User::where('id', $id)->first();
        return view('admin.admin-management.edit', compact('user'));
    }


    public function update(Request $request, string $id)
    {
        $this->validateUpdateData($request, $id);
        $data = $this->userData($request);
        User::where('id', $id)->update($data);
        return redirect()->route('management.index')->with(['update' => 'Account updated success']);
    }

    // data for create
    private function userData($request)
    {
        return [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ];
    }

    // validation for create
    private function validateData($request)
    {
        Validator::make($request->all(), [
            'name' => 'required|min:4',
            'email' => 'required|unique:users,email',
            'phone' => 'required|unique:users,phone',
        ])->validate();
    }

    // validation for create
    private function validateUpdateData($request, $id)
    {
        Validator::make($request->all(), [
            'name' => 'required|min:4',
            'email' => 'required|unique:users,email,' . $id,
            'phone' => 'required|unique:users,phone,' . $id,
            'password' => 'required|min:6',
        ])->validate();
    }
}

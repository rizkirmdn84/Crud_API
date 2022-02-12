<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Company;
use Illuminate\Support\Facades\Validator;

// use Datatables;

class CrudController extends Controller
{
    public function index()
    {
        $count = Company::count();
        $data = Company::orderBy('id', 'desc')->paginate($count)->toArray();

        $no = count($data['data']);
        $i = $no;

        foreach ($data['data'] as $index => $value) {
            $data['data'][$index]['no'] = ($no - $i--) + 1;
        }

        return response()->json($data);
    }

    public function all()
    {
        $data = Company::orderBy('id', 'desc')->get()->toArray();

        $no = count($data);
        $i = $no;

        $number = [];

        foreach ($data as $index => $value) {
            $data[$index]['no'] = ($no - $i--) + 1;
        }

        return response()->json($data);
    }

    public function store(Request $request)
    {
        $field = [
            'id' => $request->id,
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
        ];

        $rules = [
            'id' => 'nullable',
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required|unique:companies,phone,' . $request->id,
            'email' => 'required|email|unique:companies,email,' . $request->id,
        ];

        $messages = [
            'id.required' => 'ID tidak boleh kosong',
            'name.required' => 'Nama tidak boleh kosong',
            'address.required' => 'Alamat tidak boleh kosong',
            'phone.required' => 'Nomor Telepon tidak boleh kosong',
            'phone.unique' => 'Nomor Telepon sudah terdaftar',
            'email.required' => 'Email tidak boleh kosong',
            'email.email' => 'Email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
        ];

        $validator = Validator::make($field, $rules, $messages);

        if ($validator->fails())
            return response()->json(['errors' => $validator->errors()]);

        $company   = Company::updateOrCreate(
            [
                'id' => $request->id
            ],
            [
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address
            ]
        );

        return Response()->json($company);
    }

    public function import(Request $request)
    {
        $companies = $request->data;

        $fields = [
            'companies' => $companies,
        ];

        $rules = [
            'companies.*.name' => 'required',
            'companies.*.address' => 'required',
        ];

        $messages = [];

        foreach ($companies as $index => $val) {
            $row = $index + 1;

            $messages[sprintf('companies.%s.name.required', $index)] = sprintf('Nama pada excel baris ke %s wajib diisi.', $row);
            $messages[sprintf('companies.%s.email.required', $index)] = sprintf('Email pada excel baris ke %s tidak valid.', $row);
        }

        $validator = Validator::make($fields, $rules, $messages);

        if ($validator->fails())
            return response()->json(['errors' => $validator->errors()]);

        foreach ($companies as $company) {
            $company = Company::updateOrCreate(
                [
                    'id' => $company['id']
                ],
                [
                    'name' => $company['name'],
                    'email' => $company['email'],
                    'phone' => $company['phone'],
                    'address' => $company['address'],
                    'created_at' => $company['created_at'],
                    'updated_at' => $company['updated_at'],
                ]
            );
        }
    }

    public function edit(Request $request)
    {
        $where = array('id' => $request->id);
        $company = Company::where($where)->first();

        return Response()->json($company);
    }

    public function destroy(Request $request)
    {
        $company = Company::where('id', $request->id)->delete();

        return Response()->json($company);
    }
}

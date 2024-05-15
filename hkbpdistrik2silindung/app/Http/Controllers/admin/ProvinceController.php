<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProvinceController extends Controller
{
    protected $rules = [
        'prov_name' => 'required',
        'locationid' => 'required'
    ];

    protected $messages = [
        'prov_name.required' => 'Province name field is required.',
        'locationid.required' => 'Location ID field is required.'
    ];

    public function index()
    {
        $provinces = DB::select('CALL viewAll_Province()');
        return view('admin.PengaturanDanKonfigurasi.Province.index', compact('provinces'));
    }

    public function create()
    {
        return view('admin.PengaturanDanKonfigurasi.Province.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules, $this->messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $province = json_encode([
            'prov_name' => $request->prov_name,
            'locationid' => $request->locationid
        ]);

        DB::statement('CALL insert_province(?)', [$province]);

        return redirect()->route('Province.index')->with('success', 'Province added successfully!');
    }

    public function edit($id)
    {
        $province = DB::select('CALL view_Province_byId(?)', [$id]);

        if (empty($province)) {
            return redirect()->route('Province.index')->with('error', 'Province not found!');
        }

        $province = $province[0];
        return view('admin.PengaturanDanKonfigurasi.Province.edit', compact('province'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), $this->rules, $this->messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $province = json_encode([
            'prov_id' => $id,
            'prov_name' => $request->prov_name,
            'locationid' => $request->locationid
        ]);

        DB::statement('CALL update_province(?)', [$province]);

        return redirect()->route('Province.index')->with('success', 'Province updated successfully!');
    }

    public function delete(Request $request)
    {
        $id = $request->id;

        $province = DB::select('CALL view_Province_byId(?)', [$id]);

        if (empty($province)) {
            return response()->json([
                'status' => 404,
                'message' => 'Province not found.'
            ]);
        }

        DB::statement('CALL delete_province(?)', [$id]);

        return response()->json([
            'status' => 200,
            'message' => 'Province deleted successfully.'
        ]);
    }

    public function detail(Request $request)
    {
        $id = $request->id;

        $provinceData = DB::select('CALL view_Province_byId(?)', [$id]);

        if (!empty($provinceData)) {
            $province = $provinceData[0];
            return response()->json([
                'status' => 200,
                'province' => $province
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Province data not found.'
            ]);
        }
    }
}


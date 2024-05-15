<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DistrikController extends Controller
{
    protected $rules = [
        'subdis_id' => 'required|exists:subdistricts,subdis_id',
        'kode_distrik' => 'required',
        'nama_distrik' => 'required',
        'alamat' => 'required',
        'nama_praeses' => 'required',
    ];

    protected $messages = [
        'subdis_id.required' => 'Subdistrict ID field is required.',
        'kode_distrik.required' => 'District Code field is required.',
        'nama_distrik.required' => 'District Name field is required.',
        'alamat.required' => 'Address field is required.',
        'nama_praeses.required' => 'Praeses Name field is required.',
    ];

    public function index()
    {
        $distriks = DB::select('CALL viewAll_Distrik()');
        return view('admin.PengaturanDanKonfigurasi.Distrik.index', compact('distriks'));
    }

    public function create()
    {
        $subdistricts = DB::select('CALL viewAll_Subdistricts()');
        return view('admin.PengaturanDanKonfigurasi.Distrik.create', compact('subdistricts'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules, $this->messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $distrik = json_encode([
            'subdis_id' => $request->subdis_id,
            'kode_distrik' => $request->kode_distrik,
            'nama_distrik' => $request->nama_distrik,
            'alamat' => $request->alamat,
            'nama_praeses' => $request->nama_praeses,
        ]);

        DB::statement('CALL insert_distrik(?)', [$distrik]);

        return redirect()->route('Distrik.index')->with('success', 'Distrik added successfully!');
    }

    public function edit($id)
    {
        $distrik = DB::select('CALL view_Distrik_byId(?)', [$id]);

        if (empty($distrik)) {
            return redirect()->route('Distrik.index')->with('error', 'Distrik not found!');
        }

        $distrik = $distrik[0];
        $subdistricts = DB::select('CALL viewAll_Subdistricts()');
        return view('admin.PengaturanDanKonfigurasi.Distrik.edit', compact('distrik', 'subdistricts'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), $this->rules, $this->messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $distrik = json_encode([
            'id_distrik' => $id,
            'subdis_id' => $request->subdis_id,
            'kode_distrik' => $request->kode_distrik,
            'nama_distrik' => $request->nama_distrik,
            'alamat' => $request->alamat,
            'nama_praeses' => $request->nama_praeses,
        ]);

        DB::statement('CALL update_distrik(?)', [$distrik]);

        return redirect()->route('Distrik.index')->with('success', 'Distrik updated successfully!');
    }

    public function delete(Request $request)
    {
        $id = $request->id;

        $distrik = DB::select('CALL view_Distrik_byId(?)', [$id]);

        if (empty($distrik)) {
            return response()->json([
                'status' => 404,
                'message' => 'Distrik not found.'
            ]);
        }

        DB::statement('CALL delete_distrik(?)', [$id]);

        return response()->json([
            'status' => 200,
            'message' => 'Distrik deleted successfully.'
        ]);
    }

    public function detail(Request $request)
    {
        $id = $request->id;

        $distrikData = DB::select('CALL view_Distrik_byId(?)', [$id]);

        if (!empty($distrikData)) {
            $distrik = $distrikData[0];
            return response()->json([
                'status' => 200,
                'distrik' => $distrik
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Distrik data not found.'
            ]);
        }
    }
}

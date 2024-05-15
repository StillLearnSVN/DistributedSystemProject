<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DetailPindahController extends Controller
{
    protected $rules = [
        'id_jemaat' => 'required',
        'keterangan' => 'nullable'
    ];

    protected $messages = [
        'id_jemaat.required' => 'ID Jemaat field is required.'
        // 'keterangan.required' => 'Keterangan field is required.' // You may not need this if keterangan is nullable
    ];

    public function index()
    {
        $detailPindahs = DB::select('CALL viewAll_DetailPindah()');
        return view('admin.Administrasi.DetailPindah.index', compact('detailPindahs'));
    }

    public function create()
    {
        $jemaats = DB::select('CALL viewAll_Jemaat()');
        return view('admin.Administrasi.DetailPindah.create', compact('jemaats'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules, $this->messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $detailPindah = json_encode([
            'id_jemaat' => $request->id_jemaat,
            'keterangan' => $request->keterangan
        ]);

        DB::statement('CALL insert_detail_pindah(?)', [$detailPindah]);

        return redirect()->route('DetailPindah.index')->with('success', 'Detail Pindah added successfully!');
    }

    public function edit($id)
    {
        $detailPindah = DB::select('CALL view_DetailPindah_byId(?)', [$id]);

        if (empty($detailPindah)) {
            return redirect()->route('DetailPindah.index')->with('error', 'Detail Pindah not found!');
        }

        $detailPindah = $detailPindah[0];
        $jemaats = DB::select('CALL viewAll_Jemaat()');
        return view('admin.Administrasi.DetailPindah.edit', compact('detailPindah', 'jemaats'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), $this->rules, $this->messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $detailPindah = json_encode([
            'id_det_reg_pindah' => $id,
            'id_jemaat' => $request->id_jemaat,
            'keterangan' => $request->keterangan
        ]);

        DB::statement('CALL update_detail_pindah(?)', [$detailPindah]);

        return redirect()->route('DetailPindah.index')->with('success', 'Detail Pindah updated successfully!');
    }

    public function delete(Request $request)
    {
        $id = $request->id;

        $detailPindah = DB::select('CALL view_DetailPindah_byId(?)', [$id]);

        if (empty($detailPindah)) {
            return response()->json([
                'status' => 404,
                'message' => 'Detail Pindah not found.'
            ]);
        }

        DB::statement('CALL delete_detail_pindah(?)', [$id]);

        return response()->json([
            'status' => 200,
            'message' => 'Detail Pindah deleted successfully.'
        ]);
    }

    public function detail(Request $request)
    {
        $id = $request->id;

        $detailPindahData = DB::select('CALL view_DetailPindah_byId(?)', [$id]);

        if (!empty($detailPindahData)) {
            $detailPindah = $detailPindahData[0];
            return response()->json([
                'status' => 200,
                'detail_pindah' => $detailPindah
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Data Detail Pindah Tidak Ditemukan.'
            ]);
        }
    }
}

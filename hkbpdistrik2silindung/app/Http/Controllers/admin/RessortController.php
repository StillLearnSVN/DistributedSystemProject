<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RessortController extends Controller
{
    protected $rules = [
        'id_distrik' => 'required|exists:distrik,id_distrik',
        'subdis_id' => 'required|exists:subdistricts,subdis_id',
        'kode_ressort' => 'required',
        'nama_ressort' => 'required',
        'alamat' => 'required',
        'pendeta_ressort' => 'required',
        'tgl_berdiri' => 'required|date',
    ];

    protected $messages = [
        'id_distrik.required' => 'District ID field is required.',
        'id_distrik.exists' => 'District ID does not exist.',
        'subdis_id.required' => 'Subdistrict ID field is required.',
        'subdis_id.exists' => 'Subdistrict ID does not exist.',
        'kode_ressort.required' => 'Ressort Code field is required.',
        'nama_ressort.required' => 'Ressort Name field is required.',
        'alamat.required' => 'Address field is required.',
        'pendeta_ressort.required' => 'Pendeta Ressort field is required.',
        'tgl_berdiri.required' => 'Tanggal Berdiri field is required.',
        'tgl_berdiri.date' => 'Tanggal Berdiri must be a valid date.',
    ];

    public function index()
    {
        $ressorts = DB::select('CALL viewAll_Ressort()');
        return view('admin.PengaturanDanKonfigurasi.Ressort.index', compact('ressorts'));
    }

    public function create()
    {
        $distriks = DB::select('CALL viewAll_Distrik()');
        $subdistricts = DB::select('CALL viewAll_Subdistricts()');
        return view('admin.PengaturanDanKonfigurasi.Ressort.create', compact('distriks', 'subdistricts'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules, $this->messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $ressort = json_encode([
            'id_distrik' => $request->id_distrik,
            'subdis_id' => $request->subdis_id,
            'kode_ressort' => $request->kode_ressort,
            'nama_ressort' => $request->nama_ressort,
            'alamat' => $request->alamat,
            'pendeta_ressort' => $request->pendeta_ressort,
            'tgl_berdiri' => $request->tgl_berdiri,
        ]);

        DB::statement('CALL insert_ressort(?)', [$ressort]);

        return redirect()->route('Ressort.index')->with('success', 'Ressort added successfully!');
    }

    public function edit($id)
    {
        $ressort = DB::select('CALL view_Ressort_byId(?)', [$id]);

        if (empty($ressort)) {
            return redirect()->route('Ressort.index')->with('error', 'Ressort not found!');
        }

        $ressort = $ressort[0];
        $distriks = DB::select('CALL viewAll_Distrik()');
        $subdistricts = DB::select('CALL viewAll_Subdistricts()');
        return view('admin.PengaturanDanKonfigurasi.Ressort.edit', compact('ressort', 'distriks', 'subdistricts'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), $this->rules, $this->messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $ressort = json_encode([
            'id_ressort' => $id,
            'id_distrik' => $request->id_distrik,
            'subdis_id' => $request->subdis_id,
            'kode_ressort' => $request->kode_ressort,
            'nama_ressort' => $request->nama_ressort,
            'alamat' => $request->alamat,
            'pendeta_ressort' => $request->pendeta_ressort,
            'tgl_berdiri' => $request->tgl_berdiri,
        ]);

        DB::statement('CALL update_ressort(?)', [$ressort]);

        return redirect()->route('Ressort.index')->with('success', 'Ressort updated successfully!');
    }

    public function delete(Request $request)
    {
        $id = $request->id;

        $ressort = DB::select('CALL view_Ressort_byId(?)', [$id]);

        if (empty($ressort)) {
            return response()->json([
                'status' => 404,
                'message' => 'Ressort not found.'
            ]);
        }

        DB::statement('CALL delete_ressort(?)', [$id]);

        return response()->json([
            'status' => 200,
            'message' => 'Ressort deleted successfully.'
        ]);
    }

    public function detail(Request $request)
    {
        $id = $request->id;

        $ressortData = DB::select('CALL view_Ressort_byId(?)', [$id]);

        if (!empty($ressortData)) {
            $ressort = $ressortData[0];
            return response()->json([
                'status' => 200,
                'ressort' => $ressort
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Ressort data not found.'
            ]);
        }
    }
}

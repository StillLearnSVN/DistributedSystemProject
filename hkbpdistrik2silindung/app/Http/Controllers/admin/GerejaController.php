<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class GerejaController extends Controller
{
    protected $rules = [
        'id_ressort' => 'required|exists:ressort,id_ressort',
        'id_jenis_gereja' => 'required|exists:jenis_gereja,id_jenis_gereja',
        'kode_gereja' => 'required',
        'nama_gereja' => 'required',
        'alamat' => 'required',
        'subdis_id' => 'required|exists:subdistricts,subdis_id',
        'nama_pendeta' => 'required',
        'tgl_berdiri' => 'required|date',
    ];

    protected $messages = [
        'id_ressort.required' => 'Ressort ID field is required.',
        'id_ressort.exists' => 'Ressort ID does not exist.',
        'id_jenis_gereja.required' => 'Jenis Gereja ID field is required.',
        'id_jenis_gereja.exists' => 'Jenis Gereja ID does not exist.',
        'kode_gereja.required' => 'Gereja Code field is required.',
        'nama_gereja.required' => 'Gereja Name field is required.',
        'alamat.required' => 'Address field is required.',
        'subdis_id.required' => 'Subdistrict ID field is required.',
        'subdis_id.exists' => 'Subdistrict ID does not exist.',
        'nama_pendeta.required' => 'Nama Pendeta field is required.',
        'tgl_berdiri.required' => 'Tanggal Berdiri field is required.',
        'tgl_berdiri.date' => 'Tanggal Berdiri must be a valid date.',
    ];

    public function index()
    {
        $gerejas = DB::select('CALL viewAll_Gereja()');
        return view('admin.PengaturanDanKonfigurasi.Gereja.index', compact('gerejas'));
    }

    public function create()
    {
        $ressorts = DB::select('CALL viewAll_Ressort()');
        $jenisGerejas = DB::select('CALL viewAll_JenisGereja()');
        $subdistricts = DB::select('CALL viewAll_Subdistricts()');
        return view('admin.PengaturanDanKonfigurasi.Gereja.create', compact('ressorts', 'jenisGerejas', 'subdistricts'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules, $this->messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $gereja = json_encode([
            'id_ressort' => $request->id_ressort,
            'id_jenis_gereja' => $request->id_jenis_gereja,
            'kode_gereja' => $request->kode_gereja,
            'nama_gereja' => $request->nama_gereja,
            'alamat' => $request->alamat,
            'subdis_id' => $request->subdis_id,
            'nama_pendeta' => $request->nama_pendeta,
            'tgl_berdiri' => $request->tgl_berdiri,
        ]);

        DB::statement('CALL insert_gereja(?)', [$gereja]);

        return redirect()->route('Gereja.index')->with('success', 'Gereja added successfully!');
    }

    public function edit($id)
    {
        $gereja = DB::select('CALL view_Gereja_byId(?)', [$id]);

        if (empty($gereja)) {
            return redirect()->route('Gereja.index')->with('error', 'Gereja not found!');
        }

        $gereja = $gereja[0];
        $ressorts = DB::select('CALL viewAll_Ressort()');
        $jenisGerejas = DB::select('CALL viewAll_JenisGereja()');
        $subdistricts = DB::select('SELECT * FROM subdistricts');
        return view('admin.PengaturanDanKonfigurasi.Gereja.edit', compact('gereja', 'ressorts', 'jenisGerejas', 'subdistricts'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), $this->rules, $this->messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $gereja = json_encode([
            'id_gereja' => $id,
            'id_ressort' => $request->id_ressort,
            'id_jenis_gereja' => $request->id_jenis_gereja,
            'kode_gereja' => $request->kode_gereja,
            'nama_gereja' => $request->nama_gereja,
            'alamat' => $request->alamat,
            'subdis_id' => $request->subdis_id,
            'nama_pendeta' => $request->nama_pendeta,
            'tgl_berdiri' => $request->tgl_berdiri,
        ]);

        DB::statement('CALL update_gereja(?)', [$gereja]);

        return redirect()->route('Gereja.index')->with('success', 'Gereja updated successfully!');
    }

    public function delete(Request $request)
    {
        $id = $request->id;

        $gereja = DB::select('CALL view_Gereja_byId(?)', [$id]);

        if (empty($gereja)) {
            return response()->json([
                'status' => 404,
                'message' => 'Gereja not found.'
            ]);
        }

        DB::statement('CALL delete_gereja(?)', [$id]);

        return response()->json([
            'status' => 200,
            'message' => 'Gereja deleted successfully.'
        ]);
    }

    public function detail(Request $request)
    {
        $id = $request->id;

        $gerejaData = DB::select('CALL view_Gereja_byId(?)', [$id]);

        if (!empty($gerejaData)) {
            $gereja = $gerejaData[0];
            return response()->json([
                'status' => 200,
                'gereja' => $gereja
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Gereja data not found.'
            ]);
        }
    }
}

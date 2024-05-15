<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PelayanNonTahbisanController extends Controller
{
    protected $rules = [
        'id_majelis' => 'required|exists:majelis,id_majelis',
        'id_pelayan_gereja' => 'required|exists:pelayan_gereja,id_pelayan_gereja',
        'id_gereja' => 'required|exists:gereja,id_gereja',
        'id_status_pelayanan' => 'required|exists:status,id_status',
        'nama_pelayanan_nonTahbisan' => 'required|string|max:100',
        'tgl_pengangkatan' => 'required|date',
        'tgl_berakhir' => 'required|date',
        'keterangan' => 'nullable|string|max:255',
    ];

    protected $messages = [
        'id_majelis.required' => 'Majelis ID field is required.',
        'id_majelis.exists' => 'Majelis ID does not exist.',
        'id_pelayan_gereja.required' => 'Pelayan Gereja ID field is required.',
        'id_pelayan_gereja.exists' => 'Pelayan Gereja ID does not exist.',
        'id_gereja.required' => 'Gereja ID field is required.',
        'id_gereja.exists' => 'Gereja ID does not exist.',
        'id_status_pelayanan.required' => 'Status Pelayanan ID field is required.',
        'id_status_pelayanan.exists' => 'Status Pelayanan ID does not exist.',
        'nama_pelayanan_nonTahbisan.required' => 'Nama Pelayanan Non Tahbisan field is required.',
        'nama_pelayanan_nonTahbisan.max' => 'Nama Pelayanan Non Tahbisan may not be greater than :max characters.',
        'tgl_pengangkatan.required' => 'Tanggal Pengangkatan field is required.',
        'tgl_pengangkatan.date' => 'Tanggal Pengangkatan must be a valid date.',
        'tgl_berakhir.required' => 'Tanggal Berakhir field is required.',
        'tgl_berakhir.date' => 'Tanggal Berakhir must be a valid date.',
        'keterangan.max' => 'Keterangan may not be greater than :max characters.',
    ];

    public function index()
    {
        $pelayanNonTahbisan = DB::select('CALL viewAll_Pelayanan_nonTahbisan()');
        return view('admin.Ibadah.PelayanNonTahbisan.index', compact('pelayanNonTahbisan'));
    }

    public function create()
    {
        $majelis = DB::select('CALL viewAll_Majelis()');
        $pelayanGereja = DB::select('CALL viewAll_Pelayan_Gereja()');
        $gerejas = DB::select('CALL viewAll_Gereja()');
        $statuses = DB::select('CALL viewAll_Status()');
        return view('admin.Ibadah.PelayanNonTahbisan.create', compact('majelis', 'pelayanGereja', 'gerejas', 'statuses'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules, $this->messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $pelayanNonTahbisan = [
            'id_majelis' => $request->id_majelis,
            'id_pelayan_gereja' => $request->id_pelayan_gereja,
            'id_gereja' => $request->id_gereja,
            'id_status_pelayanan' => $request->id_status_pelayanan,
            'nama_pelayanan_nonTahbisan' => $request->nama_pelayanan_nonTahbisan,
            'tgl_pengangkatan' => $request->tgl_pengangkatan,
            'tgl_berakhir' => $request->tgl_berakhir,
            'keterangan' => $request->keterangan,
        ];

        DB::statement('CALL insert_pelayanan_nonTahbisan(?)', [json_encode($pelayanNonTahbisan)]);

        return redirect()->route('PelayanNonTahbisan.index')->with('success', 'Pelayanan Non Tahbisan added successfully!');
    }

    public function edit($id)
    {
        $pelayanNonTahbisan = DB::select('CALL view_Pelayanan_nonTahbisan_byId(?)', [$id]);

        if (empty($pelayanNonTahbisan)) {
            return redirect()->route('PelayanNonTahbisan.index')->with('error', 'Pelayanan Non Tahbisan not found!');
        }

        $pelayanNonTahbisan = $pelayanNonTahbisan[0];
        $majelis = DB::select('CALL viewAll_Majelis()');
        $pelayanGereja = DB::select('CALL viewAll_Pelayan_Gereja()');
        $gerejas = DB::select('CALL viewAll_Gereja()');
        $statuses = DB::select('CALL viewAll_Status()');
        return view('admin.Ibadah.PelayanNonTahbisan.edit', compact('pelayanNonTahbisan', 'majelis', 'pelayanGereja', 'gerejas', 'statuses'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), $this->rules, $this->messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $pelayanNonTahbisan = [
            'id_pelayanan_nonTahbisan' => $id,
            'id_majelis' => $request->id_majelis,
            'id_pelayan_gereja' => $request->id_pelayan_gereja,
            'id_gereja' => $request->id_gereja,
            'id_status_pelayanan' => $request->id_status_pelayanan,
            'nama_pelayanan_nonTahbisan' => $request->nama_pelayanan_nonTahbisan,
            'tgl_pengangkatan' => $request->tgl_pengangkatan,
            'tgl_berakhir' => $request->tgl_berakhir,
            'keterangan' => $request->keterangan,
        ];

        DB::statement('CALL update_pelayanan_nonTahbisan(?)', [json_encode($pelayanNonTahbisan)]);

        return redirect()->route('PelayanNonTahbisan.index')->with('success', 'Pelayanan Non Tahbisan updated successfully!');
    }

    public function delete(Request $request)
    {
        $id = $request->id;

        $pelayanNonTahbisan = DB::select('CALL view_PelayanNonTahbisan_byId(?)', [$id]);

        if (empty($pelayanNonTahbisan)) {
            return response()->json([
                'status' => 404,
                'message' => 'Pelayanan Non Tahbisan not found.'
            ]);
        }

        DB::statement('CALL delete_pelayanan_nonTahbisan(?)', [$id]);

        return response()->json([
            'status' => 200,
            'message' => 'Pelayanan Non Tahbisan deleted successfully.'
        ]);
    }

    public function detail(Request $request)
    {
        $id = $request->id;

        $pelayanNonTahbisanData = DB::select('CALL view_Pelayanan_nonTahbisan_byId(?)', [$id]);

        if (!empty($pelayanNonTahbisanData)) {
            $pelayanNonTahbisan = $pelayanNonTahbisanData[0];
            return response()->json([
                'status' => 200,
                'pelayanNonTahbisan' => $pelayanNonTahbisan
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Pelayanan Non Tahbisan data not found.'
            ]);
        }
    }
}

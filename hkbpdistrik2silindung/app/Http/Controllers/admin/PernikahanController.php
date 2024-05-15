<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PernikahanController extends Controller
{
    protected $rules = [
        'id_gereja' => 'required|exists:gereja,id_gereja',
        'tgl_pernikahan' => 'required|date',
        'nats_pernikahan' => 'required|string|max:250',
        'id_gereja_nikah' => 'required|exists:gereja,id_gereja',
        'nama_gereja_non_HKBP' => 'nullable|string|max:200',
        'nama_pendeta' => 'required|string|max:125',
        'keterangan' => 'nullable|string|max:250',
        'id_status' => 'required|exists:status,id_status',
    ];

    protected $messages = [
        'id_gereja.required' => 'Gereja ID field is required.',
        'id_gereja.exists' => 'Gereja ID does not exist.',
        'tgl_pernikahan.required' => 'Tanggal Pernikahan field is required.',
        'tgl_pernikahan.date' => 'Tanggal Pernikahan must be a valid date.',
        'nats_pernikahan.required' => 'Nats Pernikahan field is required.',
        'nats_pernikahan.max' => 'Nats Pernikahan may not be greater than 250 characters.',
        'id_gereja_nikah.required' => 'Gereja Nikah ID field is required.',
        'id_gereja_nikah.exists' => 'Gereja Nikah ID does not exist.',
        'nama_gereja_non_HKBP.max' => 'Nama Gereja Non HKBP may not be greater than 200 characters.',
        'nama_pendeta.required' => 'Nama Pendeta field is required.',
        'nama_pendeta.max' => 'Nama Pendeta may not be greater than 125 characters.',
        'keterangan.max' => 'Keterangan may not be greater than 250 characters.',
        'id_status.required' => 'Status ID field is required.',
        'id_status.exists' => 'Status ID does not exist.',
    ];

    public function index()
    {
        $pernikahans = DB::select('CALL viewAll_Pernikahan()');
        return view('admin.DataMaster.Pernikahan.index', compact('pernikahans'));
    }

    public function create()
    {
        $gerejas = DB::select('CALL viewAll_Gereja()');
        $statuses = DB::select('CALL viewAll_Status()');
        return view('admin.DataMaster.Pernikahan.create', compact('gerejas', 'statuses'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules, $this->messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $pernikahan = [
            'id_gereja' => $request->id_gereja,
            'tgl_pernikahan' => $request->tgl_pernikahan,
            'nats_pernikahan' => $request->nats_pernikahan,
            'id_gereja_nikah' => $request->id_gereja_nikah,
            'nama_gereja_non_HKBP' => $request->nama_gereja_non_HKBP,
            'nama_pendeta' => $request->nama_pendeta,
            'keterangan' => $request->keterangan,
            'id_status' => $request->id_status,
        ];

        DB::statement('CALL insert_pernikahan(?)', [json_encode($pernikahan)]);

        return redirect()->route('Pernikahan.index')->with('success', 'Pernikahan added successfully!');
    }

    public function edit($id)
    {
        $pernikahan = DB::select('CALL view_Pernikahan_byId(?)', [$id]);

        if (empty($pernikahan)) {
            return redirect()->route('Pernikahan.index')->with('error', 'Pernikahan not found!');
        }

        $pernikahan = $pernikahan[0];
        $gerejas = DB::select('CALL viewAll_Gereja()');
        $statuses = DB::select('CALL viewAll_Status()');
        return view('admin.DataMaster.Pernikahan.edit', compact('pernikahan', 'gerejas', 'statuses'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), $this->rules, $this->messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $pernikahan = [
            'id_pernikahan' => $id,
            'id_gereja' => $request->id_gereja,
            'tgl_pernikahan' => $request->tgl_pernikahan,
            'nats_pernikahan' => $request->nats_pernikahan,
            'id_gereja_nikah' => $request->id_gereja_nikah,
            'nama_gereja_non_HKBP' => $request->nama_gereja_non_HKBP,
            'nama_pendeta' => $request->nama_pendeta,
            'keterangan' => $request->keterangan,
            'id_status' => $request->id_status,
        ];

        DB::statement('CALL update_pernikahan(?)', [json_encode($pernikahan)]);

        return redirect()->route('Pernikahan.index')->with('success', 'Pernikahan updated successfully!');
    }

    public function delete(Request $request)
    {
        $id = $request->id;

        $pernikahan = DB::select('CALL view_Pernikahan_byId(?)', [$id]);

        if (empty($pernikahan)) {
            return response()->json([
                'status' => 404,
                'message' => 'Pernikahan not found.'
            ]);
        }

        DB::statement('CALL delete_pernikahan(?)', [$id]);

        return response()->json([
            'status' => 200,
            'message' => 'Pernikahan deleted successfully.'
        ]);
    }

    public function detail(Request $request)
    {
        $id = $request->id;

        $pernikahanData = DB::select('CALL view_Pernikahan_byId(?)', [$id]);

        if (!empty($pernikahanData)) {
            $pernikahan = $pernikahanData[0];
            return response()->json([
                'status' => 200,
                'pernikahan' => $pernikahan
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Pernikahan data not found.'
            ]);
        }
    }
}

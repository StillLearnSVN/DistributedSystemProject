<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class BaptisController extends Controller
{
    protected $rules = [
        'id_jemaat' => 'required|exists:jemaat,id_jemaat',
        'tgl_baptis' => 'required|date',
        'no_surat_baptis' => 'required|integer',
        'id_gereja_baptis' => 'required|exists:gereja,id_gereja',
        'nama_pendeta_baptis' => 'required|string',
        'file_surat_baptis' => 'required|string',
        'keterangan' => 'nullable|string',
        'id_status' => 'required|exists:status,id_status',
    ];

    protected $messages = [
        'id_jemaat.required' => 'Jemaat ID field is required.',
        'id_jemaat.exists' => 'Jemaat ID does not exist.',
        'tgl_baptis.required' => 'Tanggal Baptis field is required.',
        'tgl_baptis.date' => 'Tanggal Baptis must be a valid date.',
        'no_surat_baptis.required' => 'No. Surat Baptis field is required.',
        'no_surat_baptis.integer' => 'No. Surat Baptis must be an integer.',
        'id_gereja_baptis.required' => 'Gereja Baptis ID field is required.',
        'id_gereja_baptis.exists' => 'Gereja Baptis ID does not exist.',
        'nama_pendeta_baptis.required' => 'Nama Pendeta Baptis field is required.',
        'file_surat_baptis.required' => 'File Surat Baptis field is required.',
        'id_status.required' => 'Status ID field is required.',
        'id_status.exists' => 'Status ID does not exist.',
    ];

    public function index()
    {
        $baptis = DB::select('CALL viewAll_Baptis()');
        return view('admin.DataMaster.Baptis.index', compact('baptis'));
    }

    public function create()
    {
        $jemaats = DB::select('CALL viewAll_Jemaat()');
        $statuses = DB::select('CALL viewAll_Status()');
        $gerejas = DB::select('CALL viewAll_Gereja()');
        return view('admin.DataMaster.Baptis.create', compact('jemaats', 'statuses', 'gerejas'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules, $this->messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $baptis = [
            'id_jemaat' => $request->id_jemaat,
            'tgl_baptis' => $request->tgl_baptis,
            'no_surat_baptis' => $request->no_surat_baptis,
            'id_gereja_baptis' => $request->id_gereja_baptis,
            'nama_gereja_non_HKBP' => $request->nama_gereja_non_HKBP,
            'nama_pendeta_baptis' => $request->nama_pendeta_baptis,
            'file_surat_baptis' => $request->file_surat_baptis,
            'keterangan' => $request->keterangan,
            'id_status' => $request->id_status,
        ];

        if ($request->hasFile('file_surat_baptis')) {
            $file = $request->file('file_surat_baptis');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('baptis_files', $fileName);
            $baptis['file_surat_baptis'] = $filePath;
        }

        DB::statement('CALL insert_baptis(?)', [json_encode($baptis)]);

        return redirect()->route('Baptis.index')->with('success', 'Baptis added successfully!');
    }

    public function edit($id)
    {
        $baptis = DB::select('CALL view_Baptis_byId(?)', [$id]);

        if (empty($baptis)) {
            return redirect()->route('Baptis.index')->with('error', 'Baptis not found!');
        }

        $baptis = $baptis[0];
        $jemaats = DB::select('CALL viewAll_Jemaat()');
        $statuses = DB::select('CALL viewAll_Status()');
        $gerejas = DB::select('CALL viewAll_Gereja()');
        return view('admin.DataMaster.Baptis.edit', compact('baptis', 'jemaats', 'statuses', 'gerejas'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), $this->rules, $this->messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $baptis = [
            'id_baptis' => $id,
            'id_jemaat' => $request->id_jemaat,
            'tgl_baptis' => $request->tgl_baptis,
            'no_surat_baptis' => $request->no_surat_baptis,
            'id_gereja_baptis' => $request->id_gereja_baptis,
            'nama_pendeta_baptis' => $request->nama_pendeta_baptis,
            'file_surat_baptis' => $request->file_surat_baptis,
            'keterangan' => $request->keterangan,
            'id_status' => $request->id_status,
        ];

        DB::statement('CALL update_baptis(?)', [json_encode($baptis)]);

        return redirect()->route('Baptis.index')->with('success', 'Baptis updated successfully!');
    }

    public function delete(Request $request)
    {
        $id = $request->id;

        $baptis = DB::select('CALL view_Baptis_byId(?)', [$id]);

        if (empty($baptis)) {
            return response()->json([
                'status' => 404,
                'message' => 'Baptis not found.'
            ]);
        }

        DB::statement('CALL delete_baptis(?)', [$id]);

        return response()->json([
            'status' => 200,
            'message' => 'Baptis deleted successfully.'
        ]);
    }

    public function detail(Request $request)
    {
        $id = $request->id;

        $baptisData = DB::select('CALL view_Baptis_byId(?)', [$id]);

        if (!empty($baptisData)) {
            $baptis = $baptisData[0];
            return response()->json([
                'status' => 200,
                'baptis' => $baptis
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Baptis data not found.'
            ]);
        }
    }
}

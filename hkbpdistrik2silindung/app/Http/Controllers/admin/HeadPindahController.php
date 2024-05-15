<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class HeadPindahController extends Controller
{
    protected $rules = [
        'id_jemaat' => 'required|exists:jemaat,id_jemaat',
        'id_gereja' => 'required|exists:gereja,id_gereja',
        'no_surat_pindah' => 'nullable|integer',
        'tgl_pindah' => 'required|date',
        'tgl_warta' => 'nullable|date',
        'nama_gereja_no_hkbp' => 'nullable|string',
        'file_surat_pindah' => 'nullable|string',
        'keterangan' => 'nullable|string',
    ];

    protected $messages = [
        'id_jemaat.required' => 'Jemaat ID field is required.',
        'id_jemaat.exists' => 'Jemaat ID does not exist.',
        'id_gereja.required' => 'Gereja ID field is required.',
        'id_gereja.exists' => 'Gereja ID does not exist.',
        'tgl_pindah.required' => 'Tanggal Pindah field is required.',
        'tgl_pindah.date' => 'Tanggal Pindah must be a valid date.',
        'tgl_warta.date' => 'Tanggal Warta must be a valid date.',
        'id_gereja_tujuan.exists' => 'Gereja Tujuan ID does not exist.',
    ];

    public function index()
    {
        $headPindahs = DB::select('CALL viewAll_HeadPindah()');
        return view('admin.Administrasi.HeadPindah.index', compact('headPindahs'));
    }

    public function create()
    {
        $jemaats = DB::select('CALL viewAll_Jemaat()');
        $gerejas = DB::select('CALL viewAll_Gereja()');
        return view('admin.Administrasi.HeadPindah.create', compact('jemaats', 'gerejas'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules, $this->messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $headPindah = [
            'id_jemaat' => $request->id_jemaat,
            'id_gereja' => $request->id_gereja,
            'no_surat_pindah' => $request->no_surat_pindah,
            'tgl_pindah' => $request->tgl_pindah,
            'tgl_warta' => $request->tgl_warta,
            'id_gereja_tujuan' => $request->id_gereja_tujuan,
            'nama_gereja_no_hkbp' => $request->nama_gereja_no_hkbp,
            'file_surat_pindah' => $request->file_surat_pindah,
            'keterangan' => $request->keterangan,
        ];

        if ($request->hasFile('file_surat_pindah')) {
            $file = $request->file('file_surat_pindah');

            // Generate a unique file name
            $fileName = time() . '_' . $file->getClientOriginalName();

            // Store the file in the specified directory
            $filePath = $file->storeAs('pindah_files', $fileName);

            // Add file path to $headPindah array
            $headPindah['file_surat_pindah'] = $filePath;
        }

        DB::statement('CALL insert_head_pindah(?)', [json_encode($headPindah)]);

        return redirect()->route('HeadPindah.index')->with('success', 'Head Pindah added successfully!');
    }

    public function edit($id)
    {
        $headPindah = DB::select('CALL view_HeadPindah_byId(?)', [$id]);

        if (empty($headPindah)) {
            return redirect()->route('HeadPindah.index')->with('error', 'Head Pindah not found!');
        }

        $headPindah = $headPindah[0];
        $jemaats = DB::select('CALL viewAll_Jemaat()');
        $gerejas = DB::select('CALL viewAll_Gereja()');
        return view('admin.Administrasi.HeadPindah.edit', compact('headPindah', 'jemaats', 'gerejas'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), $this->rules, $this->messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $headPindah = [
            'id_head_pindah' => $id,
            'id_jemaat' => $request->id_jemaat,
            'id_gereja' => $request->id_gereja,
            'no_surat_pindah' => $request->no_surat_pindah,
            'tgl_pindah' => $request->tgl_pindah,
            'tgl_warta' => $request->tgl_warta,
            'id_gereja_tujuan' => $request->id_gereja_tujuan,
            'nama_gereja_no_hkbp' => $request->nama_gereja_no_hkbp,
            'file_surat_pindah' => $request->file_surat_pindah,
            'keterangan' => $request->keterangan,
        ];

        if ($request->hasFile('file_surat_pindah')) {
            $file = $request->file('file_surat_pindah');

            // Generate a unique file name
            $fileName = time() . '_' . $file->getClientOriginalName();

            // Store the file in the specified directory
            $filePath = $file->storeAs('pindah_files', $fileName);

            // Add file path to $headPindah array
            $headPindah['file_surat_pindah'] = $filePath;
        }

        DB::statement('CALL update_head_pindah(?)', [json_encode($headPindah)]);

        return redirect()->route('HeadPindah.index')->with('success', 'Head Pindah updated successfully!');
    }

    public function delete(Request $request)
    {
        $id = $request->id;

        $headPindah = DB::select('CALL view_HeadPindah_byId(?)', [$id]);

        if (empty($headPindah)) {
            return response()->json([
                'status' => 404,
                'message' => 'Head Pindah not found.'
            ]);
        }

        DB::statement('CALL delete_head_pindah(?)', [$id]);

        return response()->json([
            'status' => 200,
            'message' => 'Head Pindah deleted successfully.'
        ]);
    }

    public function detail(Request $request)
    {
        $id = $request->id;

        $headPindahData = DB::select('CALL view_HeadPindah_byId(?)', [$id]);

        if (!empty($headPindahData)) {
            $headPindah = $headPindahData[0];
            return response()->json([
                'status' => 200,
                'head_pindah' => $headPindah
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Head Pindah data not found.'
            ]);
        }
    }
}

<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;


class SidiController extends Controller
{
    protected $rules = [
        'id_jemaat' => 'required|exists:jemaat,id_jemaat',
        'id_status' => 'required|exists:status,id_status',
        'tgl_sidi' => 'required|date',
        'no_surat_sidi' => 'required|integer',
        'nats_sidi' => 'required|string',
        'id_gereja_sidi' => 'required|exists:gereja,id_gereja',
        'nama_pendeta_sidi' => 'required|string',
        'file_surat_sidi' => 'required|string',
        'keterangan' => 'nullable|string',
    ];

    protected $messages = [
        'id_jemaat.required' => 'Jemaat ID field is required.',
        'id_jemaat.exists' => 'Jemaat ID does not exist.',
        'id_status.required' => 'Status ID field is required.',
        'id_status.exists' => 'Status ID does not exist.',
        'tgl_sidi.required' => 'Tanggal Sidi field is required.',
        'tgl_sidi.date' => 'Tanggal Sidi must be a valid date.',
        'no_surat_sidi.required' => 'No. Surat Sidi field is required.',
        'no_surat_sidi.integer' => 'No. Surat Sidi must be an integer.',
        'nats_sidi.required' => 'Nats Sidi field is required.',
        'isHKBP.boolean' => 'IsHKBP field must be a boolean value.',
        'id_gereja_sidi.required' => 'Gereja Sidi ID field is required.',
        'id_gereja_sidi.exists' => 'Gereja Sidi ID does not exist.',
        'nama_pendeta_sidi.required' => 'Nama Pendeta Sidi field is required.',
        'file_surat_sidi.required' => 'File Surat Sidi field is required.',
    ];

    public function index()
    {
        $sidis = DB::select('CALL viewAll_Sidi()');
        return view('admin.DataMaster.Sidi.index', compact('sidis'));
    }

    public function create()
    {
        $jemaats = DB::select('CALL viewAll_Jemaat()');
        $statuses = DB::select('CALL viewAll_Status()');
        $gerejas = DB::select('CALL viewAll_Gereja()');
        return view('admin.DataMaster.Sidi.create', compact('jemaats', 'statuses', 'gerejas'));
    }

    public function store(Request $request)
{
    $validator = Validator::make($request->all(), $this->rules, $this->messages);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    // Construct the $sidi array with all form fields
    $sidi = [
        'id_jemaat' => $request->id_jemaat,
        'id_status' => $request->id_status,
        'tgl_sidi' => $request->tgl_sidi,
        'no_surat_sidi' => $request->no_surat_sidi,
        'nats_sidi' => $request->nats_sidi,
        'id_gereja_sidi' => $request->id_gereja_sidi,
        'nama_gereja_non_hkbp' => $request->nama_gereja_non_hkbp,
        'nama_pendeta_sidi' => $request->nama_pendeta_sidi,
        'file_surat_sidi' => $request->file_surat_sidi,
        'keterangan' => $request->keterangan,
    ];

    if ($request->hasFile('file_surat_sidi')) {
        $file = $request->file('file_surat_sidi');

        // Generate a unique file name
        $fileName = time() . '_' . $file->getClientOriginalName();

        // Store the file in the specified directory
        $filePath = $file->storeAs('sidi_files', $fileName);

        // Add file path to $sidi array
        $sidi['file_surat_sidi'] = $filePath;
    }

    // Convert array to JSON string before passing to stored procedure
    $sidiJson = json_encode($sidi);

    // Call the stored procedure with the JSON string
    DB::statement('CALL insert_sidi(?)', [$sidiJson]);

    return redirect()->route('Sidi.index')->with('success', 'Sidi added successfully!');
}




    public function edit($id)
    {
        $sidi = DB::select('CALL view_Sidi_byId(?)', [$id]);

        if (empty($sidi)) {
            return redirect()->route('Sidi.index')->with('error', 'Sidi not found!');
        }

        $sidi = $sidi[0];
        $jemaats = DB::select('CALL viewAll_Jemaat()');
        $statuses = DB::select('CALL viewAll_Status()');
        $gerejas = DB::select('CALL viewAll_Gereja()');
        return view('admin.DataMaster.Sidi.edit', compact('sidi', 'jemaats', 'statuses', 'gerejas'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), $this->rules, $this->messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $sidi = [
            'id_sidi' => $id,
            'id_jemaat' => $request->id_jemaat,
            'id_status' => $request->id_status,
            'tgl_sidi' => $request->tgl_sidi,
            'no_surat_sidi' => $request->no_surat_sidi,
            'nats_sidi' => $request->nats_sidi,
            'id_gereja_sidi' => $request->id_gereja_sidi,
            'nama_pendeta_sidi' => $request->nama_pendeta_sidi,
            'file_surat_sidi' => $request->file_surat_sidi,
            'keterangan' => $request->keterangan,
        ];

        DB::statement('CALL update_sidi(?)', [json_encode($sidi)]);

        return redirect()->route('Sidi.index')->with('success', 'Sidi updated successfully!');
    }

    public function delete(Request $request)
    {
        $id = $request->id;

        $sidi = DB::select('CALL view_Sidi_byId(?)', [$id]);

        if (empty($sidi)) {
            return response()->json([
                'status' => 404,
                'message' => 'Sidi not found.'
            ]);
        }

        DB::statement('CALL delete_sidi(?)', [$id]);

        return response()->json([
            'status' => 200,
            'message' => 'Sidi deleted successfully.'
        ]);
    }

    public function detail(Request $request)
    {
        $id = $request->id;

        $sidiData = DB::select('CALL view_Sidi_byId(?)', [$id]);

        if (!empty($sidiData)) {
            $sidi = $sidiData[0];
            return response()->json([
                'status' => 200,
                'sidi' => $sidi
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Sidi data not found.'
            ]);
        }
    }
}

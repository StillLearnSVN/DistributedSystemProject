<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MeninggalController extends Controller
{
    protected $rules = [
        'id_jemaat' => 'required|exists:jemaat,id_jemaat',
        'id_status' => 'required|exists:status,id_status',
        'tgl_meninggal' => 'required|date',
        'tgl_warta_meninggal' => 'required|date',
        'tempat_pemakaman' => 'required|string|max:150',
        'nama_pendeta_melayani' => 'required|string|max:100',
        'id_gereja' => 'required|exists:gereja,id_gereja',
        'keterangan' => 'nullable|string|max:250',
    ];

    protected $messages = [
        'id_jemaat.required' => 'Jemaat ID field is required.',
        'id_jemaat.exists' => 'Jemaat ID does not exist.',
        'id_status.required' => 'Status ID field is required.',
        'id_status.exists' => 'Status ID does not exist.',
        'tgl_meninggal.required' => 'Tanggal Meninggal field is required.',
        'tgl_meninggal.date' => 'Tanggal Meninggal must be a valid date.',
        'tgl_warta_meninggal.required' => 'Tanggal Warta Meninggal field is required.',
        'tgl_warta_meninggal.date' => 'Tanggal Warta Meninggal must be a valid date.',
        'tempat_pemakaman.required' => 'Tempat Pemakaman field is required.',
        'tempat_pemakaman.max' => 'Tempat Pemakaman may not be greater than 150 characters.',
        'nama_pendeta_melayani.required' => 'Nama Pendeta Melayani field is required.',
        'nama_pendeta_melayani.max' => 'Nama Pendeta Melayani may not be greater than 100 characters.',
        'id_gereja.required' => 'Gereja ID field is required.',
        'id_gereja.exists' => 'Gereja ID does not exist.',
    ];

    public function index()
    {
        $meninggals = DB::select('CALL viewAll_Meninggal()');
        return view('admin.Administrasi.Meninggal.index', compact('meninggals'));
    }

    public function create()
    {
        $jemaats = DB::select('CALL viewAll_Jemaat()');
        $statuses = DB::select('CALL viewAll_Status()');
        $gerejas = DB::select('CALL viewAll_Gereja()');
        return view('admin.Administrasi.Meninggal.create', compact('jemaats', 'statuses', 'gerejas'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules, $this->messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $meninggal = $request->only([
            'id_jemaat', 'id_status', 'tgl_meninggal', 'tgl_warta_meninggal', 'tempat_pemakaman',
            'nama_pendeta_melayani', 'keterangan', 'id_gereja'
        ]);

        DB::statement('CALL insert_meninggal(?)', [json_encode($meninggal)]);

        return redirect()->route('Meninggal.index')->with('success', 'Meninggal added successfully!');
    }

    public function edit($id)
    {
        $meninggal = DB::select('CALL view_Meninggal_byId(?)', [$id]);

        if (empty($meninggal)) {
            return redirect()->route('Meninggal.index')->with('error', 'Meninggal not found!');
        }

        $meninggal = $meninggal[0];
        $jemaats = DB::select('CALL viewAll_Jemaat()');
        $statuses = DB::select('CALL viewAll_Status()');
        $gerejas = DB::select('CALL viewAll_Gereja()');
        return view('admin.Administrasi.Meninggal.edit', compact('meninggal', 'jemaats', 'statuses', 'gerejas'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), $this->rules, $this->messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $meninggal = $request->only([
            'id_jemaat', 'id_status', 'tgl_meninggal', 'tgl_warta_meninggal', 'tempat_pemakaman',
            'nama_pendeta_melayani', 'keterangan', 'id_gereja'
        ]);

        DB::statement('CALL update_meninggal(?)', [json_encode($meninggal)]);

        return redirect()->route('Meninggal.index')->with('success', 'Meninggal updated successfully!');
    }

    public function delete(Request $request)
    {
        $id = $request->id;

        $meninggal = DB::select('CALL view_Meninggal_byId(?)', [$id]);

        if (empty($meninggal)) {
            return response()->json([
                'status' => 404,
                'message' => 'Meninggal not found.'
            ]);
        }

        DB::statement('CALL delete_meninggal(?)', [$id]);

        return response()->json([
            'status' => 200,
            'message' => 'Meninggal deleted successfully.'
        ]);
    }

    public function detail(Request $request)
    {
        $id = $request->id;

        $meninggalData = DB::select('CALL view_Meninggal_byId(?)', [$id]);

        if (!empty($meninggalData)) {
            $meninggal = $meninggalData[0];
            return response()->json([
                'status' => 200,
                'meninggal' => $meninggal
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Meninggal data not found.'
            ]);
        }
    }
}


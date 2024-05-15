<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MajelisController extends Controller
{
    protected $rules = [
        'id_jemaat' => 'required|exists:jemaat,id_jemaat',
        'id_status_pelayanan' => 'required|exists:status,id_status',
        'id_gereja' => 'required|exists:gereja,id_gereja',
        'tgl_tahbis' => 'required|date',
        'tgl_akhir_jawatan' => 'required|date',
    ];

    protected $messages = [
        'id_jemaat.required' => 'Jemaat ID field is required.',
        'id_jemaat.exists' => 'Jemaat ID does not exist.',
        'id_status_pelayanan.required' => 'Status Pelayanan ID field is required.',
        'id_status_pelayanan.exists' => 'Status Pelayanan ID does not exist.',
        'id_gereja.required' => 'Gereja ID field is required.',
        'id_gereja.exists' => 'Gereja ID does not exist.',
        'tgl_tahbis.required' => 'Tanggal Tahbis field is required.',
        'tgl_tahbis.date' => 'Tanggal Tahbis must be a valid date.',
        'tgl_akhir_jawatan.required' => 'Tanggal Akhir Jawatan field is required.',
        'tgl_akhir_jawatan.date' => 'Tanggal Akhir Jawatan must be a valid date.',
    ];

    public function index()
    {
        $majelis = DB::select('CALL viewAll_Majelis()');
        return view('admin.DataMaster.Majelis.index', compact('majelis'));
    }

    public function create()
    {
        $jemaats = DB::select('CALL viewAll_Jemaat()');
        $statuses = DB::select('CALL viewAll_Status()');
        $gerejas = DB::select('CALL viewAll_Gereja()');
        return view('admin.DataMaster.Majelis.create', compact('jemaats', 'statuses', 'gerejas'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules, $this->messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $majelis = [
            'id_jemaat' => $request->id_jemaat,
            'id_status_pelayanan' => $request->id_status_pelayanan,
            'id_gereja' => $request->id_gereja,
            'tgl_tahbis' => $request->tgl_tahbis,
            'tgl_akhir_jawatan' => $request->tgl_akhir_jawatan,
        ];

        DB::statement('CALL insert_majelis(?)', [json_encode($majelis)]);

        return redirect()->route('Majelis.index')->with('success', 'Majelis added successfully!');
    }

    public function edit($id)
    {
        $majelis = DB::select('CALL view_Majelis_byId(?)', [$id]);

        if (empty($majelis)) {
            return redirect()->route('Majelis.index')->with('error', 'Majelis not found!');
        }

        $majelis = $majelis[0];
        $jemaats = DB::select('CALL viewAll_Jemaat()');
        $statuses = DB::select('CALL viewAll_Status()');
        $gerejas = DB::select('CALL viewAll_Gereja()');
        return view('admin.DataMaster.Majelis.edit', compact('majelis', 'jemaats', 'statuses', 'gerejas'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), $this->rules, $this->messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $majelis = [
            'id_majelis' => $id,
            'id_jemaat' => $request->id_jemaat,
            'id_status_pelayanan' => $request->id_status_pelayanan,
            'id_gereja' => $request->id_gereja,
            'tgl_tahbis' => $request->tgl_tahbis,
            'tgl_akhir_jawatan' => $request->tgl_akhir_jawatan,
        ];

        DB::statement('CALL update_majelis(?)', [json_encode($majelis)]);

        return redirect()->route('Majelis.index')->with('success', 'Majelis updated successfully!');
    }

    public function delete(Request $request)
    {
        $id = $request->id;

        $majelis = DB::select('CALL view_Majelis_byId(?)', [$id]);

        if (empty($majelis)) {
            return response()->json([
                'status' => 404,
                'message' => 'Majelis not found.'
            ]);
        }

        DB::statement('CALL delete_majelis(?)', [$id]);

        return response()->json([
            'status' => 200,
            'message' => 'Majelis deleted successfully.'
        ]);
    }

    public function detail(Request $request)
    {
        $id = $request->id;

        $majelisData = DB::select('CALL view_Majelis_byId(?)', [$id]);

        if (!empty($majelisData)) {
            $majelis = $majelisData[0];
            return response()->json([
                'status' => 200,
                'majelis' => $majelis
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Majelis data not found.'
            ]);
        }
    }
}

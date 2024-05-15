<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PernikahanJemaatController extends Controller
{
    protected $rules = [
        'id_pernikahan' => 'required|exists:pernikahan,id_pernikahan',
        'id_jemaat_laki' => 'required|exists:jemaat,id_jemaat',
        'id_jemaat_perempuan' => 'required|exists:jemaat,id_jemaat',
        'keterangan' => 'nullable|string',
    ];

    protected $messages = [
        'id_pernikahan.required' => 'Pernikahan ID field is required.',
        'id_pernikahan.exists' => 'Pernikahan ID does not exist.',
        'id_jemaat_laki.required' => 'Jemaat Laki ID field is required.',
        'id_jemaat_laki.exists' => 'Jemaat Laki ID does not exist.',
        'id_jemaat_perempuan.required' => 'Jemaat Perempuan ID field is required.',
        'id_jemaat_perempuan.exists' => 'Jemaat Perempuan ID does not exist.',
    ];

    public function index()
    {
        $pernikahanJemaats = DB::select('CALL viewAll_PernikahanJemaat()');
        return view('admin.DataMaster.PernikahanJemaat.index', compact('pernikahanJemaats'));
    }

    public function create()
    {
        $pernikahans = DB::select('CALL viewAll_Pernikahan()');
        $jemaatLakis = DB::select('CALL viewAll_JemaatLaki()');
        $jemaatPerempuans = DB::select('CALL viewAll_JemaatPerempuan()');
        return view('admin.DataMaster.PernikahanJemaat.create', compact('pernikahans', 'jemaatLakis', 'jemaatPerempuans'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules, $this->messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $pernikahanJemaat = [
            'id_pernikahan' => $request->id_pernikahan,
            'id_jemaat_laki' => $request->id_jemaat_laki,
            'id_jemaat_perempuan' => $request->id_jemaat_perempuan,
            'keterangan' => $request->keterangan,
        ];

        DB::statement('CALL insert_pernikahan_jemaat(?)', [json_encode($pernikahanJemaat)]);

        return redirect()->route('PernikahanJemaat.index')->with('success', 'Pernikahan Jemaat added successfully!');
    }

    public function edit($id)
    {
        $pernikahanJemaat = DB::select('CALL view_PernikahanJemaat_byId(?)', [$id]);

        if (empty($pernikahanJemaat)) {
            return redirect()->route('PernikahanJemaat.index')->with('error', 'Pernikahan Jemaat not found!');
        }

        $pernikahanJemaat = $pernikahanJemaat[0];
        $pernikahans = DB::select('CALL viewAll_Pernikahan()');
        $jemaatLakis = DB::select('CALL viewAll_Jemaat()');
        $jemaatPerempuans = DB::select('CALL viewAll_Jemaat()');
        return view('admin.DataMaster.PernikahanJemaat.edit', compact('pernikahanJemaat', 'pernikahans', 'jemaatLakis', 'jemaatPerempuans'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), $this->rules, $this->messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $pernikahanJemaat = [
            'id_pernikahan_jemaat' => $id,
            'id_pernikahan' => $request->id_pernikahan,
            'id_jemaat_laki' => $request->id_jemaat_laki,
            'id_jemaat_perempuan' => $request->id_jemaat_perempuan,
            'keterangan' => $request->keterangan,
        ];

        DB::statement('CALL update_pernikahan_jemaat(?)', [json_encode($pernikahanJemaat)]);

        return redirect()->route('PernikahanJemaat.index')->with('success', 'Pernikahan Jemaat updated successfully!');
    }

    public function delete(Request $request)
    {
        $id = $request->id;

        $pernikahanJemaat = DB::select('CALL view_PernikahanJemaat_byId(?)', [$id]);

        if (empty($pernikahanJemaat)) {
            return response()->json([
                'status' => 404,
                'message' => 'Pernikahan Jemaat not found.'
            ]);
        }

        DB::statement('CALL delete_pernikahan_jemaat(?)', [$id]);

        return response()->json([
            'status' => 200,
            'message' => 'Pernikahan Jemaat deleted successfully.'
        ]);
    }

    public function detail(Request $request)
    {
        $id = $request->id;

        $pernikahanJemaatData = DB::select('CALL view_PernikahanJemaat_byId(?)', [$id]);

        if (!empty($pernikahanJemaatData)) {
            $pernikahanJemaat = $pernikahanJemaatData[0];
            return response()->json([
                'status' => 200,
                'pernikahan_jemaat' => $pernikahanJemaat
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Pernikahan Jemaat data not found.'
            ]);
        }
    }
}

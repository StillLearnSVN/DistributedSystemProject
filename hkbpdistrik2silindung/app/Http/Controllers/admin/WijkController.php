<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class WijkController extends Controller
{
    protected $rules = [
        'nama_wijk' => 'required',
        'keterangan' => 'required'
    ];

    protected $messages = [
        'nama_wijk.required' => 'Nama wijk field is required.',
        'keterangan.required' => 'Keterangan field is required.'
    ];

    public function index()
    {
        $wijks = DB::select('CALL viewAll_Wijk()');
        return view('admin.PengaturanDanKonfigurasi.Wijk.index', compact('wijks'));
    }

    public function create()
    {
        return view('admin.PengaturanDanKonfigurasi.Wijk.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules, $this->messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $wijk = json_encode([
            'nama_wijk' => $request->nama_wijk,
            'keterangan' => $request->keterangan
        ]);

        DB::statement('CALL insert_wijk(?)', [$wijk]);

        return redirect()->route('Wijk.index')->with('success', 'Wijk added successfully!');
    }

    public function edit($id)
    {
        $wijk = DB::select('CALL view_Wijk_byId(?)', [$id]);

        if (empty($wijk)) {
            return redirect()->route('Wijk.index')->with('error', 'Wijk not found!');
        }

        $wijk = $wijk[0];
        return view('admin.PengaturanDanKonfigurasi.Wijk.edit', compact('wijk'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), $this->rules, $this->messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $wijk = json_encode([
            'id_wijk' => $id,
            'nama_wijk' => $request->nama_wijk,
            'keterangan' => $request->keterangan
        ]);

        DB::statement('CALL update_wijk(?)', [$wijk]);

        return redirect()->route('Wijk.index')->with('success', 'Wijk updated successfully!');
    }

    public function delete(Request $request)
    {
        $id = $request->id;

        $wijk = DB::select('CALL view_Wijk_byId(?)', [$id]);

        if (empty($wijk)) {
            return response()->json([
                'status' => 404,
                'message' => 'Wijk not found.'
            ]);
        }

        DB::statement('CALL delete_wijk(?)', [$id]);

        return response()->json([
            'status' => 200,
            'message' => 'Wijk deleted successfully.'
        ]);
    }

    public function detail(Request $request)
    {
        $id = $request->id;

        $wijkData = DB::select('CALL view_Wijk_byId(?)', [$id]);

        if (!empty($wijkData)) {
            $wijk = $wijkData[0];
            return response()->json([
                'status' => 200,
                'wijk' => $wijk
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Data Wijk Tidak Ditemukan.'
            ]);
        }
    }
}

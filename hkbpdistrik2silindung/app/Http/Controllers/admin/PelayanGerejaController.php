<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PelayanGerejaController extends Controller
{
    protected $rules = [
        'id_jemaat' => 'required|exists:jemaat,id_jemaat',
        'keterangan' => 'nullable|string|max:255',
    ];

    protected $messages = [
        'id_jemaat.required' => 'Jemaat ID field is required.',
        'id_jemaat.exists' => 'Jemaat ID does not exist.',
        'keterangan.max' => 'Keterangan may not be greater than 255 characters.',
    ];

    public function index()
    {
        $pelayanGereja = DB::select('CALL viewAll_Pelayan_Gereja()');
        return view('admin.Ibadah.PelayanIbadah.index', compact('pelayanGereja'));
    }

    public function create()
    {
        $jemaats = DB::select('CALL viewAll_Jemaat()');
        return view('admin.Ibadah.PelayanIbadah.create', compact('jemaats'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules, $this->messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $pelayanGereja = [
            'id_jemaat' => $request->id_jemaat,
            'keterangan' => $request->keterangan,
        ];

        DB::statement('CALL insert_pelayan_gereja(?)', [json_encode($pelayanGereja)]);

        return redirect()->route('PelayanGereja.index')->with('success', 'Pelayan Gereja added successfully!');
    }

    public function edit($id)
    {
        $pelayanGereja = DB::select('CALL view_Pelayan_Gereja_byId(?)', [$id]);

        if (empty($pelayanGereja)) {
            return redirect()->route('PelayanGereja.index')->with('error', 'Pelayan Gereja not found!');
        }

        $pelayanGereja = $pelayanGereja[0];
        $jemaats = DB::select('CALL viewAll_Jemaat()');
        return view('admin.Ibadah.PelayanIbadah.edit', compact('pelayanGereja', 'jemaats'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), $this->rules, $this->messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $pelayanGereja = [
            'id_pelayan_gereja' => $id,
            'id_jemaat' => $request->id_jemaat,
            'keterangan' => $request->keterangan,
        ];

        DB::statement('CALL update_pelayan_gereja(?)', [json_encode($pelayanGereja)]);

        return redirect()->route('PelayanGereja.index')->with('success', 'Pelayan Gereja updated successfully!');
    }

    public function delete(Request $request)
    {
        $id = $request->id;

        $pelayanGereja = DB::select('CALL view_Pelayan_Gereja_byId(?)', [$id]);

        if (empty($pelayanGereja)) {
            return response()->json([
                'status' => 404,
                'message' => 'Pelayan Gereja not found.'
            ]);
        }

        DB::statement('CALL delete_pelayan_gereja(?)', [$id]);

        return response()->json([
            'status' => 200,
            'message' => 'Pelayan Gereja deleted successfully.'
        ]);
    }

    public function detail(Request $request)
    {
        $id = $request->id;

        $pelayanGerejaData = DB::select('CALL view_Pelayan_Gereja_byId(?)', [$id]);

        if (!empty($pelayanGerejaData)) {
            $pelayanGereja = $pelayanGerejaData[0];
            return response()->json([
                'status' => 200,
                'pelayan_gereja' => $pelayanGereja
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Pelayan Gereja data not found.'
            ]);
        }
    }
}


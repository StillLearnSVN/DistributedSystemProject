<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MajelisLingkunganController extends Controller
{
    protected $rules = [
        'id_majelis' => 'required|exists:majelis,id_majelis',
        'id_wijk' => 'required|exists:wijk,id_wijk',
    ];

    protected $messages = [
        'id_majelis.required' => 'Majelis ID field is required.',
        'id_majelis.exists' => 'Majelis ID does not exist.',
        'id_wijk.required' => 'Wijk ID field is required.',
        'id_wijk.exists' => 'Wijk ID does not exist.',
    ];

    public function index()
    {
        $majelisLingkungan = DB::select('CALL viewAll_Majelis_Lingkungan()');
        return view('admin.DataMaster.MajelisLingkungan.index', compact('majelisLingkungan'));
    }

    public function create()
    {
        $majelis = DB::select('CALL viewAll_Majelis()');
        $wijks = DB::select('CALL viewAll_Wijk()');
        return view('admin.DataMaster.MajelisLingkungan.create', compact('majelis', 'wijks'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules, $this->messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $majelisLingkungan = [
            'id_majelis' => $request->id_majelis,
            'id_wijk' => $request->id_wijk,
        ];

        DB::statement('CALL insert_majelis_lingkungan(?)', [json_encode($majelisLingkungan)]);

        return redirect()->route('MajelisLingkungan.index')->with('success', 'Majelis Lingkungan added successfully!');
    }

    public function edit($id)
    {
        $majelisLingkungan = DB::select('CALL view_Majelis_Lingkungan_byId(?)', [$id]);

        if (empty($majelisLingkungan)) {
            return redirect()->route('MajelisLingkungan.index')->with('error', 'Majelis Lingkungan not found!');
        }

        $majelisLingkungan = $majelisLingkungan[0];
        $majelis = DB::select('CALL viewAll_Majelis()');
        $wijks = DB::select('CALL viewAll_Wijk()');
        return view('admin.DataMaster.MajelisLingkungan.edit', compact('majelisLingkungan', 'majelis', 'wijks'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), $this->rules, $this->messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $majelisLingkungan = [
            'id_majelis' => $request->id_majelis,
            'id_wijk' => $request->id_wijk,
        ];

        DB::statement('CALL update_majelis_lingkungan(?)', [json_encode($majelisLingkungan)]);

        return redirect()->route('MajelisLingkungan.index')->with('success', 'Majelis Lingkungan updated successfully!');
    }

    public function delete(Request $request)
    {
        $id = $request->id;

        $majelisLingkungan = DB::select('CALL view_Majelis_Lingkungan_byId(?)', [$id]);

        if (empty($majelisLingkungan)) {
            return response()->json([
                'status' => 404,
                'message' => 'Majelis Lingkungan not found.'
            ]);
        }

        DB::statement('CALL delete_majelis_lingkungan(?)', [$id]);

        return response()->json([
            'status' => 200,
            'message' => 'Majelis Lingkungan deleted successfully.'
        ]);
    }

    public function detail(Request $request)
    {
        $id = $request->id;

        $majelisLingkunganData = DB::select('CALL view_Majelis_Lingkungan_byId(?)', [$id]);

        if (!empty($majelisLingkunganData)) {
            $majelisLingkungan = $majelisLingkunganData[0];
            return response()->json([
                'status' => 200,
                'majelisLingkungan' => $majelisLingkungan
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Majelis Lingkungan data not found.'
            ]);
        }
    }
}

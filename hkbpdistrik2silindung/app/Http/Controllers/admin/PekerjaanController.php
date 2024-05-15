<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;


class PekerjaanController extends Controller
{
    protected $rules = [
        'pekerjaan' => 'required',
        'keterangan' => 'nullable'
    ];

    protected $messages = [
        'pekerjaan.required' => 'Pekerjaan field is required.',
        // 'keterangan.required' => 'Keterangan field is required.' // You may not need this if keterangan is nullable
    ];

    public function index()
    {
        // Fetch all pekerjaan from Go microservice
        $response = Http::get('http://localhost:8080/pekerjaan');
        $pekerjaans = $response->json();

        return view('admin.PengaturanDanKonfigurasi.Pekerjaan.index', compact('pekerjaans'));
    }

    public function create()
    {
        return view('admin.PengaturanDanKonfigurasi.Pekerjaan.create');
    }

    public function store(Request $request)
    {
        // Send request to create a new pekerjaan to Go microservice
        $response = Http::post('http://localhost:8080/pekerjaan', $request->all());

        if ($response->successful()) {
            return redirect()->route('Pekerjaan.index')->with('success', 'Pekerjaan added successfully!');
        } else {
            return redirect()->back()->with('error', 'Failed to add pekerjaan.')->withInput();
        }
    }

    public function edit($id)
    {
        // Fetch pekerjaan by ID from Go microservice
        $response = Http::get("http://localhost:8080/pekerjaan/$id");
        $pekerjaan = $response->json();

        return view('admin.PengaturanDanKonfigurasi.Pekerjaan.edit', compact('pekerjaan'));
    }

    public function update(Request $request, $id)
    {
        // Send request to update pekerjaan to Go microservice
        $response = Http::put("http://localhost:8080/pekerjaan/$id", $request->all());

        if ($response->successful()) {
            return redirect()->route('Pekerjaan.index')->with('success', 'Pekerjaan updated successfully!');
        } else {
            return redirect()->back()->with('error', 'Failed to update pekerjaan.')->withInput();
        }
    }

    public function delete($id)
    {
        // Send request to delete pekerjaan to Go microservice
        $response = Http::delete("http://localhost:8080/pekerjaan/$id");

        if ($response->successful()) {
            return response()->json(['message' => 'Pekerjaan deleted successfully.'], Response::HTTP_OK);
        } else {
            return response()->json(['message' => 'Failed to delete pekerjaan.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function detail(Request $request)
    {
        $id = $request->id;

        $jobData = DB::select('CALL view_Pekerjaan_byId(?)', [$id]);

        if (!empty($jobData)) {
            $job = $jobData[0];
            return response()->json([
                'status' => 200,
                'job' => $job
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Data Pekerjaan Tidak Ditemukan.'
            ]);
        }
    }
}

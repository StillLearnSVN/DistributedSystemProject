<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class JenisStatusController extends Controller
{
    protected $rules = [
        'jenis_status' => 'required',
        'keterangan' => 'nullable'
    ];

    protected $messages = [
        'jenis_status.required' => 'Jenis Status field is required.',
    ];

    public function index()
    {
        // Fetch all jenis status from Go microservice
        $response = Http::get('http://localhost:8084/jenis_status');
        $jenisStatuses = $response->json();

        return view('admin.PengaturanDanKonfigurasi.JenisStatus.index', compact('jenisStatuses'));
    }

    public function create()
    {
        return view('admin.PengaturanDanKonfigurasi.JenisStatus.create');
    }

    public function store(Request $request)
    {
        // Send request to create a new jenis status to Go microservice
        $response = Http::post('http://localhost:8084/jenis_status', $request->all());

        if ($response->successful()) {
            return redirect()->route('JenisStatus.index')->with('success', 'Jenis Status added successfully!');
        } else {
            return redirect()->back()->with('error', 'Failed to add jenis status.')->withInput();
        }
    }

    public function edit($id)
    {
        // Fetch jenis status by ID from Go microservice
        $response = Http::get("http://localhost:8084/jenis_status/$id");
        $jenisStatus = $response->json();

        return view('admin.PengaturanDanKonfigurasi.JenisStatus.edit', compact('jenisStatus'));
    }

    public function update(Request $request, $id)
    {
        // Send request to update jenis status to Go microservice
        $response = Http::put("http://localhost:8084/jenis_status/$id", $request->all());

        if ($response->successful()) {
            return redirect()->route('JenisStatus.index')->with('success', 'Jenis Status updated successfully!');
        } else {
            return redirect()->back()->with('error', 'Failed to update jenis status.')->withInput();
        }
    }

    public function delete($id)
    {
        // Send request to delete jenis status to Go microservice
        $response = Http::delete("http://localhost:8084/jenis_status/$id");

        if ($response->successful()) {
            return response()->json(['message' => 'Jenis Status deleted successfully.'], Response::HTTP_OK);
        } else {
            return response()->json(['message' => 'Failed to delete jenis status.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function detail(Request $request)
    {
        $id = $request->id;

        $jenisStatusData = DB::select('CALL view_JenisStatus_byId(?)', [$id]);

        if (!empty($jenisStatusData)) {
            $jenisStatus = $jenisStatusData[0];
            return response()->json([
                'status' => 200,
                'jenis_status' => $jenisStatus
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Data Jenis Status Tidak Ditemukan.'
            ]);
        }
    }
}


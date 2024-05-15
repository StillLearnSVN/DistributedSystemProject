<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class JemaatController extends Controller
{
    protected $rules = [
        'id_bidang_pendidikan' =>'required|exists:bidang_pendidikan,id_bidang_pendidikan',
        'id_hub_keluarga' =>'required|exists:hubungan_keluarga,id_hub_keluarga',
        'id_pekerjaan' =>'required|exists:pekerjaan,id_pekerjaan',
        'id_pendidikan' =>'required|exists:pendidikan,id_pendidikan',
        'subdis_id' => 'required|exists:subdistricts,subdis_id',
        'id_gereja' => 'required|exists:gereja,id_gereja',
        'id_wijk' => 'required|exists:wijk,id_wijk',
        'id_status_pernikahan' =>'required|exists:status,id_status',
        'id_status_ama_ina' =>'required|exists:status,id_status',
        'id_status_anak' =>'required|exists:status,id_status',
        'nama_depan' => 'required',
        'nama_belakang' => 'required',
        'tempat_lahir' => 'required',
        'tanggal_lahir' => 'required|date',
        'jenis_kelamin' => ['required','in:Laki-laki,Perempuan'],
        'foto_jemaat' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
    ];

    protected $messages = [
        'id_bidang_pendidikan.exists' => 'Selected Bidang Pendidikan does not exist.',
        'id_hub_keluarga.exists' => 'Selected Hubungan Keluarga does not exist.',
        'id_pekerjaan.exists' => 'Selected Pekerjaan does not exist.',
        'id_pendidikan.exists' => 'Selected Pendidikan does not exist.',
        'subdis_id.exists' => 'Selected Subdistrict ID does not exist.',
        'id_gereja.exists' => 'Selected Gereja ID does not exist.',
        'id_wijk.exists' => 'Selected Wijk ID does not exist.',
        'id_status_pernikahan.exists' => 'Selected Status Pernikahan does not exist.',
        'id_status_ama_ina.exists' => 'Selected Status Ama Ina does not exist.',
        'id_status_anak.exists' => 'Selected Status Anak does not exist.',
        'id_bidang_pendidikan.required' => 'Bidang Pendidikan ID is required.',
        'id_hub_keluarga.required' => 'Hubungan Keluarga ID is required.',
        'id_pekerjaan.required' => 'Pekerjaan ID is required.',
        'id_pendidikan.required' => 'Pendidikan ID is required.',
        'subdis_id.required' => 'Subdistrict ID is required.',
        'id_gereja.required' => 'Gereja ID is required.',
        'id_wijk.required' => 'Wijk ID is required.',
        'id_status_pernikahan.required' => 'Status Pernikahan ID is required.',
        'id_status_ama_ina.required' => 'Status Ama Ina ID is required.',
        'id_status_anak.required' => 'Status Anak ID is required.',
        'nama_depan.required' => 'Nama Depan field is required.',
        'nama_belakang.required' => 'Nama Belakang field is required.',
        'tempat_lahir.required' => 'Tempat Lahir field is required.',
        'tanggal_lahir.required' => 'Tanggal Lahir field is required.',
        'tanggal_lahir.date' => 'Tanggal Lahir must be a valid date.',
        'jenis_kelamin.required' => 'Jenis Kelamin field is required.',
        'jenis_kelamin.in' => 'Jenis Kelamin must be either Laki-laki or Perempuan.',
        'foto_jemaat.image' => 'Foto Jemaat must be an image.',
        'foto_jemaat.mimes' => 'Foto Jemaat must be a file of type: jpeg, png, jpg, gif.',
        'foto_jemaat.max' => 'Foto Jemaat may not be greater than 2048 kilobytes.',
    ];

    public function index()
    {
        $jemaats = DB::select('CALL viewAll_Jemaat()');
        return view('admin.DataMaster.Jemaat.index', compact('jemaats'));
    }

    public function create()
    {
        // Fetch data needed for dropdowns or other inputs
        $hubunganKeluargas = DB::select('CALL viewAll_HubunganKeluarga()');
        $statuses = DB::select('CALL viewAll_Status()');
        // $pendidikans = DB::select('CALL viewAll_Pendidikan()');
        $responsePendidikan = Http::get('http://localhost:8083/pendidikan');
        $pendidikans = $responsePendidikan->json();
        $bidangPendidikans = DB::select('CALL viewAll_BidangPendidikan()');
        $pekerjaans = DB::select('CALL viewAll_Pekerjaan()');
        $subdistricts = DB::select('CALL viewAll_Subdistricts()');
        $gerejas = DB::select('CALL viewAll_Gereja()');
        $wijks = DB::select('CALL viewAll_Wijk()');

        return view('admin.DataMaster.Jemaat.create', compact('hubunganKeluargas', 'statuses', 'pendidikans', 'bidangPendidikans', 'pekerjaans', 'subdistricts', 'gerejas', 'wijks'));
    }

    public function store(Request $request)
    {
        $validator =     Validator::make($request->all(), $this->rules, $this->messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Build JSON object from request data
        $jemaat = json_encode([
            'id_bidang_pendidikan' => $request->id_bidang_pendidikan ?? null,
            'id_hub_keluarga' => $request->id_hub_keluarga ?? null,
            'id_pekerjaan' => $request->id_pekerjaan ?? null,
            'id_pendidikan' => $request->id_pendidikan ?? null,
            'subdis_id' => $request->subdis_id ?? null,
            'id_gereja' => $request->id_gereja ?? null,
            'id_wijk' => $request->id_wijk ?? null,
            'id_status_pernikahan' => $request->id_status_pernikahan ?? null,
            'id_status_ama_ina' => $request->id_status_ama_ina ?? null,
            'id_status_anak' => $request->id_status_anak ?? null,
            'nama_depan' => $request->nama_depan,
            'nama_belakang' => $request->nama_belakang,
            'gelar_depan' => $request->gelar_depan,
            'gelar_belakang' => $request->gelar_belakang,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'gol_darah' => $request->gol_darah,
            'alamat' => $request->alamat,
            'no_telepon' => $request->no_telepon,
            'no_ponsel' => $request->no_ponsel,
            'foto_jemaat' => $request->foto_jemaat,
            'keterangan' => $request->keterangan,
            // 'isBaptis' => $request->isBaptis ?? null,
            // 'isSidi' => $request->isSidi ?? null,
            // 'isMenikah' => $request->isMenikah ?? null,
            // 'isMeninggal' => $request->isMeninggal ?? null,
            // 'isRPP' => $request->isRPP ?? null,
        ]);

        // Call stored procedure to insert jemaat
        DB::statement('CALL insert_jemaat(?)', [$jemaat]);

        return redirect()->route('Jemaat.index')->with('success', 'Jemaat added successfully!');
    }

    public function edit($id)
    {
        // Fetch jemaat data for editing
        $jemaatData = DB::select('CALL view_Jemaat_byId(?)', [$id]);

        if (empty($jemaatData)) {
            return redirect()->route('Jemaat.index')->with('error', 'Jemaat not found!');
        }

        $jemaat = $jemaatData[0];
        $hubunganKeluargas = DB::select('CALL viewAll_HubunganKeluarga()');
        $statuses = DB::select('CALL viewAll_Status()');
        $pendidikans = DB::select('CALL viewAll_Pendidikan()');
        $bidangPendidikans = DB::select('CALL viewAll_BidangPendidikan()');
        $pekerjaans = DB::select('CALL viewAll_Pekerjaan()');
        $subdistricts = DB::select('CALL viewAll_Subdistricts()');
        $gerejas = DB::select('CALL viewAll_Gereja()');
        $wijks = DB::select('CALL viewAll_Wijk()');

        return view('admin.DataMaster.Jemaat.edit', compact('jemaat', 'hubunganKeluargas', 'statuses', 'pendidikans', 'bidangPendidikans', 'pekerjaans', 'subdistricts', 'gerejas', 'wijks'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), $this->rules, $this->messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Build JSON object from request data
        $jemaat = json_encode([
            'id_jemaat' => $id,
            'id_bidang_pendidikan' => $request->id_bidang_pendidikan ?? null,
            'id_hub_keluarga' => $request->id_hub_keluarga ?? null,
            'id_pekerjaan' => $request->id_pekerjaan ?? null,
            'id_pendidikan' => $request->id_pendidikan ?? null,
            'subdis_id' => $request->subdis_id ?? null,
            'id_gereja' => $request->id_gereja ?? null,
            'id_wijk' => $request->id_wijk ?? null,
            'id_status_pernikahan' => $request->id_status_pernikahan ?? null,
            'id_status_ama_ina' => $request->id_status_ama_ina ?? null,
            'id_status_anak' => $request->id_status_anak ?? null,
            'nama_depan' => $request->nama_depan,
            'nama_belakang' => $request->nama_belakang,
            'gelar_depan' => $request->gelar_depan,
            'gelar_belakang' => $request->gelar_belakang,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'gol_darah' => $request->gol_darah,
            'alamat' => $request->alamat,
            'no_telepon' => $request->no_telepon,
            'no_ponsel' => $request->no_ponsel,
            'foto_jemaat' => $request->foto_jemaat,
            'keterangan' => $request->keterangan,
            // 'isBaptis' => $request->isBaptis ?? null,
            // 'isSidi' => $request->isSidi ?? null,
            // 'isMenikah' => $request->isMenikah ?? null,
            // 'isMeninggal' => $request->isMeninggal ?? null,
            // 'isRPP' => $request->isRPP ?? null,
        ]);

        // Call stored procedure to update jemaat
        DB::statement('CALL update_jemaat(?)', [$jemaat]);

        return redirect()->route('Jemaat.index')->with('success', 'Jemaat updated successfully!');
    }

    public function delete(Request $request)
    {
        $id = $request->id;

        $jemaat = DB::select('CALL view_Jemaat_byId(?)', [$id]);

        if (empty($jemaat)) {
            return response()->json([
                'status' => 404,
                'message' => 'Jemaat not found.'
            ]);
        }

        // Call stored procedure to delete jemaat
        DB::statement('CALL delete_jemaat(?)', [$id]);

        return response()->json([
            'status' => 200,
            'message' => 'Jemaat deleted successfully.'
        ]);
    }

    public function detail(Request $request)
    {
        $id = $request->id;

        $jemaatData = DB::select('CALL view_Jemaat_byId(?)', [$id]);

        if (!empty($jemaatData)) {
            $jemaat = $jemaatData[0];
            return response()->json([
                'status' => 200,
                'jemaat' => $jemaat
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Jemaat data not found.'
            ]);
        }
    }
}

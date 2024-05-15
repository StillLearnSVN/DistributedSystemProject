<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DistrictsController extends Controller
{
    protected $rules = [
        'city_id' => 'required|exists:city,city_id',
        'dis_name' => 'required',
    ];

    protected $messages = [
        'city_id.required' => 'City ID field is required.',
        'dis_name.required' => 'District name field is required.',
    ];

    public function index()
    {
        $districts = DB::select('CALL viewAll_Districts()');
        return view('admin.PengaturanDanKonfigurasi.Districts.index', compact('districts'));
    }

    public function create()
    {
        $cities = DB::select('CALL viewAll_City()');
        return view('admin.PengaturanDanKonfigurasi.Districts.create', compact('cities'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules, $this->messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $district = json_encode([
            'city_id' => $request->city_id,
            'dis_name' => $request->dis_name,
        ]);

        DB::statement('CALL insert_district(?)', [$district]);

        return redirect()->route('Districts.index')->with('success', 'District added successfully!');
    }

    public function edit($id)
    {
        $district = DB::select('CALL view_District_byId(?)', [$id]);

        if (empty($district)) {
            return redirect()->route('Districts.index')->with('error', 'District not found!');
        }

        $district = $district[0];
        $cities = DB::select('CALL viewAll_City()');
        return view('admin.PengaturanDanKonfigurasi.Districts.edit', compact('district', 'cities'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), $this->rules, $this->messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $district = json_encode([
            'dis_id' => $id,
            'city_id' => $request->city_id,
            'dis_name' => $request->dis_name,
        ]);

        DB::statement('CALL update_district(?)', [$district]);

        return redirect()->route('Districts.index')->with('success', 'District updated successfully!');
    }

    public function delete(Request $request)
    {
        $id = $request->id;

        $district = DB::select('CALL view_District_byId(?)', [$id]);

        if (empty($district)) {
            return response()->json([
                'status' => 404,
                'message' => 'District not found.'
            ]);
        }

        DB::statement('CALL delete_district(?)', [$id]);

        return response()->json([
            'status' => 200,
            'message' => 'District deleted successfully.'
        ]);
    }

    public function detail(Request $request)
    {
        $id = $request->id;

        $districtData = DB::select('CALL view_District_byId(?)', [$id]);

        if (!empty($districtData)) {
            $district = $districtData[0];
            return response()->json([
                'status' => 200,
                'district' => $district
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'District data not found.'
            ]);
        }
    }
}

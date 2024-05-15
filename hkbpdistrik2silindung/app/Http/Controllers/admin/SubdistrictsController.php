<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SubdistrictsController extends Controller
{
    protected $rules = [
        'dis_id' => 'required|exists:districts,dis_id',
        'subdis_name' => 'required',
    ];

    protected $messages = [
        'dis_id.required' => 'District ID field is required.',
        'subdis_name.required' => 'Subdistrict name field is required.',
    ];

    public function index()
    {
        $subdistricts = DB::select('CALL viewAll_Subdistricts()');
        return view('admin.PengaturanDanKonfigurasi.Subdistricts.index', compact('subdistricts'));
    }

    public function create()
    {
        $districts = DB::select('CALL viewAll_Districts()');
        return view('admin.PengaturanDanKonfigurasi.Subdistricts.create', compact('districts'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules, $this->messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $subdistrict = json_encode([
            'dis_id' => $request->dis_id,
            'subdis_name' => $request->subdis_name,
        ]);

        DB::statement('CALL insert_subdistrict(?)', [$subdistrict]);

        return redirect()->route('Subdistricts.index')->with('success', 'Subdistrict added successfully!');
    }

    public function edit($id)
    {
        $subdistrict = DB::select('CALL view_Subdistrict_byId(?)', [$id]);

        if (empty($subdistrict)) {
            return redirect()->route('Subdistricts.index')->with('error', 'Subdistrict not found!');
        }

        $subdistrict = $subdistrict[0];
        $districts = DB::select('CALL viewAll_Districts()');
        return view('admin.PengaturanDanKonfigurasi.Subdistricts.edit', compact('subdistrict', 'districts'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), $this->rules, $this->messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $subdistrict = json_encode([
            'subdis_id' => $id,
            'dis_id' => $request->dis_id,
            'subdis_name' => $request->subdis_name,
        ]);

        DB::statement('CALL update_subdistrict(?)', [$subdistrict]);

        return redirect()->route('Subdistricts.index')->with('success', 'Subdistrict updated successfully!');
    }

    public function delete(Request $request)
    {
        $id = $request->id;

        $subdistrict = DB::select('CALL view_Subdistrict_byId(?)', [$id]);

        if (empty($subdistrict)) {
            return response()->json([
                'status' => 404,
                'message' => 'Subdistrict not found.'
            ]);
        }

        DB::statement('CALL delete_subdistrict(?)', [$id]);

        return response()->json([
            'status' => 200,
            'message' => 'Subdistrict deleted successfully.'
        ]);
    }

    public function detail(Request $request)
    {
        $id = $request->id;

        $subdistrictData = DB::select('CALL view_Subdistrict_byId(?)', [$id]);

        if (!empty($subdistrictData)) {
            $subdistrict = $subdistrictData[0];
            return response()->json([
                'status' => 200,
                'subdistrict' => $subdistrict
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Subdistrict data not found.'
            ]);
        }
    }
}

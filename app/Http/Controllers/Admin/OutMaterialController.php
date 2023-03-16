<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OutcomeMaterial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\OutcomeImport;

class OutMaterialController extends Controller
{
    public function index()
    {
        return view('admin.outcomes.index');
    }

    public function show()
    {
        return datatables()->of(
            OutcomeMaterial::query()->orderBy('id', 'asc')
        )->toJson();
    }


    public function destroy(Request $req)
    {
        DB::beginTransaction();
        $e_good = OutcomeMaterial::where('id', $req->id)->delete();
        $data = [
            'title' => 'Success',
            'msg' => 'delete success',
            'status' => 'success',
        ];

        DB::commit();
        return $data;
    }


    public function upload(Request $req)
    {

        $this->validate($req, ['select_file' => 'required|mimes:xlx,xlsx,csv,txt,xls']);
        $file = $req->file('select_file');

        $token = Excel::import(new OutcomeImport, $file);

        return back()->with('success', 'Excel data imported successfully!');
    }
   
}

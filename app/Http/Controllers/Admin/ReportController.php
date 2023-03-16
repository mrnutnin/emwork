<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DrivingLicenseTest;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        return view('admin.report');
    }

   
    public function show(Request $req)
    {

        $data =  DrivingLicenseTest::with('drivingLicenseBodyTests', 'drivingLicenseTheoryTests', 'drivingLicensePracticeTests');

        if($req->firstname){
            $data = $data->where('firstname', 'like', '%' . $req->firstname . '%');
        }

        if ($req->lastname) {
            $data = $data->where('lastname', 'like', '%' . $req->lastname . '%');
        }

        if ($req->date) {
            $data = $data->whereDate('created_at', $req->date);
        }
       
 
        return datatables()->of($data)->toJson();
    }
    

}

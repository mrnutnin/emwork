<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DrivingLicenseTest;
use App\Models\IncomeMaterial;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }

    public function show()
    {
        return datatables()->of(
            DrivingLicenseTest::query()
        )->toJson();
    }


}

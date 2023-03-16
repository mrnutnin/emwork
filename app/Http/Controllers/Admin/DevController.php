<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\Customer;
use App\Models\Order;
use App\Models\WarrantyRegistration;
use Illuminate\Http\Request;

class DevController extends Controller
{
    public function index()
    {
    
        return view('admin.devs.index');
    }

}

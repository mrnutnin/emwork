<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DrivingLicenseBodyTest;
use App\Models\DrivingLicensePracticeTest;
use App\Models\DrivingLicenseTest;
use App\Models\DrivingLicenseTheoryTest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }

    public function show()
    {
        return datatables()->of(
            DrivingLicenseTest::query()->with('drivingLicenseBodyTests', 'drivingLicenseTheoryTests', 'drivingLicensePracticeTests')
        )->toJson();
    }


    public function store(Request $req)
    {

        DB::beginTransaction();


        if($req->dt_id == null && $req->dt_id == ''){

            $dlt = new DrivingLicenseTest;
            $dlt->firstname = @$req->firstname;
            $dlt->lastname = @$req->lastname;
            $dlt->status = 'W';
            $dlt->save();

            //body1 = ทดสอบตาบอดสี
            //body2 = ทดสอบสายตายาว
            //body3 = ทดสอบสายตาเอียง
            //body4 = ทดสอบร่างกาน
            foreach ($req->body as $key => $value) {
                $b_name = '';
                switch ($key) {
                    case 0:
                        $b_name = 'ทดสอบตาบอดสี';
                        break;
                    case 1:
                        $b_name = 'ทดสอบสายตายาว';
                        break;
                    case 2:
                        $b_name = 'ทดสอบสายตาเอียง';
                        break;
                    case 3:
                        $b_name = 'ทดสอบร่างกาย';
                        break;
                    default:
                        $b_name = '';
                        break;
                }
                $dlbt = new DrivingLicenseBodyTest;
                $dlbt->driving_license_test_id = $dlt->id;
                $dlbt->name = $b_name;
                $dlbt->status = $value;
                $dlbt->save();
            }

            foreach ($req->theory as $key => $value) {
                $t_name = '';
                switch ($key) {
                    case 0:
                        $t_name = 'ป้ายจราจร';
                        break;
                    case 1:
                        $t_name = 'เส้นจราจร';
                        break;
                    case 2:
                        $t_name = 'การให้ทาง';
                        break;
                    default:
                        $t_name = '';
                        break;
                }
                $dltt = new DrivingLicenseTheoryTest;
                $dltt->driving_license_test_id = $dlt->id;
                $dltt->name = $t_name;
                $dltt->score = $value;
                $dltt->save();
            }

            $dlpt = new DrivingLicensePracticeTest;
            $dlpt->driving_license_test_id = $dlt->id;
            $dlpt->name = 'การสอบปฏิบัติ';
            $dlpt->status = @$req->practice;
            $dlpt->save();

            $this->updateStatus($dlt->id);

            $data = [
                'title' => 'สำเร็จ',
                'msg' => 'บันทึกสำเร็จ',
                'status' => 'success',
            ];


        }else{

            $dlt =  DrivingLicenseTest::find($req->dt_id);
            
            if($dlt){
                $dlt->firstname = @$req->firstname;
                $dlt->lastname = @$req->lastname;
                $dlt->save();


                foreach ($req->body as $key => $value) {
                    $b_name = '';
                    switch ($key) {
                        case 0:
                            $b_name = 'ทดสอบตาบอดสี';
                            break;
                        case 1:
                            $b_name = 'ทดสอบสายตายาว';
                            break;
                        case 2:
                            $b_name = 'ทดสอบสายตาเอียง';
                            break;
                        case 3:
                            $b_name = 'ทดสอบร่างกาย';
                            break;
                        default:
                            $b_name = '';
                            break;
                    }
                    $dlbt =  DrivingLicenseBodyTest::where('driving_license_test_id', $req->dt_id)->where('name', $b_name)->first();
                    $dlbt->status = $value;
                    $dlbt->save();
                }


                foreach ($req->theory as $key => $value) {
                    $t_name = '';
                    switch ($key) {
                        case 0:
                            $t_name = 'ป้ายจราจร';
                            break;
                        case 1:
                            $t_name = 'เส้นจราจร';
                            break;
                        case 2:
                            $t_name = 'การให้ทาง';
                            break;
                        default:
                            $t_name = '';
                            break;
                    }
    
                    $dltt = DrivingLicenseTheoryTest::where('driving_license_test_id', $req->dt_id)->where('name', $t_name)->first();
                    $dltt->driving_license_test_id = $dlt->id;
                    $dltt->name = $t_name;
                    $dltt->score = $value;
                    $dltt->save();
                }

                $dlpt = DrivingLicensePracticeTest::where('driving_license_test_id', $req->dt_id)->where('name', 'การสอบปฏิบัติ')->first();
                $dlpt->driving_license_test_id = $dlt->id;
                $dlpt->status = @$req->practice;
                $dlpt->save();

                $this->updateStatus($dlt->id);


                $data = [
                    'title' => 'สำเร็จ',
                    'msg' => 'แก้ไขสำเร็จ',
                    'status' => 'success',
                ];

            }
        }

     
        DB::commit();

    
        return $data;
    }

    public function update(Request $req)
    {

        DB::beginTransaction();



        DB::commit();

        $data = [
            'title' => 'สำเร็จ',
            'msg' => 'แก้ไขสำเร็จ',
            'status' => 'success',
        ];

        return $data;
    }

    public function destroy(Request $req)
    {

        $id = $req->id;
        $dt = DrivingLicenseTest::find($id);
        if ($dt) {
            DrivingLicenseTest::find($id)->delete();
            DrivingLicenseBodyTest::where('driving_license_test_id', $id)->delete();
            DrivingLicenseTheoryTest::where('driving_license_test_id', $id)->delete();
            DrivingLicensePracticeTest::where('driving_license_test_id', $id)->delete();
        
            $data = [
                'title' => 'สำเร็จ!',
                'msg' => 'ลบข้อมูลสำเร็จ',
                'status' => 'success',
            ];

            return $data;
        } else {

            $data = [
                'title' => 'ไม่สำเร็จ!',
                'msg' => 'ลบข้อมูลไม่สำเร็จ',
                'status' => 'error',
            ];

            return $data;
        }
    }

    public function updateStatus($id)
    {
        $dlt = DrivingLicenseTest::find($id);

        $b_test = false;
        $t_test = false;
        $p_test = false;

        $check_count_body_f = DrivingLicenseBodyTest::where('driving_license_test_id', $id)->where('status', 'F')->count();
        if ($check_count_body_f >= 2) {
            $dlt->status = 'F';
            $dlt->save();
            return true;
        }
        
        $check_b_have_w = DrivingLicenseBodyTest::where('driving_license_test_id', $id)->where('status', 'W')->first();

        if($check_b_have_w){
            $dlt->status = 'W';
            $dlt->save();
            return true;
        }

        $check_t_have_zero = DrivingLicenseTheoryTest::where('driving_license_test_id', $id)->where('score', 0)->first();

        if ($check_t_have_zero) {
            $dlt->status = 'W';
            $dlt->save();
            return true;
        }


        $check_p_have_w = DrivingLicensePracticeTest::where('driving_license_test_id', $id)->where('status', 'W')->first();

        if ($check_p_have_w) {
            $dlt->status = 'W';
            $dlt->save();
            return true;
        }

        //Body Test
        $count_body_p = DrivingLicenseBodyTest::where('driving_license_test_id', $id)->where('status', 'P')->count();
        if($count_body_p >= 3){
            $b_test = true;
        }

        //Theory Test
        $sum_t = DrivingLicenseTheoryTest::where('driving_license_test_id', $id)->sum('score');
        if($sum_t >= 120){
            $t_test = true;
        }

        //Practice Test
        $p_t = DrivingLicensePracticeTest::where('driving_license_test_id', $id)->where('status', 'P')->first();
        if ($p_t) {
            $p_test = true;
        }

        // dd($b_test, $t_test, $p_test, $p_t);
        if($b_test && $t_test && $p_test)
        {
            $dlt->status = 'P';
        }else{
            $dlt->status = 'F';
        }
        $dlt->save();

        return true;

    }

}

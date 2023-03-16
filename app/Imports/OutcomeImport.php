<?php

namespace App\Imports;
use App\Models\OutcomeMaterial;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class OutcomeImport implements ToCollection
{
    /**
     * @param Collection $collection
     */

    public function  __construct()
    {
    
    }

    public function collection(Collection $rows)
    {

        if (!isset($rows[0])) {
            throw ValidationException::withMessages(["status" => 'รูปแบบ​ Excel ไม่ถูกต้อง!']);
        }
        // if (sizeof($rows[0]) != 11) {
        //     throw ValidationException::withMessages(["status" => 'จำนวน Column Excel ไม่ถูกต้อง!']);
        // }
      
        unset($rows[0]);
        $array_text = [];
       
       
        foreach ($rows as $row) {

            $r = OutcomeMaterial::where('invoice_no', $row[5])
                ->where('material_no', $row[7])
                ->first();
            
            if($r){
                $text = 'job_no : ' .  $row[1] . ' | serial_no : ' . $row[3] . ' | invoice_no : ' . $row[5] . ' | material_no : ' . $row[7] ;
                array_push($array_text, $text);
            }
        }
       
        if($array_text){
            throw ValidationException::withMessages(["status" => $array_text]);
        }

        DB::beginTransaction();

        foreach ($rows as $row) {

           
            $new = new OutcomeMaterial;
            $new->job_no = $row[1];
            $new->model = $row[2];
            $new->serial_no = $row[3];
            $new->customer_name = $row[4];
            $new->invoice_no = $row[5];
            $new->ref_no = $row[6];
            $new->material_no = $row[7];
            $new->price = $row[8];
            $new->qty = $row[9] * (-1);
            $new->total = $row[8] * $row[9];
            // $new->type = $row[11];
            $new->save();
              
          
        }

        DB::commit();
    }

}

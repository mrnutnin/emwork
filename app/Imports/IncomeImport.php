<?php

namespace App\Imports;
use App\Models\IncomeMaterial;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class IncomeImport implements ToCollection
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
        // if (sizeof($rows[0]) != 8) {
        //     throw ValidationException::withMessages(["status" => 'จำนวน Column Excel ไม่ถูกต้อง!']);
        // }
      
        unset($rows[0]);
        $array_text = [];
       
       
        foreach ($rows as $row) {
            // dd($row);
            $r = IncomeMaterial::where('material_no', $row[3])
                ->where('invoice_no', $row[6])
                ->first();
            
            if($r){
                $text = 'order_no : ' .  $row[0] . ' | job_no : ' . $row[1] . ' | material_no : ' . $row[3] . ' | invoice_no : ' . $row[6] ;
                array_push($array_text, $text);
            }
        }
       
        if($array_text){
            throw ValidationException::withMessages(["status" => $array_text]);
        }

        DB::beginTransaction();

        foreach ($rows as $row) {

            $po_date =  @Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[2]))->format('Y-m-d');
            $doc_date =  @Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[7]))->format('Y-m-d');
           
            $new = new IncomeMaterial;
            $new->order_no = $row[0];
            $new->job_no = $row[1];
            $new->po_date = $po_date;
            $new->material_no = $row[3];
            $new->material_desc = $row[4];
            $new->qty = $row[5];
            $new->invoice_no = $row[6];
            $new->doc_date = $doc_date;
            $new->save();
              
          
        }

        DB::commit();
    }

}

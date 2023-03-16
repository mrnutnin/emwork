<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\SoftDeletes;

class IncomeMaterial extends Model
{
    use Compoships, SoftDeletes;
    

    public function outcomeMatetials()
    {
        return $this->hasMany(OutcomeMaterial::class, ['invoice_no', 'material_no'], ['invoice_no', 'material_no']);
    }
}

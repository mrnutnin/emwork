<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DrivingLicenseTest extends Model
{
    use HasFactory;

    public function drivingLicenseBodyTests()
    {
        return $this->hasMany(DrivingLicenseBodyTest::class, 'driving_license_test_id', 'id');
    }

    public function drivingLicensePracticeTests()
    {
        return $this->hasMany(DrivingLicensePracticeTest::class, 'driving_license_test_id', 'id');
    }

    public function drivingLicenseTheoryTests()
    {
        return $this->hasMany(DrivingLicenseTheoryTest::class, 'driving_license_test_id', 'id');
    }
}

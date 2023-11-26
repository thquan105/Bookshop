<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;
    protected $table = 'bills'; // Tên bảng tương ứng trong cơ sở dữ liệu

    protected $fillable = [
        'FirstName',
        'LastName',
        'Email',
        'MobileNo',
        'Address1',
        'Address2',
        'Country',
        'City', 
        'State',
        'ZipCode',
        'total_amount',
    ];

    public $timestamps = true;
}

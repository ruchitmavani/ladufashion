<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bills extends Model
{
    use HasFactory;
    protected $fillable = ['party_id', 'name', 'address', 'state', 'gst', 'bill_date', 'due_date', 'bill_no', 'shipping', 'shipping_address', 'shipping_place', 'challan', 'challan_date', 'products', 'total_amount', 'discount', 'cgst', 'sgst', 'igst', 'final_amount', 'bank', 'account_no', 'ifsc', 'file_name'];
}

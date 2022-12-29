<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
  use HasFactory;
  use SoftDeletes;
  protected $guarded = [];

  public function customertype()
  {
    return $this->belongsTo(CustomerType::class, 'customer_type_id');
  }
}

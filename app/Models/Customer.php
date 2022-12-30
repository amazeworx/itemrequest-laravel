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

  public function currentsalesman()
  {
    return $this->belongsTo(User::class, 'current_salesman_id')->withTrashed();
  }

  public function user()
  {
    return $this->belongsTo(User::class, 'user_id')->withTrashed();
  }
}

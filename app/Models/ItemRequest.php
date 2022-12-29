<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ItemRequest extends Model
{
  use HasFactory;
  use SoftDeletes;
  protected $guarded = [];

  public function customer()
  {
    return $this->belongsTo(Customer::class, 'customer_id');
  }

  public function product()
  {
    return $this->belongsTo(Product::class, 'product_id');
  }

  public function salesman()
  {
    return $this->belongsTo(User::class, 'salesman_id');
  }

  public function status()
  {
    return $this->belongsTo(StatusRequest::class, 'status_id');
  }
}

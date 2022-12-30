<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ProductsImport implements ToModel, WithStartRow
{

  private $user_id;

  public function  __construct($user_id)
  {
    $this->user_id = $user_id;
  }

  public function startRow(): int
  {
    return 2;
  }

  /**
   * @param array $row
   *
   * @return \Illuminate\Database\Eloquent\Model|null
   */
  public function model(array $row)
  {

    return new Product([
      'sku' => $row[0],
      'name' => $row[1],
      'brand' => $row[2],
      'year' => $row[3],
      'cc' => $row[4],
      'engine' => $row[5],
      'price_buy' => $row[6],
      'price_resell' => $row[7],
      'price_retail' => $row[8],
      'notes' => $row[9],
      'user_id' => $this->user_id
    ]);
  }
}

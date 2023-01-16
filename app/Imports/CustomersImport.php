<?php

namespace App\Imports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class CustomersImport implements ToModel, WithStartRow
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
    $phone = preg_replace('/[^A-Za-z0-9\-]/', '', $row[1]);
    $existing = $row[7];
    if ($existing == NULL) {
      $existing = 0;
    }
    return new Customer([
      'name' => $row[0],
      'phone' => $phone,
      'existing' => $existing,
      'customer_type_id' => $row[3],
      'current_salesman_id' => $row[5],
      'previous_salesman' => $row[6],
      'notes' => $row[8],
      'user_id' => $this->user_id
    ]);
  }
}

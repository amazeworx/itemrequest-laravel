<?php

namespace App\Imports;

use App\Models\ItemRequest;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
//use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use DateTime;

class ItemRequestsImport implements ToModel, WithStartRow
{

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
    $request_date = DateTime::createFromFormat('d-m-Y', $row[1])->format('Y-m-d');

    return new ItemRequest([
      'request_code' => $row[0],
      'request_date' => $request_date,
      'product_id' => $row[2],
      'customer_id' => $row[3],
      'salesman_id' => $row[4],
      'status_id' => $row[5],
      'user_id' => $row[4],
    ]);
  }
}

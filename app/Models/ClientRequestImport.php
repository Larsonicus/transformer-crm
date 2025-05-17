<?php

namespace App\Models;

use Maatwebsite\Excel\Concerns\ToModel;

class ClientRequestImport implements ToModel
{
   public function model(array $row): ClientRequest
   {
       return new ClientRequest([
           'id' => $row[0],
           'title' => $row[1],
           'description' => $row[2],
           'user_id' => $row[3],
           'partner_id' => $row[4],
           'source_id' => $row[5],
           'status' => $row[6],
           'created_at' => $row[7],
           'updated_at' => $row[8],
       ]);
   }
}

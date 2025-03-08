<?php

namespace App\Imports;

use App\Models\Site;
use Maatwebsite\Excel\Concerns\ToModel;

class ImportSite implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $existingSite = Site::where('url', $row[0])->first();

        if ($existingSite) {
            return null;
        }

        return new Site([
            'url' => $row[0],
        ]);
    }
}

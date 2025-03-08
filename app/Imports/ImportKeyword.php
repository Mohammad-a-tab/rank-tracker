<?php

namespace App\Imports;

use App\Models\Keyword;
use App\Models\KeywordsVolumes;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class ImportKeyword implements ToModel, WithChunkReading, ShouldQueue
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $keywordsNames      = $row[0];
        $keywordsUrls       = $row[6];
        $keywordsVolumes    = $row[8];
        $existingKeyword    = Keyword::query()->where('name', $row[0])->first();

        if(is_null($keywordsVolumes) || $keywordsVolumes == '-') {
            $keywordsVolumes = 50;
        }
        DB::beginTransaction();
        try {
            if ($existingKeyword) {
                $existingKeyword->update([
                    'keyword_url'       => $keywordsUrls,
                    'keyword_volume'    => $keywordsVolumes,
                ]);
            }
            else{
                 Keyword::create([
                    'name'              => $keywordsNames,
                    'keyword_url'       => $keywordsUrls,
                    'keyword_volume'    => $keywordsVolumes
                ]);
            }
            DB::commit();
        }catch (\Throwable $exception){
            DB::rollBack();
            logger()->error("An Error Happened While Inserting Keywords And Keywords Volumes : " .$exception->getMessage());
        }
        return null;
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}

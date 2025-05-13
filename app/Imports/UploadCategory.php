<?php

namespace App\Imports;

use App\Models\Inventory\Master\MasterInvCategory;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class UploadCategory implements ToCollection
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function startRow(): int
    {
        return 2;
    }
    public function collection(Collection $rows)
    {
        unset($rows[0]);
        $post_array =[];
        foreach($rows as $row){
            $validation_1 = MasterInvCategory :: where([
                'type_id'   => $row[0],
                'name'      => $row[1]
            ])->count();
            if($validation_1 == 0){
                $post =[
                    'name' =>$row[1],
                    'type_id' =>$row[0],
                ];
                array_push($post_array,$post);
            }
        }
        MasterInvCategory::insert($post_array);
    }
}

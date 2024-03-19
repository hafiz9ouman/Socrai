<?php

namespace App\Imports;

use App\CodesData;
// use App\User;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Throwable;

class ProjectsImport implements ToModel, WithHeadingRow, SkipsOnError

{
    use Importable, SkipsErrors;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

        dd($row);
    }
    public function onError(Throwable $error)
    {

    }
}

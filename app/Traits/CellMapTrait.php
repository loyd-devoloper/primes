<?php
namespace App\Traits;

use Illuminate\Support\Facades\Crypt;

trait CellMapTrait{

    public function cellMapWithStyle($sheet, $db, $columnName, $cell, $type, $fontSize, $horAlign = true)
    {

        if ($type == 1) {
            $value = !!$db->$columnName ? $db->$columnName : 'N/A';
        } else if ($type == 2) {
            $value =  !!$db->$columnName ? Crypt::decryptString($db->$columnName) : 'N/A';
        }
        $uValue = strtoupper($value);
        return [
            $sheet->setCellValue($cell, " $uValue"),

        ];
    }
    public function checkBoxCell($sheet, $db, $column, $cell, $value = '')
    {


        $value == $db->$column ? $status = True : $status = False;


        return [
            $sheet->setCellValue($cell, $status),

        ];
    }

}

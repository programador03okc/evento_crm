<?php

namespace App\Imports;

use App\Models\Cliente;
use App\Models\Importacion;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ClientesImport implements ToModel, WithStartRow
{
    private $rows = 0;

    public function __construct(Importacion $importacion){
        $this->importacion = $importacion;
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if (!isset($row[0])) {
            return null;
        }

        ++$this->rows;

        return new Cliente([
            'nombres' => $row[0], 
            'apellidos' => $row[1], 
            'email' => $row[2], 
            'telefono' => $row[3], 
            'dni' => $row[4], 
            'idcampania' => $row[5], 
            'fecharegistro' => $row[6], 
            'coddistrito' => $row[7], 
            'carrera' => $row[8], 
            'evento' => $row[9], 
            'tipoparticipante' => $row[10], 
            'ocupacion' => $row[11], 
            'edad'=> $row[12],
            'grado'=>$row[13], 
            'colegio' => $row[14], 
            'anioegreso' => $row[15],
            'procedencia' => $row[16],
            'utm' => $row[17], 
            'campaign_content' => $row[18],
            'campaign_medium' => $row[19],
            'campaign_name' => $row[20],
            'campaign_source' => $row[21],
            'campaign_term' => $row[22],
            'uuidimportacion' => $this->importacion->uuidimportacion,
        ]);
    }
    public function startRow(): int
    {
        return 2;
    }

    public function getRowCount(): int
    {
        return $this->rows;
    }

}

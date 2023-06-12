<?php

namespace App\Exports;

use App\Models\Cliente;
use App\Util\FilterManager;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class ClientesExport implements FromCollection, WithMapping, WithHeadings
{
    public function __construct(Request $request){
        $this->request = $request;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $filters = FilterManager::getFilters($this->request, new Cliente());

        return Cliente::where($filters)
            ->with('campania','distrito')
            ->orderBy('idcliente', 'DESC')
            ->get();
    }

    /**
    * @var Invoice $invoice
    */
    public function map($model): array
    {
        return [
            $model->idcliente,
            $model->nombres,
            $model->apellidos,
            $model->email,
            $model->telefono,
            $model->dni,
            // $model->idcampania,
            // $model->fecharegistro,
            $model->fecha,
            $model->asistencianame,
            $model->fechapresencia,
            // $model->coddistrito,           
            $model->carrera,
            $model->evento,
            $model->tipoparticipante,
            $model->ocupacion,
            $model->edad,
            $model->grado,
            $model->colegio,
            $model->anioegreso,
            $model->procedencia,
            $model->utm,
            $model->campaign_content,
            $model->campaign_medium,
            $model->campaign_name,
            $model->campaign_source,
            $model->campaign_term,
            // $model->estado,
            $model->statename,
            $model->campania->nombrecampania,
            $model->distrito->nombreubigeo,
        ];
    }

    public function headings(): array
    {
        return [
            'Codigo',
            'Nombres',
            'Apellidos',
            'Email',
            'Telefono',
            'Dni',
            // 'idcampania',
            // 'fecharegistro',
            'Fecha Registro',
            'Asistencia',
            'Fecha Asistencia',
            // 'coddistrito',
            'Carrera',
            'Evento',
            'Tipoparticipante',
            'Ocupacion',
            'Edad',
            'Grado',
            'Colegio',
            'Año de Egreso',
            'Procedencia',
            'Utm',
            'Campaign_content',
            'Campaign_medium',
            'Campaign_name',
            'Campaign_source',
            'Campaign_term',
            // 'estado',
            'Estado',
            'Campaña',
            'Distrito',
        ];
    }
}

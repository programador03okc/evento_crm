<?php

namespace App\Models;

use App\Models\Ubigeo;
use App\Models\Campania;
use App\Util\RuleManager;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'clientes';
    protected $primaryKey = 'idcliente';
    public $timestamps = false;

    protected $fillable = [
            'nombres', 
            'apellidos', 
            'email', 
            'telefono', 
            'dni', 
            'idcampania', 
            'fecharegistro', 
            'coddistrito', 
            'procedencia',
            'utm', 
            'campaign_content',
            'campaign_content',
            'campaign_medium',
            'campaign_name',
            'campaign_source',
            'campaign_term',
            'grado',
            'edad',
            'carrera', 
            'origen',
            'evento',
            'tipoparticipante',
            'ocupacion',
            'especialidad',
            'pais',
            'colegio', 
            'anioegreso', 
            'uuidimportacion', 
            'idtipoatencion',
            'asistencia',
            'fechaasistencia',
            'estado', 
    ];

    protected $hidden = [
        'userinsert', 
        'dateinsert', 
        'userupdate', 
        'dateupdate',
    ];

    protected $casts = [
     'fecharegistro' => 'datetime:Y-m-d H:i:s',
     'fechaasistencia'=> 'datetime:Y-m-d H:i:s',
    ];

    protected $appends = [
        'isactive',
        'statename',
        'fecha',
        'isassistance',
        'asistencianame',
        'fechapresencia'
    ];

    public function getIsactiveAttribute(){
        return RuleManager::getIsActive($this->estado);
    }

    public function getStatenameAttribute(){
        return RuleManager::getStateName($this->estado);
    }
    
    public function getFechaAttribute()
    {
        return optional($this->fecharegistro)->format('d-m-Y');
    }
    public function getfechapresenciaAttribute()
    {
        //return optional($this->fechaasistencia)->format('d-m-Y');
        return (int)optional($this->fechaasistencia)->format('Y') > 1970 ? 
        optional($this->fechaasistencia)->format('d-m-Y') : '';
    }

    public function getIsassistanceAttribute()
    {
        $isassistance = false;

        if($this->asistencia) $isassistance = true; 
        
        return $isassistance;
    }
    
    public function getAsistencianameAttribute()
    {
        $asistencianame = "No";

        if($this->asistencia) $asistencianame = "Si"; 
        
        return $asistencianame;
    }
    
    //para mostrar el nombre y ya no el id en el listado 
    public function campania(){
        return $this->belongsTo(Campania::class, 'idcampania', 'idcampania')
            ->with('cuenta');
    }

    public function distrito(){
        return $this->belongsTo(Ubigeo::class, 'coddistrito', 'pkubigeo')
            ->withDefault([
                'pkubigeo'=>'',
                'fkubigeo'=>'',
                'nombreubigeo'=> '',
                'nivel' => -1,
                'nombrecompleto'=>'',
            ]);
    }

    public function ultimaatencion()
    {
        return $this->hasOne(Atencion::class, 'idcliente', 'idcliente')
            ->withDefault([
                'idcliente'=>'',
                'idtipoatencion'=>1,
                'comentario'=> '',
                'tipoatencion'=>[
                    'tipoatencion' => 'Sin Atender',
                    'color' => 'badge-danger',
                    'idtipoatencion' => 1
                ]
            ])
            ->with('tipoatencion')
            ->orderBy('idatencion', 'desc');
    }
    
}

<?php

namespace App\Models;

use App\Models\Cuenta;
use App\Util\RuleManager;
use Illuminate\Database\Eloquent\Model;

class Campania extends Model
{

    protected $table = 'campanias';
    protected $primaryKey = 'idcampania';
    public $timestamps = false;

    protected $fillable = [
        'nombrecampania',
        'fechainicio',
        'fechafin',
        'idcuenta',
        'estado'
    
    ];
    
    protected $hidden = [
        'userinsert', 
        'dateinsert', 
        'userupdate', 
        'dateupdate',
    ];


    protected $casts = [
        'fechainicio' => 'datetime:Y-m-d H:i:s',
        'fechafin' => 'datetime:Y-m-d H:i:s',
    ];

    protected $appends = [
        'isactive',
        'statename',
        'fecharegistro',
        'horaregistro',
        'fechafinalizada',
        'horafinalizada',
        'fechainicioevento',
        'fechafinevento'
    ];

    public function getIsactiveAttribute(){
        return RuleManager::getIsActive($this->estado);
    }

    public function getStatenameAttribute(){
        return RuleManager::getStateName($this->estado);
    }
    
    public function getFecharegistroAttribute()
    {
        return optional($this->fechainicio)->format('d-m-Y');
    }

    public function getHoraregistroAttribute()
    {
        return optional($this->fechainicio)->format('H:i:s');
    }

    public function getFechafinalizadaAttribute()
    {
        return optional($this->fechafin)->format('d-m-Y');
    }
    
    public function getHorafinalizadaAttribute()
    {
        return optional($this->fechafin)->format('H:i:s');
    }
    public function getFechainicioeventoAttribute()
    {
        return optional($this->fechainicio)->format('m/d/Y H:i:s');
    }
    public function getFechafineventoAttribute()
    {
        return optional($this->fechafin)->format('m/d/Y H:i:s');
    }

    public function cuenta(){
        return $this->belongsTo(Cuenta::class, 'idcuenta', 'idcuenta');
    }

}

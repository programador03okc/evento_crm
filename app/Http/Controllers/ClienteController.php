<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Cliente;
use App\Models\Atencion;
use App\Util\RuleManager;
use App\Util\ResultManager;
use Illuminate\Http\Request;
use App\Util\LogErrorManager;
use App\Exports\ClientesExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Database\QueryException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ClienteController extends BaseController
{
    public function __construct()
    {
        parent::__construct(['index']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filters = $this->getFilters($request, new Cliente());
        $perpage = $this->getLimitPagination($request);

        $querycliente = Cliente::where($filters)
            ->with('campania', 'distrito');

        if ($this->user->idcuenta != RuleManager::SYSTEM_COMPANY_ACCOUNT || !in_array($this->user->idrol, RuleManager::ADMINISTRATORS_ACCESS)) {
            //filtro mostrar usuarios que pertenecen a una cuenta
            $querycliente->whereHas('campania', function ($query) {
                $query->where('idcuenta', '=', $this->user->idcuenta);
            });
        }

        if ($request->exists('fechadesde')) {
            $fechadesde = Carbon::createFromFormat('d-m-Y', $request->fechadesde)->toDateString();
            $querycliente->whereDate('fecharegistro', '>=', $fechadesde);
        }

        if ($request->exists('fechahasta')) {
            $fechahasta = Carbon::createFromFormat('d-m-Y', $request->fechahasta)->toDateString();
            $querycliente->whereDate('fecharegistro', '<=', $fechahasta);
        }

        $cliente = $querycliente->orderBy('idcliente', 'DESC')
            ->paginate($perpage);

        return $cliente;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $result;
        try {
            $cliente = new Cliente();
            $cliente = $this->setModel($cliente, $request);
            $cliente->userinsert = $this->user->email;
            $cliente->save();

            $result = ResultManager::genericSuccessMessage();

        } catch (QueryException $e) {
            LogErrorManager::saveInDB($this, __FUNCTION__, $e);

            $duplicateEntry = 1062; // registro duplicado

            if (count($e->errorInfo)) {
                if ($e->errorInfo[1] == $duplicateEntry) {
                    $result = ResultManager::warningMessage('La dirección de correo electrónico que ha ingresado ya está registrada.');
                } else {
                    $result = ResultManager::errorMessage('Intente nuevamente más tarde.');
                }

            } else {
                $result = ResultManager::errorMessage('Intente nuevamente más tarde.');
            }

        } catch (Exception $e) {
            LogErrorManager::saveInDB($this, __FUNCTION__, $e);

            $result = ResultManager::gerericErrorMessage();
        }

        return $result;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return Cliente::with('campania', 'distrito')->find($id);
        // return Cliente::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $result;
        try {

            $cliente = $this->setModel(Cliente::findOrFail($id), $request);
            $cliente->userupdate = $this->user->email;
            $cliente->update();

            $result = ResultManager::genericSuccessMessage();

        } catch (QueryException $e) {
            LogErrorManager::saveInDB($this, __FUNCTION__, $e);

            $result = ResultManager::errorMessage('Es posible que haya un cliente registrado con el mismo nombre.');

        } catch (Exception $e) {
            LogErrorManager::saveInDB($this, __FUNCTION__, $e);

            $result = ResultManager::gerericErrorMessage();
        }

        return $result;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result;
        $errorMsg = 'No se puede eliminar. Hay Atenciones que hacen uso de Cliente';

        try {
            $numberDependents = Atencion::where(['idcliente' => $id, 'estado' => 'A'])->count();

            if ($numberDependents == 0) {

                $cliente = Cliente::findOrFail($id);
                $cliente->estado = $cliente->estado == RuleManager::DISABLED_STATE ? RuleManager::ACTIVE_STATE : RuleManager::DISABLED_STATE;
                $cliente->userupdate = $this->user->email;
                $cliente->update();

                if ($cliente->estado == RuleManager::ACTIVE_STATE) {
                    $result = ResultManager::successMessage('Cliente activado correctamente.');
                } else if($cliente->estado == RuleManager::DISABLED_STATE) {
                    $result = ResultManager::warningMessage('Cliente eliminado correctamente.');
                }

            } else {
                $result = ResultManager::warningMessage($errorMsg);
            }
        } catch (QueryException $e) {
            LogErrorManager::saveInDB($this, __FUNCTION__, $e);
            $result = ResultManager::errorMessage($errorMsg);

        } catch (Exception $e) {
            LogErrorManager::saveInDB($this, __FUNCTION__, $e);
            $result = ResultManager::gerericErrorMessage();
        }

        return $result;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function physicallyRemove(Request $request)
    {
        $result;
        $errorMsg = 'No se puede eliminar. Hay Atenciones que hacen uso de Cliente';

        $id = $request->id;
        try {
            $numberDependents = Atencion::where(['idcliente' => $id, 'estado' => 'A'])->count();

            if ($numberDependents == 0) {

                Cliente::destroy($id);

                $result = ResultManager::successMessage('Cliente eliminado correctamente.');
            } else {
                $result = ResultManager::warningMessage($errorMsg);
            }
        } catch (QueryException $e) {
            LogErrorManager::saveInDB($this, __FUNCTION__, $e);
            $result = ResultManager::errorMessage($errorMsg);

        } catch (Exception $e) {
            LogErrorManager::saveInDB($this, __FUNCTION__, $e);
            $result = ResultManager::gerericErrorMessage();
        }

        return $result;
    }

    private function setModel(Cliente $cliente, Request $request): Cliente
    {
        $cliente->nombres = $request->nombres;
        $cliente->apellidos = $request->apellidos;
        $cliente->telefono = $request->telefono;
        $cliente->dni = $request->dni;
        $cliente->carrera = $request->carrera;
        $cliente->grado = $request->grado;
        $cliente->edad = $request->edad;
        $cliente->evento = $request->evento;
        $cliente->tipoparticipante = $request->tipoparticipante;
        $cliente->ocupacion = $request->ocupacion;
        $cliente->origen = $request->origen;
        $cliente->colegio = $request->colegio;
        $cliente->anioegreso = $request->anioegreso;
        $cliente->email = $request->email;
        $cliente->idcampania = $request->idcampania;
        $cliente->procedencia = $request->procedencia;
        $cliente->campaign_medium = $request->campaign_medium;
        $cliente->campaign_source = $request->campaign_source;
        $cliente->campaign_content = $request->campaign_content;
        $cliente->campaign_term = $request->campaign_term;
        $cliente->campaign_name = $request->campaign_name;
        $cliente->especialidad = $request->especialidad;
        $cliente->pais = $request->pais;

        return $cliente;
    }

    public function exportarExcel(Request $request)
    {
        try {
            $name = 'clientes[' . Carbon::now('America/Lima')->format('d-m-Y H:i:s') . ' ].xlsx';
            return Excel::download(new ClientesExport($request), $name);
            
        } catch (QueryException $e) {
            LogErrorManager::saveInDB($this, __FUNCTION__, $e);

            throw new HttpException(500);
        } catch (Exception $e) {
            LogErrorManager::saveInDB($this, __FUNCTION__, $e);

            throw new HttpException(500);
        }
    }
}

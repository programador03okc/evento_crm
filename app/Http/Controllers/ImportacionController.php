<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Importacion;
use App\Util\ResultManager;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Util\LogErrorManager;
use App\Imports\ClientesImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Database\QueryException;

class ImportacionController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filters = $this->getFilters($request, new Importacion());
        $perpage = $this->getLimitPagination($request);

        $queryImportaciones = Importacion::where($filters)
            ->with('user');
            

        if ($request->exists('fechadesde')){
            $fechadesde = Carbon::createFromFormat('d-m-Y', $request->fechadesde)->toDateString();
            $queryImportaciones->whereDate('fecharegistro','>=', $fechadesde);
        }

        if ($request->exists('fechahasta')) {
            $fechahasta = Carbon::createFromFormat('d-m-Y', $request->fechahasta)->toDateString();           
            $queryImportaciones->whereDate('fecharegistro','<=', $fechahasta);
        }

        $importaciones = $queryImportaciones-> orderBy('idimportacion', 'DESC')
            ->paginate($perpage);

        return $importaciones;
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
            
            $file = $request->file('file');

            $importacion = new Importacion();
            $importacion->nombrearchivo = $file->getClientOriginalName(); 
            $importacion->fecharegistro = Carbon::now();
            $importacion->iduser = $this->user->id; 
            $importacion->uuidimportacion = Str::uuid();

            
            // $collection = Excel::toCollection(new ClientesImport(), $file);
            // return $collection;
            $clientImport = new ClientesImport($importacion);
            Excel::import($clientImport, $file);

            $importacion->cantregistros = $clientImport->getRowCount(); 
            $importacion->save();

            $result = ResultManager::genericSuccessMessage();
            
         } catch (QueryException $e) {
            LogErrorManager::saveInDB($this, __FUNCTION__, $e);

            $result = ResultManager::gerericErrorMessage();

        } catch (Exception $e) {
            LogErrorManager::saveInDB($this, __FUNCTION__, $e);

            $result = ResultManager::gerericErrorMessage();
        }

        return $result;
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

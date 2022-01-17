<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDO;
use Exception;
use Throwable;

class TipoConvenioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {

        DB::beginTransaction();
        $tipo_planilla = 0;
        try {
            $tipo_convenio = DB::select('SELECT pa_listartipoconvenio(:tipo_planilla)', ['tipo_planilla' => $tipo_planilla]);
            $cursor = $tipo_convenio[0]->pa_listartipoconvenio;
            $cursor_data = DB::select('FETCH ALL IN "' . $cursor . '";');
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            die("error: " . $e->getMessage());
        } catch (Throwable $e) {
            DB::rollBack();
            die("error: " . $e->getMessage());
        }

        return $cursor_data;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $idmaestro = $request->editedItem["idmaestro"];
        $codigo = $request->editedItem["codigo"];
        $abrev = $request->editedItem["abrev"];
        $descripcion = $request->editedItem["descripcion"];
        $estado = $request->editedItem["estado"];

        DB::beginTransaction();

        try {
            $save = DB::select(
                'SELECT pa_mantenimientotipoconvenio(:idmaestro,:codigo,:abrev,:descripcion,:estado)',
                ['idmaestro' => $idmaestro, 'codigo' => $codigo, 'abrev' => $abrev, 'descripcion' => $descripcion, 'estado' => $estado]
            );
            $cursor = $save[0]->pa_mantenimientotipoconvenio;
            $cursor_data = DB::select('FETCH ALL IN "' . $cursor . '";');
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            die("error: " . $e->getMessage());
        } catch (Throwable $e) {
            DB::rollBack();
            die("error: " . $e->getMessage());
        }

        return response()->json($cursor_data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\typeDocumentIdentify  $typeDocumentIdentify
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\typeDocumentIdentify  $typeDocumentIdentify
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\typeDocumentIdentify  $typeDocumentIdentify
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\typeDocumentIdentify  $typeDocumentIdentify
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $idmaestro = $request->id;

        DB::beginTransaction();

        try {
            $delete = DB::delete('DELETE FROM tbmaestro WHERE idmaestro=:idmaestro', ['idmaestro' => $idmaestro]);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            die("error: " . $e->getMessage());
        } catch (Throwable $e) {
            DB::rollBack();
            die("error: " . $e->getMessage());
        }

        return response()->json($delete);
    }
}

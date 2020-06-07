<?php

namespace App\Http\Controllers;

use App\Helpers\miPrint;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\DB;
use App\Models\Transferencium;
use Illuminate\Http\Request;

class TransferenciaController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\View\View
   */
  public function index(Request $request)
  {
    $keyword = $request->get('search');
    $perPage = 25;

    $entregas = \DB::select("select distinct entrega from transferencias");
    $entrega_select = $request->get('cbEntregas');
    if (empty($entrega_select)) {
      $entrega_select = 1;
    } else {
      $entrega_select = $request->get('cbEntregas');
    }
    if (!empty($keyword)) {
      $transferencia = Transferencium::where('entrega', '=', "$entrega_select")
        ->orWhere('fecha', 'LIKE', "%$keyword%")
        ->orWhere('cbu_debito', 'LIKE', "%$keyword%")
        ->orWhere('cbu_credito', 'LIKE', "%$keyword%")
        ->orWhere('alias_cbu_debito', 'LIKE', "%$keyword%")
        ->orWhere('alias_cbu_credito', 'LIKE', "%$keyword%")
        ->orWhere('importe', 'LIKE', "%$keyword%")
        ->orWhere('concepto', 'LIKE', "%$keyword%")
        ->orWhere('motivo', 'LIKE', "%$keyword%")
        ->orWhere('referencia', 'LIKE', "%$keyword%")
        ->orWhere('email', 'LIKE', "%$keyword%")
        ->orWhere('titulares', 'LIKE', "%$keyword%")
        ->latest()->paginate($perPage);
    } else {
      $transferencia = Transferencium::where('entrega', '=', "$entrega_select")->latest()->paginate($perPage);
    }

    return view('App.transferencia.index', compact('transferencia', 'entregas', 'entrega_select'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\View\View
   */
  public function create()
  {
    return view('App.transferencia.create');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param \Illuminate\Http\Request $request
   *
   * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
   */
  public function store(Request $request)
  {

    $this->validate($request, [
      'entrega' => 'required|max:12',
      'fecha' => 'required|max:10',
      'cbu_debito' => 'required|max:22|min:22',
      'cbu_credito' => 'required|max:22|min:22',
      'alias_cbu_debito' => 'required|max:22|min:22',
      'alias_cbu_credito' => 'required|max:22|min:22',
      'importe' => 'required|max:10',
      'concepto' => 'required|max:50',
      'motivo' => 'required|max:3',
      'referencia' => 'required|max:12',
      'email' => 'required',
      'titulares' => 'required|max:1',
    ]);
    $requestData = $request->all();

    Transferencium::create($requestData);
    $resul = ["tipo" => "success", "msg" =>  'Item de transferencia agregada!'];
    return redirect('transferencia')->with('flash_message', $resul);
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   *
   * @return \Illuminate\View\View
   */
  public function show($id)
  {
    dd("cae en show " . $id);
    $transferencium = Transferencium::findOrFail($id);
    return view('App.transferencia.show', compact('transferencium'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   *
   * @return \Illuminate\View\View
   */
  public function edit($id)
  {
    $transferencium = Transferencium::findOrFail($id);
    return view('App.transferencia.edit', compact('transferencium'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param \Illuminate\Http\Request $request
   * @param  int  $id
   *
   * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
   */
  public function update(Request $request, $id)
  {
    $this->validate($request, [
      'entrega' => 'required|max:12',
      'fecha' => 'required|max:10',
      'cbu_debito' => 'required|max:22|min:22',
      'cbu_credito' => 'required|max:22|min:22',
      'alias_cbu_debito' => 'required|max:22|min:22',
      'alias_cbu_credito' => 'required|max:22|min:22',
      'importe' => 'required|max:10',
      'concepto' => 'required|max:50',
      'motivo' => 'required|max:3',
      'referencia' => 'required|max:12',
      'email' => 'required',
      'titulares' => 'required|max:1',
    ]);
    $requestData = $request->all();
    $transferencium = Transferencium::findOrFail($id);
    $transferencium->update($requestData);
    $resul = ["tipo" => "success", "msg" =>  'Item de transferencia modificada!'];
    return redirect('transferencia')->with('flash_message', $resul);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   *
   * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
   */
  public function destroy($id)
  {
    Transferencium::destroy($id);
    $resul = ["tipo" => "success", "msg" =>  'Item de transferencia borrada!'];
    return redirect('transferencia')->with('flash_message', $resul);
  }

  public function descargar(Request $rq)
  {
    $entrega_select = $rq->get('cbEntregas');
    //$transferencias = Transferencium::where('entrega', '=', $entrega_select)->get()->toArray();
    $sql = "SELECT 
        `cbu_debito`,`cbu_credito`,`alias_cbu_debito`,`alias_cbu_credito`,
        `importe`,`concepto`,`motivo`,`referencia`,`email`,`titulares`
        FROM transferencias where entrega = '$entrega_select' ";

    $transferencias = \DB::select($sql);
    $transferencias = json_decode(json_encode($transferencias), true);

    //dd($transferencias);
    miPrint::escribirCSV($transferencias, "archivo_nombre.csv", false);
    exit;
  }

  public function descargarBanco(Request $rq)
  {
    $entrega_select = $rq->get('cbEntregas');
    $separador = $rq->get('separador');
    //$transferencias = Transferencium::where('entrega', '=', $entrega_select)->get()->toArray();
    $sql = "SELECT 
        `cbu_debito`,`cbu_credito`,`alias_cbu_debito`,`alias_cbu_credito`,
        `importe`,`concepto`,`motivo`,`referencia`,`email`,`titulares`
        FROM transferencias where entrega = '$entrega_select' ";

    $transferencias = \DB::select($sql);
    $caracter_separador = "";
    if (empty($separador)) {
      $caracter_separador = "";
    } else {
      $caracter_separador = $separador;
    }
    $resultado =  "";
    $cont = 0;
    $importe = 0.00;
    //dd($transferencias);
    foreach ($transferencias as $key => $t) {
      $cont += 1;
      $resultado .=  "" .
        str_pad($t->cbu_debito, 22, " ", STR_PAD_LEFT) . $caracter_separador .   // 
        str_pad($t->cbu_credito, 22, " ", STR_PAD_LEFT) . $caracter_separador .   // 
        str_pad($t->alias_cbu_debito, 22, " ", STR_PAD_LEFT) . $caracter_separador .   // 
        str_pad($t->alias_cbu_credito, 22, " ", STR_PAD_LEFT) . $caracter_separador .   // 
        str_pad(str_replace(".", "", number_format($t->importe, 2)), 12, " ", STR_PAD_LEFT) . $caracter_separador .   // 
        str_pad($t->concepto, 50, " ", STR_PAD_LEFT) . $caracter_separador .   // 
        str_pad($t->motivo, 3, " ", STR_PAD_LEFT) . $caracter_separador .   // 
        str_pad($t->referencia, 12, " ", STR_PAD_LEFT) . $caracter_separador .   // 
        str_pad($t->email, 50, " ", STR_PAD_LEFT) . $caracter_separador .   // 
        str_pad($t->titulares, 1, " ", STR_PAD_LEFT) . $caracter_separador .   // 
        str_pad("", 2, " ", STR_PAD_LEFT) . $caracter_separador .   // relleno 
        ($cont == count($transferencias) ? "" : "\r\n");
      $importe += $t->importe;
    }
    //dd(str_pad(str_replace(".", "", number_format($importe, 2)), 17, " ", STR_PAD_LEFT) . $caracter_separador);
    $cabecera = "" .
      str_pad($cont, 5, " ", STR_PAD_LEFT) . $caracter_separador .   // 
      str_pad(str_replace(".", "", number_format($importe, 2)), 17, " ", STR_PAD_LEFT) . $caracter_separador .   // 
      str_pad("", 194, " ", STR_PAD_LEFT) . $caracter_separador .   // relleno 
      str_pad("", 2, " ", STR_PAD_LEFT) . $caracter_separador .   // relleno 
      "\r\n";

    $nombreArchivo = "exportacion_" . $entrega_select . ".txt";
    ob_clean();
    header("Content-type: text/plain");
    header("Content-Disposition: attachment; filename=" . $nombreArchivo);
    echo $cabecera . $resultado;
    exit;
  }




  public function copiar(Request $rq)
  {
    $msg = "";
    if (empty($rq->chops)) {
      $msg = "No se indicó ningun item a copiar!";
      $resul = ["tipo" => "danger", "msg" =>  $msg];
      return redirect('transferencia')->with('flash_message', $resul);
    }

    $idAcopiar =  implode(",", array_keys($rq->chops));
    if (empty($idAcopiar)) {
      $msg = "No se indicó ningun item a copiar!";
      $resul = ["tipo" => "danger", "msg" =>  $msg];
      return redirect('transferencia')->with('flash_message', $resul);
    }

    $nuevoNumero = $rq->get('txNuevaEntrega');
    $fechaNueva = $rq->get('txNuevaFecha');

    if (empty($nuevoNumero)) {
      $msg = "No se indicó el nuevo numero de entrega!";
      $resul = ["tipo" => "danger", "msg" =>  $msg];
      return redirect('transferencia')->with('flash_message', $resul);
    }
    if (empty($fechaNueva)) {
      $msg = "No se indicó la nueva fecha de entrega!";
      $resul = ["tipo" => "danger", "msg" =>  $msg];
      return redirect('transferencia')->with('flash_message', $resul);
    }


    \DB::beginTransaction();
    try {
      $nuevoNumero = $rq->get('txNuevaEntrega');
      $fechaNueva = $rq->get('txNuevaFecha');
      $transferencias = Transferencium::find(array_keys($rq->chops));
      foreach ($transferencias as $key => $value) {
        $trans = $value->replicate();
        $trans->entrega = $nuevoNumero;
        $trans->fecha = $fechaNueva;
        $trans->save();
      }
      $msg =  "Se copiaron los registros seleccionados en el nuevo lote de entrega N° " . $nuevoNumero;
      $resul = ["tipo" => "success", "msg" =>  $msg];
      \DB::commit();
      return redirect('transferencia')->with('flash_message', $resul);
    } catch (\Throwable $th) {
      $msg =  "Error al intentar copiar los registro del lote de entrega!";
      $resul = ["tipo" => "danger", "msg" =>  $msg];
      \DB::rollback();
      return redirect('transferencia')->with('flash_message', $resul);
      //throw $th;
    }
  }
}

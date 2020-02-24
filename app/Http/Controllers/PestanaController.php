<?php

namespace App\Http\Controllers;

use DB;
use File;
use Storage;
use App\Pestana;
use Illuminate\Http\Request;
use Session;

class PestanaController extends Controller{
   
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        $productos = DB::table('empleado as t1')
            ->select(DB::raw('case when t3.descripcion is null then "Sin contrato" else t3.descripcion end as empresa, t1.documento_empleado as documento, concat(t1.ape_paterno_empl, " ", t1.ape_materno_empl,",",t1.nombre) Nombre, t2.fecha_inicio_aaaammdd as inicio_contrato, t2.fecha_fin_prog as fin_contrato, t4.descripcion as cargo, t6.descripcion as tipo_contrato, case when t2.fecha_fin_prog is null or t2.fecha_fin_prog < date(now()) then "Cesado" else "Activo" end as activo,t1.id'))
            ->leftJoin('rh_contrato as t2', 't2.id_empleado', '=', 't1.id' )
            ->leftJoin('empresas as t3', 't3.id', '=', 't2.id_empresa')
            ->leftJoin('rh_cargo as t4', 't4.id', '=', 't1.cargo')
            ->leftJoin('tipo_contrato as t5', 't5.id', '=', 't2.id_tipo_contrato')
            ->leftJoin('tipo_contrato_grupo as t6', 't6.id', '=', 't5.id_grupo')
            ->where('t1.id_company','=', auth()->user()->id_company)
            ->get();
        //dd($productos);   
        $copioproducto  = 0;  
        //$fotoempleado = Empleado::where('id','=', Auth::user()->id_empleado)->first();
        $reportes = DB::table('empleado_reporte')
        ->select(DB::raw('id as id_reporte, web  as web, descripcion'))
        ->where('enabled', '=', 'true')
        ->get();
        
        //$company = DB::table('company')->select(DB::raw('descripcion'))->where('id','=',auth()->user()->id_company)->get();

        return view('pestana.index',[
            'productos' => $productos,
            'copioproducto'=>$copioproducto,
            //'compania' => $company,
            //'fotoempleado' => $fotoempleado,
            'reportes' => $reportes,
            //'color' => ColorController::ColorPorUsuario()
        ]);
    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function nuevoDocumento(Request $request){
       //dd($request);

       //Captura el documento, al nombre del documento le agrego el id_empleado(editando), fecha y hora que fue subido, el nombre original
       //del documento. El archivo capturado lo guardo en una carpeta con el nombre de la compania y cada documento perteneciente a cada compania
       //se guardara en su directorio qu le corresponda
        if($request->hasFile('doc_user')){
            $file = $request->file('doc_user');
            $name = $request->id_empleado."-".date('Y-m-d H-i-s').$file->getClientOriginalName();
            $file->move(public_path().'/docs/'.$request->compa.'/', $name);
        }
        
        //Inserta un al empleado que estemos viendo un nuevo documento
        DB::table('empleado_documentos')->insert([
           'id_empleado' => $request->id_empleado, 
           'id_tipo_documento_empleado' => $request->tipo_docu,
           'ruta' => $request->compa.'/'.$name,
           'enabled' => 'true',
           'id_empleado_carga' => auth()->user()->id,
           'fecha_desde' => $request->fec_inicio,
           'fecha_hasta' => $request->fec_fin,
           'created_at' => date("Y-m-d H:i:s"),
           'updated_at' => date("Y-m-d H:i:s")]);
           return back();
    }

    //Para poder visualizar el documento del empleado
    public function verDocumento($ruta){
       return view('pestana.documento', compact($ruta));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){ 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Books  $books
     * @return \Illuminate\Http\Response
     */
    public function show(Books $book){      
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Books  $books
     * @return \Illuminate\Http\Response
     */
    public function edit($id_emplado_vista){
        /* $books = Books::paginate(3);*/

        //Lista todos los documento del empleado que estemos editando
        $lista_doc = DB::table('empleado_documentos as t1')
        ->select(DB::raw('T1.id, T2.descripcion AS tipo_documento, concat (t3.ape_paterno_empl, " ", t3.ape_materno_empl, ", ",  t3.nombre) as cargado_por,
        DATE(T1.created_at) AS fecha_carga, T1.fecha_desde as valido_desde, T1.fecha_hasta as valido_hasta, t1.ruta'))
        ->join('tipo_documento_empleado_anexo as t2', 't2.id', '=','t1.id_tipo_documento_empleado')
        ->join('empleado as T3', 't3.id_user', '=', 't1.id_empleado_carga')
        ->where('t1.id_empleado','=', $id_emplado_vista)
        ->get();
 
        //Carga el combo box segun el tipo de compania y usuario este logueado
         $tipoDoc = DB::table('tipo_documento_empleado_anexo as t1')
         ->select(DB::raw('t1.id, t1.descripcion'))
         ->join('tipo_documento_empleado_anexo_company as t2', 't2.id_tipo_documento_empleado_anexo','=','t1.id')
         ->where('t2.id_company', '=', auth()->user()->id_company)
         ->where('t2.enabled', '=', 'true')
         ->get();

        $company = DB::table('company')->select(DB::raw('descripcion'))->where('id','=',auth()->user()->id_company)->get();

        //Mando los datos a pintar en pantalla
         return view('pestana.edit', [
            'documento' => $lista_doc,
            'tipoDoc' => $tipoDoc,
            'id_empleado' => $id_emplado_vista,
            'compania'=>$company
         ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Books  $books
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Books $book){
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Books  $books
     * @return \Illuminate\Http\Response
     */
    public function destroy(Books $book){   
    }
}

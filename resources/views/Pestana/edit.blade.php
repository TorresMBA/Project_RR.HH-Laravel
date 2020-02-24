@extends('Pestana.layout')

@section('content')
<div class="container">
  <div role="tabpanel" class="tab-pane" id="Section5">
    <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#agregarDocumento">Cargar Nuevo Documento</button>
    <br/><br/>

    <!--Ventana del Boton "Cargar Nuevo Documento"-->
    <form action="{{ route('doc.create') }}" method="POST" enctype="multipart/form-data" file="true">
      {{ csrf_field() }}
      <input type="hidden" name="id_empleado" value="{{ $id_empleado }}">
      @foreach($compania as $compa)
        <input type="hidden" name="compa" value="{{$compa->descripcion}}">
      @endforeach
      <div class="modal fade" id="agregarDocumento" tabindex="-1" role="dialog" aria-labelledby="agregarDocumento">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
              <div class="modal-header" style="background-color: #1bba46;color:#fff;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center">Cargar Nuevo Documento</h4>
              </div>
            <div class="modal-body">
                <div class="col-lg-4 col-md-2 col-sm-6 col-xs-12 group1">
                    <label for="sku">Tipo:</label>
                    <select class="form-control select2" name="tipo_docu" id="tipo_docu" required="true">
                        <option value="" selected="true" disabled>Seleccione una Opción</option> 
                        @foreach($tipoDoc as $tipoDocume)
                          <option value="{{ $tipoDocume->id }}">{{ $tipoDocume->descripcion }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-4 col-md-2 col-sm-6 col-xs-12 group2">
                    <label for="sku">Valido Desde:</label>
                    <input type="date" class="form-control" id="fec_inicio" name="fec_inicio" required="true" />
                </div>
                <div class="col-lg-4 col-md-2 col-sm-6 col-xs-12 group2">
                    <label for="sku">Valido Hasta:</label>
                    <input type="date" class="form-control" id="fec_fin" name="fec_fin" required="true" />
                </div>  <br>
                <div class="col-lg-4 col-md-2 col-sm-6 col-xs-12 group2">
                    <label for="exampleInputFile">Carga un nuevo documento:</label>
                    <input type="file" id="doc_user" name="doc_user">
                    <p class="help-block">El documento no debe superar 3 MB.</p>
                </div>                                        
                <div class="modal-footer">
                    <button type="submit " class="btn btn-primary">Grabar</button>
                </div>
            </div>
          </div>
        </div>
      </div>
    </form>

  <!--Tabla que se pinta en pantalla--> 
    <table id="cliente" class="table table-bordered table-striped">
        <thead>
          <tr style="font-size: 15px !important;font-weight: bold !important;background-color: #FF5733;color:#fff;">
            <th class="text-center">Tipo de Documento</th>
            <th class="text-center">Fecha de Carga</th>
            <tH class="text-center">Valido desde</th>
            <tH class="text-center">Valido Hasta</th>
            <tH class="text-center">Acciones</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($documento as $document)
              <tr>
                <td class="text-center">{{ $document->tipo_documento }}</td>
                <td class="text-center">{!! date('d/m/Y', strtotime($document->fecha_carga)) !!}</td>
                <td class="text-center">{!! date('d/m/Y', strtotime($document->valido_desde)) !!}</td>
                <td class="text-center">{!! date('d/m/Y', strtotime($document->valido_hasta)) !!}</td>
                <!--Boton de Acciones "Lupa Detalles" Muestra una ventana con mas datos-->
                <td class="text-center">
                    <button class="btn unstyled-button fa fa-search btn-sm" data-toggle="modal" data-target="#verDetalleDocumento_{{ $document->id}}"></button>
                  <div class="modal fade" id="verDetalleDocumento_{{ $document->id}}" tabindex="-1" role="dialog" aria-labelledby="verDetalle">
                    <div class="modal-dialog modal-lg" role="document">
                      <div class="modal-content">
                          <div class="modal-header" style="background-color: #1bba46;color:#fff;">
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                              <h4 class="modal-title text-center" id="verDocumento">Detalle del Documento</h4>
                          </div>
                          <div class="modal-body">
                              <div class="col-lg-12 col-md-4 col-sm-6 col-xs-12 group2">
                                <label for="sku">Cargado Por:</label>
                                <input type="text" name="empresa" class="form-control mb-2 text-center" value="{{ $document->cargado_por}}" readonly="false">
                              </div>     

                              <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12 group2">
                                <label for="sku">Fecha:</label>
                                <input type="text" name="vacantes" class="form-control mb-2 text-center" value="{!! date('d/m/Y', strtotime($document->fecha_carga)) !!}" readonly="false">
                              </div>

                              <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12 group2">
                                <label for="sku">Valido desde:</label>
                                <input type="text" name="vacantes" class="form-control mb-2 text-center" value="{!! date('d/m/Y', strtotime($document->valido_desde)) !!}" readonly="false">
                              </div>

                              <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12 group2">
                                <label for="sku">Valido hasta:</label>
                                <input type="text" class="form-control text-center" id="fecha_requerida" name="fecha_requerida" value="{!! date('d/m/Y', strtotime($document->valido_hasta)) !!}" readonly="false">
                              </div> 
                              <br>
                              <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12 group2">
                                <a href="{{ route('ver.doc', $document->ruta)}}" class="btn btn-info" >Ver Documento</a>
                              </div>
                          </div> 
                          <div class="modal-footer ">
                              <button type="button" class="btn btn-success" data-dismiss="modal" style="margin-top: 15px;">Cerrar</button>
                          </div>
                      </div>
                    </div>
                  </div>
                </td>
              </tr>
          @endforeach
        </tbody>
    </table>
  </div>
</div>
@endsection
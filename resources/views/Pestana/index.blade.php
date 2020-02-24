@extends('Pestana.layout')

@section('content')
<div class="box container">
    <div class="box-header">
        <h3>Modulo para buqueda de Empleado</h3>
    </div>

    <!-- /.box-header -->
    <div class="box-body">
      <table id="empleados" class="table table-bordered table-striped">
        <thead>
            <tr style="font-size: 15px !important;font-weight: bold !important;background-color: #FF5733;color:#fff;">

            <th class="text-center">Empresa</th>

            <th class="text-center">Documento</th>

            <th class="text-center">Nombres y Apellidos</th>

            <th class="text-center">Fecha inicio contrato</th>

            <th class="text-center">Fecha fin contrato</th>

            <th class="text-center">Cargo</th>

            <th class="text-center">Tipo Contrato</th>

            <th class="text-center">Estado</th>

            <th class="text-center">Editar</th>
            {{-- <th>Copiar</th> --}}
            </tr>
        </thead>
        <tbody>
          @foreach($productos as $producto)
            <tr class="text-left">

                <td>{{ $producto->empresa }}</td>

                <td>{{ $producto->documento }}</td>

                <td>{{ $producto->Nombre }}</td>

                <td>
                    {!! date('d/m/Y', strtotime($producto->inicio_contrato)) !!}  
                </td>

                <td>
                    {!! date('d/m/Y', strtotime($producto->fin_contrato)) !!}
                </td>

                <td>{{ $producto->cargo }}</td>

                <td>{{ $producto->tipo_contrato }}</td>

                <td>{{ $producto->activo }}</td>

                <td class="text-center">
                    <a href="{{ URL::action('PestanaController@edit', $producto->id) }}"> 
                        <button class="btn btn-primary btn-xs"><i class="fa fa-fw fa-edit"></i>Editar</button>
                    </a>
                </td>
                {{-- <td>
                <a href="{{ URL::action('EmpleadosAdmin@CopyProduct', $producto->id) }}"> 
                    <button class="btn btn-block btn-info btn-xs">Copiar</button>
                </a>
            </td> --}}
            </tr>  
          @endforeach
        </tbody>

        <tfoot style="font-size: 15px !important;font-weight: bold !important;background-color: #FF5733;color:#fff;">

          <th class="text-center">Empresa</th>

          <th class="text-center">Documento</th>

          <th class="text-center">Nombres y Apellidos</th>

          <th class="text-center">Fecha inicio contrato</th>

          <th class="text-center">Fecha fin contrato</th>

          <th class="text-center">Cargo</th>

          <th class="text-center">Tipo Contrato</th>

          <th class="text-center">Estado</th>

          <th class="text-center">Editar</th>

        </tfoot>
      </table>
    </div>
    <!-- /.box-body -->
  </div>
@endsection
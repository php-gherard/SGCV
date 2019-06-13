@extends('layouts.app')

@section('content')
            <div class="panel panel-primary">
                <div class="panel-heading">Registrar Estado de Envío</div>

                <div class="panel-body">

                      <form>

                          <div class="form-group col-md-12"> <!-- Id Orden Transporte -->
                              <div class="col-md-6">
                                  <label for="street1_id" class="control-label " >Orden de Transporte</label>
                              @if(Session::has('nroordentran'))
                                <input type="text" class="form-control textform"  id="ordentrans" name="nroordentran" readonly value="{{$onrordentranscli}}" >
                              
                                
                                  @else
                                  <input type="text" class="form-control textform" readonly id="street1_id" disabled="true" >
                             
                                   @endif
                                </div>

                              <div class="col-md-6">
                              <label for="" class="control-label ">&nbsp;</label>
                                <a href="/buscarOrdenTransporte" class="btn btn-primary form-control">
                                  Buscar Orden de Transporte
                                </a>
                              </div>
                              
                          </div>

        
                          <div class="form-group col-md-12">

                          <div class="col-md-6">  <!-- Id Nota Pedido -->
                            <label for="street1_id" class="control-label ">Nro. Nota de Pedido</label>
                          @if(Session::has('nota_pedidos_id'))
                            <input type="text" class="form-control textform" disabled="true" id="nota_pedido_id" name="nota_pedidos_id" readonly value="{{$nota_pedido_id}}">
                          @else
                          <input type="text" class="form-control textform" id="nota_pedido_id" name="nota_pedidos_id" disabled="true" >
                      
                           @endif
                        </div>
                               
                      <div class="col-md-6">
                                <label for="street1_id" class="control-label ">Estado</label>
                              <select class="form-control" id="estado" name="estado">
                                <option value="1">Emitido</option>
                                <option value="2">Enviado</option>
                                <option value="3">Entregado</option>
                                <option value="4">Rechazado</option>
                                <option value="5">Anulado</option>
                              </select>
                        </div>
                    </div>

 
                          <div class="form-group col-md-12"> <!-- Street 1 -->
                            <div class="col-md-6">
                              <a href="/" class="btn btn-primary">
                                Registrar Estado de Envío
                              </a>
                            </div>
                            <div class="col-md-6">
                              <a href="/home" class="btn btn-primary">
                                Salir
                              </a>
                            </div>
                          </div> 

                      </form>

                </div>
            </div>

            
@endsection
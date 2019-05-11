@extends('layouts.app')

@section('content')
            <div class="panel panel-primary">
                <div class="panel-heading">Registrar Cliente</div>

                <div class="panel-body">

                      <form>

                          <div class="form-group col-md-12"> <!-- Street 1 -->

                              <div class="col-md-6">
                                  <label for="street1_id" class="control-label ">Número de Documento</label>
                                  <input type="text" class="form-control textform" id="street1_id" name="street1"  placeholder="Numero de documento del cliente">
                              </div>

                          </div>

                          <div class="form-group col-md-12"> <!-- Street 1 -->

                              <div class="col-md-6">
                                  <label for="street1_id" class="control-label">Nombre de Cliente</label>
                                  <input type="text" class="form-control textform" id="street1_id" name="street1"  placeholder="Nombres del Cliente">
                              </div>

                              <div class="col-md-6">
                                  <label for="street1_id" class="control-label">Apellido de Cliente</label>
                                  <input type="text" class="form-control textform" id="street1_id" name="street1"  placeholder="Apellidos del cliente">
                              </div>

                          </div>


                          <div class="form-group col-md-12"> <!-- Street 1 -->

                              <div class="col-md-6">
                                  <label for="street1_id" class="control-label">Dirección</label>
                                  <input type="text" class="form-control textform" id="street1_id" name="street1"  placeholder="Direccion del cliente">
                              </div>
                              <div class="col-md-6">
                                  <label for="street1_id" class="control-label">Teléfono</label>
                                  <input type="text" class="form-control textform" id="street1_id" name="street1"  placeholder="Telefono del cliente">
                              </div>
                          </div>

                          <div class="form-group col-md-12"> <!-- Street 1 -->

                               <div class="col-md-6">
                                  <button type="submit" class="btn btn-primary">Registrar Cliente</button>
                              </div>

                          </div>

                      </form>

                </div>
            </div>
@endsection

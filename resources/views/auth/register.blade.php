@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Registro de usuario') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('preusers.update', ['user' => $user, 'redirect' => $redirect]) }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nombre') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $user->name }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="last_name" class="col-md-4 col-form-label text-md-right">{{ __('Apellidos') }}</label>

                            <div class="col-md-6">
                                <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ $user->last_name }}" required autocomplete="last_name">

                                @error('last_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Correo electr??nico') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="company" class="col-md-4 col-form-label text-md-right">{{ __('Empresa') }}</label>

                            <div class="col-md-6">
                                <input id="company" type="text" class="form-control @error('company') is-invalid @enderror" name="company" value="{{ $user->company }}" required autocomplete="company">

                                @error('company')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="position" class="col-md-4 col-form-label text-md-right">{{ __('Cargo') }}</label>

                            <div class="col-md-6">
                                <input id="position" type="text" class="form-control @error('position') is-invalid @enderror" name="position" value="{{ $user->position }}" required autocomplete="position">

                                @error('position')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <hr>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Contrase??a') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirmar contrase??a') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col">
                                <p>Deseo recibir informaci??n sobre eventos, promociones, sorteos y otras comunicaciones comerciales sobre productos, servicios y contenidos del <a role="button" data-toggle="collapse" href="#sociedades" aria-expanded="false" aria-controls="collapseExample">Grupo Unidad Editorial</a>, y/o de terceros de distintos sectores, incluido por medios electr??nicos. Por favor, <a href="/politica-de-privacidad" target="_blank">consulta aqu??</a> la informaci??n detallada y d??ganos si est?? de acuerdo.</p>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="advertising" id="inlineRadio1" value="1" required>
                                    <label class="form-check-label" for="inlineRadio1">S??</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="advertising" id="inlineRadio2" value="0">
                                    <label class="form-check-label" for="inlineRadio2">No</label>
                                </div>
                                <p class="small">
                                    <strong>Responsable</strong>: los datos personales facilitados ser??n tratados por Unidad Editorial Informaci??n Econ??mica, S.L.U., sociedad espa??ola con domicilio social en Avenida de San Luis, 25, C.P. 28033, Madrid (Espa??a), C.I.F. n??mero B-85.157.790. <strong>Finalidad y Legitimaci??n</strong>: gestionar su asistencia y participaci??n en el evento II Foro Econ??mico Internacional Expansi??n, siendo ello necesario para prestarle los servicios que conlleva la participaci??n en dicho evento, siendo la base de legitimaci??n del tratamiento la ejecuci??n del contrato suscrito entre el interesado y Unidad Editorial Informaci??n Econ??mica, S.L.U. Asimismo, en el evento se tomar??n im??genes y se realizar??n v??deos para su difusi??n period??stica. Cuando se trate de planos generales y sonido ambiente, tratamiento estar?? basado en el inter??s leg??timo de Unidad Editorial Informaci??n Econ??mica, S.L.U. de mejorar sus actividades promocionales; por su parte, en caso de que se capten planos en los que se pueda reconocer directamente a los asistentes ???e.g primeros planos-, la base legal ser?? el consentimiento prestado al posar para la imagen. <strong>Destinatarios</strong>: En caso de que solicite alojamiento, sus datos ser??n comunicados a Paradores de Turismo de Espa??a S.M.E., S.A. para tramitar la reserva. <strong>Conservaci??n</strong>: Sus datos personales ser??n conservados hasta la finalizaci??n del evento y, posteriormente, debidamente bloqueados, durante los plazos de prescripci??n de las obligaciones legales de Unidad Editorial Informaci??n Econ??mica, S.L.U. y de las eventuales responsabilidades derivadas del tratamiento de dichos datos. <strong>Derechos</strong>: Podr?? ejercitar sus derechos de acceso, rectificaci??n, supresi??n, oposici??n, portabilidad y limitaci??n del tratamiento mediante solicitud por escrito a la direcci??n de correo <a href="mailto:lopd@unidadeditorial.es">lopd@unidadeditorial.es</a>, adjuntando copia de documento identificativo en vigor (DNI, NIE o pasaporte). Le informamos igualmente de que podr?? contactar con nuestro Delegado de Protecci??n de datos a trav??s del mail <a href="mailto:dpo@unidadeditorial.es">dpo@unidadeditorial.es</a> y/o presentar una reclamaci??n ante la Agencia Espa??ola de Protecci??n de Datos a trav??s de su p??gina web <a href="https://www.aepd.es" target="_blank">www.aepd.es</a>.
                                </p>
                                <div class="collapse" id="sociedades">
                                    <div class="well">
                                        <table class="table table-responsive table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>
                                                        <p><strong>Universo</strong></p>
                                                    </th>
                                                    <th>
                                                        <p><strong>Accesible a trav??s de las URLs</strong></p>
                                                    </th>
                                                    <th>
                                                        <p><strong>Sociedad titular</strong></p>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <p>EL MUNDO</p>
                                                    </td>
                                                    <td>
                                                        <p><a href="http://www.elmundo.es/">www.elmundo.es</a>
                                                        <br /><a href="http://www.elmundo.es/metropoli.html">metropoli.elmundo.es</a></p>
                                                    </td>
                                                    <td>
                                                        <p>Unidad Editorial Informaci??n General, S.L.U.</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <p>ORBYT</p>
                                                    </td>
                                                    <td>
                                                        <p><a href="http://www.orbyt.es/">www.orbyt.es</a></p>
                                                    </td>
                                                    <td>
                                                        <p>Unidad Editorial Informaci??n General, S.L.U.</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <p>Expansi??n</p>
                                                    </td>
                                                    <td>
                                                        <p><a href="http://www.expansion.com/actualidadeconomica.html">www.expansion.com/actualidadeconomica.html</a>
                                                        <br /><a href="http://www.expansion.com/">www.expansion.com</a>
                                                        <br /><a href="http://www.fueradeserie.com/">www.fueradeserie.com</a>
                                                        <br /><a href="http://nauta360.expansion.com/">nauta360.expansion.com</a></p>
                                                    </td>
                                                    <td>
                                                        <p>Unidad Editorial Informaci??n Econ??mica, S.L.U.</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <p>Marca</p>
                                                    </td>
                                                    <td>
                                                        <p><a href="http://www.marca.com/">www.marca.com</a>
                                                        <br /><a href="http://www.marca.com/radio.html">www.marca.com/radio.html</a>
                                                        <br /><a href="http://www.supercodigo.marca.com/">www.supercodigo.marca.com</a>
                                                        <br /><a href="http://www.marca.com/tiramillas.html">www.marca.com/tiramillas.html</a></p>
                                                    </td>
                                                    <td>
                                                        <p>Unidad Editorial Informaci??n Deportiva, S.L.U.</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <p>Revistas</p>
                                                    </td>
                                                    <td>
                                                        <p><a href="http://www.elmundo.es/historia.html">www.elmundo.es/historia.html</a>
                                                        <br /><a href="http://www.dmedicina.com/">www.dmedicina.com</a>
                                                        <br /><a href="http://www.correofarmaceutico.com/">www.correofarmaceutico.com</a>
                                                        <br /><a href="http://www.diariomedico.com/">www.diariomedico.com</a></p>
                                                    </td>
                                                    <td>
                                                        <p>Unidad Editorial Revistas, S.L.U.</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <p>Revistas Lujo</p>
                                                    </td>
                                                    <td>
                                                        <p><a href="http://www.telva.com/">www.telva.com</a></p>
                                                    </td>
                                                    <td>
                                                        <p>Ediciones C??nica, S.A.</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <p>Formaci??n</p>
                                                    </td>
                                                    <td>
                                                        <p><a href="http://www.escuelaunidadeditorial.es/">www.escuelaunidadeditorial.es</a></p>
                                                    </td>
                                                    <td>
                                                        <p>Unidad Editorial Formaci??n, S.L.U.</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <p>Conferencias</p>
                                                    </td>
                                                    <td>
                                                        <p><a href="http://www.conferenciasyformacion.com/">www.conferenciasyformacion.com</a></p>
                                                    </td>
                                                    <td>
                                                        <p>Unidad Editorial, S.A.</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <p>Juego</p>
                                                    </td>
                                                    <td>
                                                        <p><a href="http://www.marcaapuestas.es/">www.marcaapuestas.es</a></p>
                                                    </td>
                                                    <td>
                                                        <p>Unidad Editorial Juego, S.A.</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <p>Otros</p>
                                                    </td>
                                                    <td>
                                                        <p><a href="http://www.esferalibros.com/">www.esferalibros.com</a>
                                                        <br /><a href="http://www.uesyndication.com/">www.uesyndication.com</a>
                                                        <br /><a href="http://www.elcultural.es/">www.elcultural.es</a>
                                                        <br /><a href="http://www.unidadeditorial.com/">www.unidadeditorial.com</a>
                                                        <br /><a href="http://www.unidadeditorial.es/">www.unidadeditorial.es</a>
                                                        <br /><a href="http://www.veo.es/">www.veo.es</a></p>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Registro') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

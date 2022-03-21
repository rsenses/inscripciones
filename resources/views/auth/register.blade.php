@extends('layouts.public')

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
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Correo electrónico') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email }}" required autocomplete="email">

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <hr>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Contraseña') }}</label>

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
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirmar contraseña') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col">
                                Al registrarse declara aceptar los <a href="{{ route('terminos-y-condiciones', ['c' => $checkout->campaign]) }}" target="_blank">términos y condiciones</a> de uso y la <a class="text-xs-center js-uecookiespolicy-preferences-show" href="http://cookies.unidadeditorial.es" target="_blank">política de cookies</a>.
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col">
                                <p>Deseo recibir información sobre eventos, promociones, sorteos y otras comunicaciones comerciales sobre productos, servicios y contenidos del <a role="button" data-toggle="collapse" href="#sociedades" aria-expanded="false" aria-controls="collapseExample">Grupo Unidad Editorial</a>, y/o de terceros de distintos <a href="https://www.expansion.com/registro/sectores.html" target="_blank">sectores</a>, incluido por medios electrónicos. Por favor, <a href="{{ route('politica-de-privacidad', ['c' => $checkout->campaign]) }}" target="_blank">consulta aquí</a> la información detallada y díganos si está de acuerdo.</p>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="advertising" id="inlineRadio1" value="1" required>
                                    <label class="form-check-label" for="inlineRadio1">Sí</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="advertising" id="inlineRadio2" value="0">
                                    <label class="form-check-label" for="inlineRadio2">No</label>
                                </div>
                                <p class="small">
                                    <strong>Responsable</strong>: los datos personales facilitados serán tratados por Unidad Editorial Información Económica, S.L.U., sociedad española con domicilio social en Avenida de San Luis, 25, C.P. 28033, Madrid (España), C.I.F. número B-85.157.790. <strong>Finalidad y Legitimación</strong>: gestionar su asistencia y participación en el evento II Foro Económico Internacional Expansión, siendo ello necesario para prestarle los servicios que conlleva la participación en dicho evento, siendo la base de legitimación del tratamiento la ejecución del contrato suscrito entre el interesado y Unidad Editorial Información Económica, S.L.U. Asimismo, en el evento se tomarán imágenes y se realizarán vídeos para su difusión periodística. Cuando se trate de planos generales y sonido ambiente, tratamiento estará basado en el interés legítimo de Unidad Editorial Información Económica, S.L.U. de mejorar sus actividades promocionales; por su parte, en caso de que se capten planos en los que se pueda reconocer directamente a los asistentes –e.g primeros planos-, la base legal será el consentimiento prestado al posar para la imagen. <strong>Destinatarios</strong>: En caso de que solicite alojamiento, sus datos serán comunicados a Paradores de Turismo de España S.M.E., S.A. para tramitar la reserva. <strong>Conservación</strong>: Sus datos personales serán conservados hasta la finalización del evento y, posteriormente, debidamente bloqueados, durante los plazos de prescripción de las obligaciones legales de Unidad Editorial Información Económica, S.L.U. y de las eventuales responsabilidades derivadas del tratamiento de dichos datos. <strong>Derechos</strong>: Podrá ejercitar sus derechos de acceso, rectificación, supresión, oposición, portabilidad y limitación del tratamiento mediante solicitud por escrito a la dirección de correo <a href="mailto:lopd@unidadeditorial.es">lopd@unidadeditorial.es</a>, adjuntando copia de documento identificativo en vigor (DNI, NIE o pasaporte). Le informamos igualmente de que podrá contactar con nuestro Delegado de Protección de datos a través del mail <a href="mailto:dpo@unidadeditorial.es">dpo@unidadeditorial.es</a> y/o presentar una reclamación ante la Agencia Española de Protección de Datos a través de su página web <a href="https://www.aepd.es" target="_blank">www.aepd.es</a>.
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
                                                        <p><strong>Accesible a través de las URLs</strong></p>
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
                                                            <br /><a href="http://www.elmundo.es/metropoli.html">metropoli.elmundo.es</a>
                                                        </p>
                                                    </td>
                                                    <td>
                                                        <p>Unidad Editorial Información General, S.L.U.</p>
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
                                                        <p>Unidad Editorial Información General, S.L.U.</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <p>Expansión</p>
                                                    </td>
                                                    <td>
                                                        <p><a href="http://www.expansion.com/actualidadeconomica.html">www.expansion.com/actualidadeconomica.html</a>
                                                            <br /><a href="http://www.expansion.com/">www.expansion.com</a>
                                                            <br /><a href="http://www.fueradeserie.com/">www.fueradeserie.com</a>
                                                            <br /><a href="http://nauta360.expansion.com/">nauta360.expansion.com</a>
                                                        </p>
                                                    </td>
                                                    <td>
                                                        <p>Unidad Editorial Información Económica, S.L.U.</p>
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
                                                            <br /><a href="http://www.marca.com/tiramillas.html">www.marca.com/tiramillas.html</a>
                                                        </p>
                                                    </td>
                                                    <td>
                                                        <p>Unidad Editorial Información Deportiva, S.L.U.</p>
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
                                                            <br /><a href="http://www.diariomedico.com/">www.diariomedico.com</a>
                                                        </p>
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
                                                        <p>Ediciones Cónica, S.A.</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <p>Formación</p>
                                                    </td>
                                                    <td>
                                                        <p><a href="http://www.escuelaunidadeditorial.es/">www.escuelaunidadeditorial.es</a></p>
                                                    </td>
                                                    <td>
                                                        <p>Unidad Editorial Formación, S.L.U.</p>
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
                                                            <br /><a href="http://www.veo.es/">www.veo.es</a>
                                                        </p>
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
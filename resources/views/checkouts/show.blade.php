@extends('layouts.public')

@section('content')
<div class="container">
    <div class="row justify-content-center mb-4">
        <div class="col-md-8">
            <h2>Compra número: {{ $checkout->id }}<br>
                Importe {{ $checkout->amount }}€
            </h2>
            <div class="card bg-white">
                <div class="card-body">
                    <h5 class="card-title">Productos</h5>
                    <div class="table-responsive">
                        <table class="table ">
                            <thead>
                                <tr>
                                    <th>Cantidad</th>
                                    <th>Evento</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($checkout->products->groupBy('id') as $product)
                                <tr>
                                    <td>{{ $product->count() }}</td>
                                    <td>{{ $product[0]->name }} <span class="text-uppercase">{{ $product[0]->mode }}</span></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
    @if($checkout->status === 'pending' || $checkout->status === 'paid')
    <div class="row justify-content-center">
        <div class="alert alert-danger">
            Proceso de compra realizado anteriormente, disculpe las molestias.<br>Si tiene alguna duda contacte con
            nosotros en <a href="mailto:{{ $checkout->campaign->from_address}}">{{ $checkout->campaign->from_address}}</a>
        </div>
    </div>
    @else
    @if(!$discount)
    <div class="row justify-content-center mb-4">
        <div class="col-md-8">
            <div class="card bg-white">
                <div class="card-body">
                    <form method="POST" action="{{ route('deals.store', ['checkout_id' => $checkout->id]) }}" id="discount_data">
                        @csrf
                        <p>¿Tienes un código de descuento?</p>
                        <div class="form-group row">
                            <label for="code" class="col-md-4 col-form-label text-md-right">{{ __('Código') }}</label>

                            <div class="col-md-8">
                                <input id="code" type="text" class="form-control @error('code') is-invalid @enderror" name="code" value="{{ old('code') }}">
                                @error('code')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary float-right">Usar código</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if ($message = Session::get('message'))
    <div class="row justify-content-center mb-4">
        <div class="col-md-8">
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        </div>
    </div>
    @endif

    <form method="POST" action="{{ route('checkouts.update', ['checkout' => $checkout]) }}" id="invoice-data">
        @csrf
        <div class="row justify-content-center">
            <div class="col-12 col-sm-8">
                <div class="alert alert-info" role="alert">
                    <strong>Datos de facturación</strong><br>Añade nueva dirección de facturación o utiliza una
                    existente.
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            @if($addresses->count())
            <div class="col-12 col-sm-6 mb-4">
                <div class="card bg-white">
                    <p class="card-header">Puedes usar una de estas direcciones de facturación, o si lo prefieres, crear
                        una nueva en el siguiente panel</p>
                    <div class="card-body">
                        @foreach($addresses as $index => $address)
                        <div class="card">
                            <div class="card-body">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="address_id" id="address{{ $index }}" value="{{ $address->id }}">
                                    <label class="form-check-label" for="address{{ $index }}">
                                        {{ $address->name }} <small class="text-info">{{ $address->tax_id }}, {{
                                            $address->street }} {{ $address->zip }} ({{ $address->city }})</small>
                                    </label>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
            <div class="col-12 col-sm-6 mb-4">
                <div class="card bg-white">
                    <div class="card-header">{{ __('Nueva dirección de facturación') }}</div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Pagador') }}</label>

                            <div class="col-md-8">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') ?: $checkout->user->full_name }}" autocomplete="name" autofocus>

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="tax_id" class="col-md-4 col-form-label text-md-right">{{ __('DNI') }}</label>

                            <div class="col-md-3">
                                <select class="custom-select @error('tax_type') is-invalid @enderror" id="tax_type" name="tax_type">
                                    <option disabled selected value> -- Tipo de documento -- </option>
                                    <option value="NIF" {{ old('tax_type')==='NIF' ? 'selected' : '' }}>NIF</option>
                                    <option value="NIE" {{ old('tax_type')==='NIE' ? 'selected' : '' }}>NIE</option>
                                    <option value="CIF" {{ old('tax_type')==='CIF' ? 'selected' : '' }}>CIF</option>
                                    <option value="Extranjero" {{ old('tax_type')==='Extranjero' ? 'selected' : '' }}>
                                        Extranjero</option>
                                </select>

                                @error('tax_type')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="col-md-5">
                                <input id="tax_id" type="text" class="form-control @error('tax_id') is-invalid @enderror" name="tax_id" value="{{ old('tax_id') ?: $checkout->user->tax_id }}" autocomplete="tax_id" maxlength="32" placeholder="Sin guiones: A12345678">

                                @error('tax_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="street" class="col-md-4 col-form-label text-md-right">{{ __('Dirección')
                                }}</label>

                            <div class="col-md-8">
                                <input id="street" type="text" class="form-control @error('street') is-invalid @enderror" name="street" value="{{ old('street') }}" autocomplete="street">

                                @error('street')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="street_number" class="col-md-4 col-form-label text-md-right">{{ __('Número')
                                }}</label>

                            <div class="col-md-8">
                                <input id="street_number" type="text" class="form-control @error('street_number') is-invalid @enderror" name="street_number" value="{{ old('street_number') }}" autocomplete="street_number" maxlength="100">

                                @error('street_number')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="zip" class="col-md-4 col-form-label text-md-right">{{ __('Código postal')
                                }}</label>

                            <div class="col-md-4">
                                <input id="zip" type="text" class="form-control @error('zip') is-invalid @enderror" name="zip" value="{{ old('zip') }}" autocomplete="zip" maxlength="100">

                                @error('zip')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="city" class="col-md-4 col-form-label text-md-right">{{ __('Ciudad') }}</label>

                            <div class="col-md-8">
                                <input id="city" type="text" class="form-control @error('city') is-invalid @enderror" name="city" value="{{ old('city') }}" autocomplete="city" maxlength="100">

                                @error('city')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="state" class="col-md-4 col-form-label text-md-right">{{ __('Provincia')
                                }}</label>

                            <div class="col-md-8">
                                <select class="custom-select @error('state') is-invalid @enderror" name="state" id="state">
                                    <option value="" selected disabled>-- Selecciona provincia --</option>
                                    <optgroup label="Extranjero">
                                        <option value="Extranjero" {{ old('state')==='Extranjero' ? 'selected' : '' }}>
                                            Resido fuera de España</option>
                                    </optgroup>
                                    <optgroup label="España">
                                        <option {{ old('state')==='Álava' ? 'selected' : '' }}>Álava</option>
                                        <option {{ old('state')==='Albacete' ? 'selected' : '' }}>Albacete</option>
                                        <option {{ old('state')==='Alicante' ? 'selected' : '' }}>Alicante</option>
                                        <option {{ old('state')==='Almería' ? 'selected' : '' }}>Almería</option>
                                        <option {{ old('state')==='Asturias' ? 'selected' : '' }}>Asturias</option>
                                        <option {{ old('state')==='Ávila' ? 'selected' : '' }}>Ávila</option>
                                        <option {{ old('state')==='Badajoz' ? 'selected' : '' }}>Badajoz</option>
                                        <option {{ old('state')==='Baleares, Islas' ? 'selected' : '' }}>Baleares, Islas
                                        </option>
                                        <option {{ old('state')==='Barcelona' ? 'selected' : '' }}>Barcelona</option>
                                        <option {{ old('state')==='Burgos' ? 'selected' : '' }}>Burgos</option>
                                        <option {{ old('state')==='Cáceres' ? 'selected' : '' }}>Cáceres</option>
                                        <option {{ old('state')==='Cádiz' ? 'selected' : '' }}>Cádiz</option>
                                        <option {{ old('state')==='Cantabria' ? 'selected' : '' }}>Cantabria</option>
                                        <option {{ old('state')==='Castellón' ? 'selected' : '' }}>Castellón</option>
                                        <option {{ old('state')==='Ceuta' ? 'selected' : '' }}>Ceuta</option>
                                        <option {{ old('state')==='Ciudad Real' ? 'selected' : '' }}>Ciudad Real
                                        </option>
                                        <option {{ old('state')==='Córdoba' ? 'selected' : '' }}>Córdoba</option>
                                        <option {{ old('state')==='Coruña, A' ? 'selected' : '' }}>Coruña, A</option>
                                        <option {{ old('state')==='Cuenca' ? 'selected' : '' }}>Cuenca</option>
                                        <option {{ old('state')==='Girona' ? 'selected' : '' }}>Girona</option>
                                        <option {{ old('state')==='Granada' ? 'selected' : '' }}>Granada</option>
                                        <option {{ old('state')==='Guadalajara' ? 'selected' : '' }}>Guadalajara
                                        </option>
                                        <option {{ old('state')==='Guipúzcoa' ? 'selected' : '' }}>Guipúzcoa</option>
                                        <option {{ old('state')==='Huelva' ? 'selected' : '' }}>Huelva</option>
                                        <option {{ old('state')==='Huesca' ? 'selected' : '' }}>Huesca</option>
                                        <option {{ old('state')==='Jaén' ? 'selected' : '' }}>Jaén</option>
                                        <option {{ old('state')==='León' ? 'selected' : '' }}>León</option>
                                        <option {{ old('state')==='Lleida' ? 'selected' : '' }}>Lleida</option>
                                        <option {{ old('state')==='Lugo' ? 'selected' : '' }}>Lugo</option>
                                        <option {{ old('state')==='Madrid' ? 'selected' : '' }}>Madrid</option>
                                        <option {{ old('state')==='Málaga' ? 'selected' : '' }}>Málaga</option>
                                        <option {{ old('state')==='Melilla' ? 'selected' : '' }}>Melilla</option>
                                        <option {{ old('state')==='Murcia' ? 'selected' : '' }}>Murcia</option>
                                        <option {{ old('state')==='Navarra' ? 'selected' : '' }}>Navarra</option>
                                        <option {{ old('state')==='Ourense' ? 'selected' : '' }}>Ourense</option>
                                        <option {{ old('state')==='Palencia' ? 'selected' : '' }}>Palencia</option>
                                        <option {{ old('state')==='Palmas, Las' ? 'selected' : '' }}>Palmas, Las
                                        </option>
                                        <option {{ old('state')==='Pontevedra' ? 'selected' : '' }}>Pontevedra</option>
                                        <option {{ old('state')==='Rioja, La' ? 'selected' : '' }}>Rioja, La</option>
                                        <option {{ old('state')==='Salamanca' ? 'selected' : '' }}>Salamanca</option>
                                        <option {{ old('state')==='Santa Cruz de Tenerife' ? 'selected' : '' }}>Santa
                                            Cruz de Tenerife</option>
                                        <option {{ old('state')==='Segovia' ? 'selected' : '' }}>Segovia</option>
                                        <option {{ old('state')==='Sevilla' ? 'selected' : '' }}>Sevilla</option>
                                        <option {{ old('state')==='Soria' ? 'selected' : '' }}>Soria</option>
                                        <option {{ old('state')==='Tarragona' ? 'selected' : '' }}>Tarragona</option>
                                        <option {{ old('state')==='Teruel' ? 'selected' : '' }}>Teruel</option>
                                        <option {{ old('state')==='Toledo' ? 'selected' : '' }}>Toledo</option>
                                        <option {{ old('state')==='Valencia' ? 'selected' : '' }}>Valencia</option>
                                        <option {{ old('state')==='Valladolid' ? 'selected' : '' }}>Valladolid</option>
                                        <option {{ old('state')==='Vizcaya' ? 'selected' : '' }}>Vizcaya</option>
                                        <option {{ old('state')==='Zamora' ? 'selected' : '' }}>Zamora</option>
                                        <option {{ old('state')==='Zaragoza' ? 'selected' : '' }}>Zaragoza</option>
                                    </optgroup>
                                </select>

                                @error('state')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="country" class="col-md-4 col-form-label text-md-right">{{ __('Pais') }}</label>

                            <div class="col-md-8">
                                <select class="custom-select @error('country') is-invalid @enderror" id="country" name="country">
                                    <option value="AF" {{ old('country')==='AF' ? 'selected' : '' }}>Afganistán</option>
                                    <option value="AL" {{ old('country')==='AL' ? 'selected' : '' }}>Albania</option>
                                    <option value="DE" {{ old('country')==='DE' ? 'selected' : '' }}>Alemania</option>
                                    <option value="AD" {{ old('country')==='AD' ? 'selected' : '' }}>Andorra</option>
                                    <option value="AO" {{ old('country')==='AO' ? 'selected' : '' }}>Angola</option>
                                    <option value="AI" {{ old('country')==='AI' ? 'selected' : '' }}>Anguila</option>
                                    <option value="AQ" {{ old('country')==='AQ' ? 'selected' : '' }}>Antártida</option>
                                    <option value="AG" {{ old('country')==='AG' ? 'selected' : '' }}>Antigua y Barbuda
                                    </option>
                                    <option value="AN" {{ old('country')==='AN' ? 'selected' : '' }}>Antillas holandesas
                                    </option>
                                    <option value="SA" {{ old('country')==='SA' ? 'selected' : '' }}>Arabia Saudí
                                    </option>
                                    <option value="DZ" {{ old('country')==='DZ' ? 'selected' : '' }}>Argelia</option>
                                    <option value="AR" {{ old('country')==='AR' ? 'selected' : '' }}>Argentina</option>
                                    <option value="AM" {{ old('country')==='AM' ? 'selected' : '' }}>Armenia</option>
                                    <option value="AW" {{ old('country')==='AW' ? 'selected' : '' }}>Aruba</option>
                                    <option value="AU" {{ old('country')==='AU' ? 'selected' : '' }}>Australia</option>
                                    <option value="AT" {{ old('country')==='AT' ? 'selected' : '' }}>Austria</option>
                                    <option value="AZ" {{ old('country')==='AZ' ? 'selected' : '' }}>Azerbaiyán</option>
                                    <option value="BS" {{ old('country')==='BS' ? 'selected' : '' }}>Bahamas</option>
                                    <option value="BH" {{ old('country')==='BH' ? 'selected' : '' }}>Bahrein</option>
                                    <option value="BD" {{ old('country')==='BD' ? 'selected' : '' }}>Bangladesh</option>
                                    <option value="BB" {{ old('country')==='BB' ? 'selected' : '' }}>Barbados</option>
                                    <option value="BE" {{ old('country')==='BE' ? 'selected' : '' }}>Bélgica</option>
                                    <option value="BZ" {{ old('country')==='BZ' ? 'selected' : '' }}>Belice</option>
                                    <option value="BJ" {{ old('country')==='BJ' ? 'selected' : '' }}>Benín</option>
                                    <option value="BM" {{ old('country')==='BM' ? 'selected' : '' }}>Bermudas</option>
                                    <option value="BT" {{ old('country')==='BT' ? 'selected' : '' }}>Bhután</option>
                                    <option value="BY" {{ old('country')==='BY' ? 'selected' : '' }}>Bielorrusia
                                    </option>
                                    <option value="MM" {{ old('country')==='MM' ? 'selected' : '' }}>Birmania</option>
                                    <option value="BO" {{ old('country')==='BO' ? 'selected' : '' }}>Bolivia</option>
                                    <option value="BA" {{ old('country')==='BA' ? 'selected' : '' }}>Bosnia y
                                        Herzegovina</option>
                                    <option value="BW" {{ old('country')==='BW' ? 'selected' : '' }}>Botsuana</option>
                                    <option value="BR" {{ old('country')==='BR' ? 'selected' : '' }}>Brasil</option>
                                    <option value="BN" {{ old('country')==='BN' ? 'selected' : '' }}>Brunei</option>
                                    <option value="BG" {{ old('country')==='BG' ? 'selected' : '' }}>Bulgaria</option>
                                    <option value="BF" {{ old('country')==='BF' ? 'selected' : '' }}>Burkina Faso
                                    </option>
                                    <option value="BI" {{ old('country')==='BI' ? 'selected' : '' }}>Burundi</option>
                                    <option value="CV" {{ old('country')==='CV' ? 'selected' : '' }}>Cabo Verde</option>
                                    <option value="KH" {{ old('country')==='KH' ? 'selected' : '' }}>Camboya</option>
                                    <option value="CM" {{ old('country')==='CM' ? 'selected' : '' }}>Camerún</option>
                                    <option value="CA" {{ old('country')==='CA' ? 'selected' : '' }}>Canadá</option>
                                    <option value="TD" {{ old('country')==='TD' ? 'selected' : '' }}>Chad</option>
                                    <option value="CL" {{ old('country')==='CL' ? 'selected' : '' }}>Chile</option>
                                    <option value="CN" {{ old('country')==='CN' ? 'selected' : '' }}>China</option>
                                    <option value="CY" {{ old('country')==='CY' ? 'selected' : '' }}>Chipre</option>
                                    <option value="VA" {{ old('country')==='VA' ? 'selected' : '' }}>Ciudad estado del
                                        Vaticano</option>
                                    <option value="CO" {{ old('country')==='CO' ? 'selected' : '' }}>Colombia</option>
                                    <option value="KM" {{ old('country')==='KM' ? 'selected' : '' }}>Comores</option>
                                    <option value="CG" {{ old('country')==='CG' ? 'selected' : '' }}>Congo</option>
                                    <option value="KR" {{ old('country')==='KR' ? 'selected' : '' }}>Corea</option>
                                    <option value="KP" {{ old('country')==='KP' ? 'selected' : '' }}>Corea del Norte
                                    </option>
                                    <option value="CI" {{ old('country')==='CI' ? 'selected' : '' }}>Costa del Marfíl
                                    </option>
                                    <option value="CR" {{ old('country')==='CR' ? 'selected' : '' }}>Costa Rica</option>
                                    <option value="HR" {{ old('country')==='HR' ? 'selected' : '' }}>Croacia</option>
                                    <option value="CU" {{ old('country')==='CU' ? 'selected' : '' }}>Cuba</option>
                                    <option value="DK" {{ old('country')==='DK' ? 'selected' : '' }}>Dinamarca</option>
                                    <option value="DJ" {{ old('country')==='DJ' ? 'selected' : '' }}>Djibouri</option>
                                    <option value="DM" {{ old('country')==='DM' ? 'selected' : '' }}>Dominica</option>
                                    <option value="EC" {{ old('country')==='EC' ? 'selected' : '' }}>Ecuador</option>
                                    <option value="EG" {{ old('country')==='EG' ? 'selected' : '' }}>Egipto</option>
                                    <option value="SV" {{ old('country')==='SV' ? 'selected' : '' }}>El Salvador
                                    </option>
                                    <option value="AE" {{ old('country')==='AE' ? 'selected' : '' }}>Emiratos Arabes
                                        Unidos</option>
                                    <option value="ER" {{ old('country')==='ER' ? 'selected' : '' }}>Eritrea</option>
                                    <option value="SK" {{ old('country')==='SK' ? 'selected' : '' }}>Eslovaquia</option>
                                    <option value="SI" {{ old('country')==='SI' ? 'selected' : '' }}>Eslovenia</option>
                                    <option value="ES" {{ old('country')==='ES' ? 'selected' : (!old('country') ? 'selected' : '' ) }}>España</option>
                                    <option value="US" {{ old('country')==='US' ? 'selected' : '' }}>Estados Unidos
                                    </option>
                                    <option value="EE" {{ old('country')==='EE' ? 'selected' : '' }}>Estonia</option>
                                    <option value="ET" {{ old('country')==='ET' ? 'selected' : '' }}>Etiopía</option>
                                    <option value="MK" {{ old('country')==='MK' ? 'selected' : '' }}>Ex-República
                                        Yugoslava de Macedonia</option>
                                    <option value="PH" {{ old('country')==='PH' ? 'selected' : '' }}>Filipinas</option>
                                    <option value="FI" {{ old('country')==='FI' ? 'selected' : '' }}>Finlandia</option>
                                    <option value="FR" {{ old('country')==='FR' ? 'selected' : '' }}>Francia</option>
                                    <option value="GA" {{ old('country')==='GA' ? 'selected' : '' }}>Gabón</option>
                                    <option value="GM" {{ old('country')==='GM' ? 'selected' : '' }}>Gambia</option>
                                    <option value="GE" {{ old('country')==='GE' ? 'selected' : '' }}>Georgia</option>
                                    <option value="GS" {{ old('country')==='GS' ? 'selected' : '' }}>Georgia del Sur y
                                        las islas Sandwich del Sur</option>
                                    <option value="GH" {{ old('country')==='GH' ? 'selected' : '' }}>Ghana</option>
                                    <option value="GI" {{ old('country')==='GI' ? 'selected' : '' }}>Gibraltar</option>
                                    <option value="GD" {{ old('country')==='GD' ? 'selected' : '' }}>Granada</option>
                                    <option value="GR" {{ old('country')==='GR' ? 'selected' : '' }}>Grecia</option>
                                    <option value="GL" {{ old('country')==='GL' ? 'selected' : '' }}>Groenlandia
                                    </option>
                                    <option value="GP" {{ old('country')==='GP' ? 'selected' : '' }}>Guadalupe</option>
                                    <option value="GU" {{ old('country')==='GU' ? 'selected' : '' }}>Guam</option>
                                    <option value="GT" {{ old('country')==='GT' ? 'selected' : '' }}>Guatemala</option>
                                    <option value="GY" {{ old('country')==='GY' ? 'selected' : '' }}>Guayana</option>
                                    <option value="GF" {{ old('country')==='GF' ? 'selected' : '' }}>Guayana francesa
                                    </option>
                                    <option value="GN" {{ old('country')==='GN' ? 'selected' : '' }}>Guinea</option>
                                    <option value="GQ" {{ old('country')==='GQ' ? 'selected' : '' }}>Guinea Ecuatorial
                                    </option>
                                    <option value="GW" {{ old('country')==='GW' ? 'selected' : '' }}>Guinea-Bissau
                                    </option>
                                    <option value="HT" {{ old('country')==='HT' ? 'selected' : '' }}>Haití</option>
                                    <option value="NL" {{ old('country')==='NL' ? 'selected' : '' }}>Holanda</option>
                                    <option value="HN" {{ old('country')==='HN' ? 'selected' : '' }}>Honduras</option>
                                    <option value="HK" {{ old('country')==='HK' ? 'selected' : '' }}>Hong Kong R. A. E
                                    </option>
                                    <option value="HU" {{ old('country')==='HU' ? 'selected' : '' }}>Hungría</option>
                                    <option value="IN" {{ old('country')==='IN' ? 'selected' : '' }}>India</option>
                                    <option value="ID" {{ old('country')==='ID' ? 'selected' : '' }}>Indonesia</option>
                                    <option value="IQ" {{ old('country')==='IQ' ? 'selected' : '' }}>Irak</option>
                                    <option value="IR" {{ old('country')==='IR' ? 'selected' : '' }}>Irán</option>
                                    <option value="IE" {{ old('country')==='IE' ? 'selected' : '' }}>Irlanda</option>
                                    <option value="BV" {{ old('country')==='BV' ? 'selected' : '' }}>Isla Bouvet
                                    </option>
                                    <option value="CX" {{ old('country')==='CX' ? 'selected' : '' }}>Isla Christmas
                                    </option>
                                    <option value="HM" {{ old('country')==='HM' ? 'selected' : '' }}>Isla Heard e Islas
                                        McDonald</option>
                                    <option value="IS" {{ old('country')==='IS' ? 'selected' : '' }}>Islandia</option>
                                    <option value="KY" {{ old('country')==='KY' ? 'selected' : '' }}>Islas Caimán
                                    </option>
                                    <option value="CK" {{ old('country')==='CK' ? 'selected' : '' }}>Islas Cook</option>
                                    <option value="CC" {{ old('country')==='CC' ? 'selected' : '' }}>Islas de Cocos o
                                        Keeling</option>
                                    <option value="FO" {{ old('country')==='FO' ? 'selected' : '' }}>Islas Faroe
                                    </option>
                                    <option value="FJ" {{ old('country')==='FJ' ? 'selected' : '' }}>Islas Fiyi</option>
                                    <option value="FK" {{ old('country')==='FK' ? 'selected' : '' }}>Islas Malvinas
                                        Islas Falkland</option>
                                    <option value="MP" {{ old('country')==='MP' ? 'selected' : '' }}>Islas Marianas del
                                        norte</option>
                                    <option value="MH" {{ old('country')==='MH' ? 'selected' : '' }}>Islas Marshall
                                    </option>
                                    <option value="UM" {{ old('country')==='UM' ? 'selected' : '' }}>Islas menores de
                                        Estados Unidos</option>
                                    <option value="PW" {{ old('country')==='PW' ? 'selected' : '' }}>Islas Palau
                                    </option>
                                    <option value="SB" {{ old('country')==='SB' ? 'selected' : '' }}>Islas Salomón
                                    </option>
                                    <option value="TK" {{ old('country')==='TK' ? 'selected' : '' }}>Islas Tokelau
                                    </option>
                                    <option value="TC" {{ old('country')==='TC' ? 'selected' : '' }}>Islas Turks y
                                        Caicos</option>
                                    <option value="VI" {{ old('country')==='VI' ? 'selected' : '' }}>Islas Vírgenes
                                        EE.UU.</option>
                                    <option value="VG" {{ old('country')==='VG' ? 'selected' : '' }}>Islas Vírgenes
                                        Reino Unido</option>
                                    <option value="IL" {{ old('country')==='IL' ? 'selected' : '' }}>Israel</option>
                                    <option value="IT" {{ old('country')==='IT' ? 'selected' : '' }}>Italia</option>
                                    <option value="JM" {{ old('country')==='JM' ? 'selected' : '' }}>Jamaica</option>
                                    <option value="JP" {{ old('country')==='JP' ? 'selected' : '' }}>Japón</option>
                                    <option value="JO" {{ old('country')==='JO' ? 'selected' : '' }}>Jordania</option>
                                    <option value="KZ" {{ old('country')==='KZ' ? 'selected' : '' }}>Kazajistán</option>
                                    <option value="KE" {{ old('country')==='KE' ? 'selected' : '' }}>Kenia</option>
                                    <option value="KG" {{ old('country')==='KG' ? 'selected' : '' }}>Kirguizistán
                                    </option>
                                    <option value="KI" {{ old('country')==='KI' ? 'selected' : '' }}>Kiribati</option>
                                    <option value="KW" {{ old('country')==='KW' ? 'selected' : '' }}>Kuwait</option>
                                    <option value="LA" {{ old('country')==='LA' ? 'selected' : '' }}>Laos</option>
                                    <option value="LS" {{ old('country')==='LS' ? 'selected' : '' }}>Lesoto</option>
                                    <option value="LV" {{ old('country')==='LV' ? 'selected' : '' }}>Letonia</option>
                                    <option value="LB" {{ old('country')==='LB' ? 'selected' : '' }}>Líbano</option>
                                    <option value="LR" {{ old('country')==='LR' ? 'selected' : '' }}>Liberia</option>
                                    <option value="LY" {{ old('country')==='LY' ? 'selected' : '' }}>Libia</option>
                                    <option value="LI" {{ old('country')==='LI' ? 'selected' : '' }}>Liechtenstein
                                    </option>
                                    <option value="LT" {{ old('country')==='LT' ? 'selected' : '' }}>Lituania</option>
                                    <option value="LU" {{ old('country')==='LU' ? 'selected' : '' }}>Luxemburgo</option>
                                    <option value="MO" {{ old('country')==='MO' ? 'selected' : '' }}>Macao R. A. E
                                    </option>
                                    <option value="MG" {{ old('country')==='MG' ? 'selected' : '' }}>Madagascar</option>
                                    <option value="MY" {{ old('country')==='MY' ? 'selected' : '' }}>Malasia</option>
                                    <option value="MW" {{ old('country')==='MW' ? 'selected' : '' }}>Malawi</option>
                                    <option value="MV" {{ old('country')==='MV' ? 'selected' : '' }}>Maldivas</option>
                                    <option value="ML" {{ old('country')==='ML' ? 'selected' : '' }}>Malí</option>
                                    <option value="MT" {{ old('country')==='MT' ? 'selected' : '' }}>Malta</option>
                                    <option value="MA" {{ old('country')==='MA' ? 'selected' : '' }}>Marruecos</option>
                                    <option value="MQ" {{ old('country')==='MQ' ? 'selected' : '' }}>Martinica</option>
                                    <option value="MU" {{ old('country')==='MU' ? 'selected' : '' }}>Mauricio</option>
                                    <option value="MR" {{ old('country')==='MR' ? 'selected' : '' }}>Mauritania</option>
                                    <option value="YT" {{ old('country')==='YT' ? 'selected' : '' }}>Mayotte</option>
                                    <option value="MX" {{ old('country')==='MX' ? 'selected' : '' }}>México</option>
                                    <option value="FM" {{ old('country')==='FM' ? 'selected' : '' }}>Micronesia</option>
                                    <option value="MD" {{ old('country')==='MD' ? 'selected' : '' }}>Moldavia</option>
                                    <option value="MC" {{ old('country')==='MC' ? 'selected' : '' }}>Mónaco</option>
                                    <option value="MN" {{ old('country')==='MN' ? 'selected' : '' }}>Mongolia</option>
                                    <option value="MS" {{ old('country')==='MS' ? 'selected' : '' }}>Montserrat</option>
                                    <option value="MZ" {{ old('country')==='MZ' ? 'selected' : '' }}>Mozambique</option>
                                    <option value="NA" {{ old('country')==='NA' ? 'selected' : '' }}>Namibia</option>
                                    <option value="NR" {{ old('country')==='NR' ? 'selected' : '' }}>Nauru</option>
                                    <option value="NP" {{ old('country')==='NP' ? 'selected' : '' }}>Nepal</option>
                                    <option value="NI" {{ old('country')==='NI' ? 'selected' : '' }}>Nicaragua</option>
                                    <option value="NE" {{ old('country')==='NE' ? 'selected' : '' }}>Níger</option>
                                    <option value="NG" {{ old('country')==='NG' ? 'selected' : '' }}>Nigeria</option>
                                    <option value="NU" {{ old('country')==='NU' ? 'selected' : '' }}>Niue</option>
                                    <option value="NF" {{ old('country')==='NF' ? 'selected' : '' }}>Norfolk</option>
                                    <option value="NO" {{ old('country')==='NO' ? 'selected' : '' }}>Noruega</option>
                                    <option value="NC" {{ old('country')==='NC' ? 'selected' : '' }}>Nueva Caledonia
                                    </option>
                                    <option value="NZ" {{ old('country')==='NZ' ? 'selected' : '' }}>Nueva Zelanda
                                    </option>
                                    <option value="OM" {{ old('country')==='OM' ? 'selected' : '' }}>Omán</option>
                                    <option value="PA" {{ old('country')==='PA' ? 'selected' : '' }}>Panamá</option>
                                    <option value="PG" {{ old('country')==='PG' ? 'selected' : '' }}>Papua Nueva Guinea
                                    </option>
                                    <option value="PK" {{ old('country')==='PK' ? 'selected' : '' }}>Paquistán</option>
                                    <option value="PY" {{ old('country')==='PY' ? 'selected' : '' }}>Paraguay</option>
                                    <option value="PE" {{ old('country')==='PE' ? 'selected' : '' }}>Perú</option>
                                    <option value="PN" {{ old('country')==='PN' ? 'selected' : '' }}>Pitcairn</option>
                                    <option value="PF" {{ old('country')==='PF' ? 'selected' : '' }}>Polinesia francesa
                                    </option>
                                    <option value="PL" {{ old('country')==='PL' ? 'selected' : '' }}>Polonia</option>
                                    <option value="PT" {{ old('country')==='PT' ? 'selected' : '' }}>Portugal</option>
                                    <option value="PR" {{ old('country')==='PR' ? 'selected' : '' }}>Puerto Rico
                                    </option>
                                    <option value="QA" {{ old('country')==='QA' ? 'selected' : '' }}>Qatar</option>
                                    <option value="GB" {{ old('country')==='GB' ? 'selected' : '' }}>Reino Unido
                                    </option>
                                    <option value="CF" {{ old('country')==='CF' ? 'selected' : '' }}>República
                                        Centroafricana</option>
                                    <option value="CZ" {{ old('country')==='CZ' ? 'selected' : '' }}>República Checa
                                    </option>
                                    <option value="ZA" {{ old('country')==='ZA' ? 'selected' : '' }}>República de
                                        Sudáfrica</option>
                                    <option value="CD" {{ old('country')==='CD' ? 'selected' : '' }}>República
                                        Democrática del Congo Zaire</option>
                                    <option value="DO" {{ old('country')==='DO' ? 'selected' : '' }}>República
                                        Dominicana</option>
                                    <option value="RE" {{ old('country')==='RE' ? 'selected' : '' }}>Reunión</option>
                                    <option value="RW" {{ old('country')==='RW' ? 'selected' : '' }}>Ruanda</option>
                                    <option value="RO" {{ old('country')==='RO' ? 'selected' : '' }}>Rumania</option>
                                    <option value="RU" {{ old('country')==='RU' ? 'selected' : '' }}>Rusia</option>
                                    <option value="WS" {{ old('country')==='WS' ? 'selected' : '' }}>Samoa</option>
                                    <option value="AS" {{ old('country')==='AS' ? 'selected' : '' }}>Samoa occidental
                                    </option>
                                    <option value="KN" {{ old('country')==='KN' ? 'selected' : '' }}>San Kitts y Nevis
                                    </option>
                                    <option value="SM" {{ old('country')==='SM' ? 'selected' : '' }}>San Marino</option>
                                    <option value="PM" {{ old('country')==='PM' ? 'selected' : '' }}>San Pierre y
                                        Miquelon</option>
                                    <option value="VC" {{ old('country')==='VC' ? 'selected' : '' }}>San Vicente e Islas
                                        Granadinas</option>
                                    <option value="SH" {{ old('country')==='SH' ? 'selected' : '' }}>Santa Helena
                                    </option>
                                    <option value="LC" {{ old('country')==='LC' ? 'selected' : '' }}>Santa Lucía
                                    </option>
                                    <option value="ST" {{ old('country')==='ST' ? 'selected' : '' }}>Santo Tomé y
                                        Príncipe</option>
                                    <option value="SN" {{ old('country')==='SN' ? 'selected' : '' }}>Senegal</option>
                                    <option value="YU" {{ old('country')==='YU' ? 'selected' : '' }}>Serbia y Montenegro
                                    </option>
                                    <option value="SC" {{ old('country')==='SC' ? 'selected' : '' }}>Seychelles</option>
                                    <option value="SL" {{ old('country')==='SL' ? 'selected' : '' }}>Sierra Leona
                                    </option>
                                    <option value="SG" {{ old('country')==='SG' ? 'selected' : '' }}>Singapur</option>
                                    <option value="SY" {{ old('country')==='SY' ? 'selected' : '' }}>Siria</option>
                                    <option value="SO" {{ old('country')==='SO' ? 'selected' : '' }}>Somalia</option>
                                    <option value="LK" {{ old('country')==='LK' ? 'selected' : '' }}>Sri Lanka</option>
                                    <option value="SZ" {{ old('country')==='SZ' ? 'selected' : '' }}>Suazilandia
                                    </option>
                                    <option value="SD" {{ old('country')==='SD' ? 'selected' : '' }}>Sudán</option>
                                    <option value="SE" {{ old('country')==='SE' ? 'selected' : '' }}>Suecia</option>
                                    <option value="CH" {{ old('country')==='CH' ? 'selected' : '' }}>Suiza</option>
                                    <option value="SR" {{ old('country')==='SR' ? 'selected' : '' }}>Surinam</option>
                                    <option value="SJ" {{ old('country')==='SJ' ? 'selected' : '' }}>Svalbard</option>
                                    <option value="TH" {{ old('country')==='TH' ? 'selected' : '' }}>Tailandia</option>
                                    <option value="TW" {{ old('country')==='TW' ? 'selected' : '' }}>Taiwán</option>
                                    <option value="TZ" {{ old('country')==='TZ' ? 'selected' : '' }}>Tanzania</option>
                                    <option value="TJ" {{ old('country')==='TJ' ? 'selected' : '' }}>Tayikistán</option>
                                    <option value="IO" {{ old('country')==='IO' ? 'selected' : '' }}>Territorios
                                        británicos del océano Indico</option>
                                    <option value="TF" {{ old('country')==='TF' ? 'selected' : '' }}>Territorios
                                        franceses del sur</option>
                                    <option value="TP" {{ old('country')==='TP' ? 'selected' : '' }}>Timor Oriental
                                    </option>
                                    <option value="TG" {{ old('country')==='TG' ? 'selected' : '' }}>Togo</option>
                                    <option value="TO" {{ old('country')==='TO' ? 'selected' : '' }}>Tonga</option>
                                    <option value="TT" {{ old('country')==='TT' ? 'selected' : '' }}>Trinidad y Tobago
                                    </option>
                                    <option value="TN" {{ old('country')==='TN' ? 'selected' : '' }}>Túnez</option>
                                    <option value="TM" {{ old('country')==='TM' ? 'selected' : '' }}>Turkmenistán
                                    </option>
                                    <option value="TR" {{ old('country')==='TR' ? 'selected' : '' }}>Turquía</option>
                                    <option value="TV" {{ old('country')==='TV' ? 'selected' : '' }}>Tuvalu</option>
                                    <option value="UA" {{ old('country')==='UA' ? 'selected' : '' }}>Ucrania</option>
                                    <option value="UG" {{ old('country')==='UG' ? 'selected' : '' }}>Uganda</option>
                                    <option value="UY" {{ old('country')==='UY' ? 'selected' : '' }}>Uruguay</option>
                                    <option value="UZ" {{ old('country')==='UZ' ? 'selected' : '' }}>Uzbekistán</option>
                                    <option value="VU" {{ old('country')==='VU' ? 'selected' : '' }}>Vanuatu</option>
                                    <option value="VE" {{ old('country')==='VE' ? 'selected' : '' }}>Venezuela</option>
                                    <option value="VN" {{ old('country')==='VN' ? 'selected' : '' }}>Vietnam</option>
                                    <option value="WF" {{ old('country')==='WF' ? 'selected' : '' }}>Wallis y Futuna
                                    </option>
                                    <option value="YE" {{ old('country')==='YE' ? 'selected' : '' }}>Yemen</option>
                                    <option value="ZM" {{ old('country')==='ZM' ? 'selected' : '' }}>Zambia</option>
                                    <option value="ZW" {{ old('country')==='ZW' ? 'selected' : '' }}>Zimbabue</option>
                                </select>


                                @error('country')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-8 offset-sm-4">
                                <a class="btn btn-secondary btn-block mb-3 text-center" role="button" data-toggle="collapse" href="#publicCompanyFields" aria-expanded="true" aria-controls="publicCompanyFields"><i class="ion-md-android-clipboard"></i>
                                    Pertenezco a Empresa Pública</a>
                                <div class="collapse in" id="publicCompanyFields" aria-expanded="true" style="">
                                    <label for="ofcont" class="control-label">Oficina Contable</label>
                                    <input class="form-control mb-3" id="ofcont" title="Introduzca la oficina contable" name="ofcont" type="text">
                                    <label for="gestor" class="control-label">Órgano Gestor</label>
                                    <input class="form-control mb-3" id="gestor" title="Introduzca el órgano gestor" name="gestor" type="text">
                                    <label for="untram" class="control-label">Unidad Tramitadora</label>
                                    <input class="form-control mb-3" id="untram" title="Introduzca la Unidad Tramitadora" name="untram" type="text">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="col-12 col-sm-12">
                <div class="form-group form-check">
                    <input type="checkbox" class="form-check-input" id="to_bill" value="0" name="to_bill">
                    <label class="form-check-label" for="to_bill">Dividir factura</label>
                </div>
            </div> --}}
            <div class="col-12 col-sm-12">
                <div class="form-group form-check">
                    <input type="checkbox" class="form-check-input" id="legal" required name="legal">
                    <label class="form-check-label" for="legal">He leído y acepto los <a href="{{ route('terminos-y-condiciones', ['c' => $checkout->campaign]) }}">términos y condiciones
                            generales de la compra</a>.</label>
                </div>
                <p class="small">
                    {!! $checkout->campaign->legal !!}
                </p>
            </div>
            <div class="col-12">
                <div class="text-center">
                    <button type="submit" class="btn btn-primary btn-lg text-white">
                        {{ __('Proceder al pago') }}
                    </button>
                </div>
            </div>
        </div>
    </form>
    @endif
</div>
@endsection

@if(isset($checkout))
@include('partials.' . $checkout->campaign->partner->client->slug . '.checkout')
@endif
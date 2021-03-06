<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class IIForoController extends Controller
{
    public function streaming(Request $request)
    {
        $user = auth()->user();

        $products = [1, 2];
        $paid = false;

        foreach ($user->registrations as $registration) {
            if ($registration->status === 'paid') {
                if (in_array($registration->product_id, $products)) {
                    $paid = true;
                }
            }
        }

        if (!$paid) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        return $this->getStream($request->lang);
    }

    public function streamingNoAuth(Request $request)
    {
        return $this->getStream($request->lang);
    }

    private function getStream($lang = 'es')
    {
        $url = 'https://foro.expansion.com/live.json';

        $json = json_decode(file_get_contents($url), true);

        if ($json['stream'] === 'stream-1-1') {
            // Cuando tentamos el streaming, hacer wrap con
            //     <div class="embed-responsive embed-responsive-16by9">
            if ($lang === 'en') {
                return [
                    'streaming' => '<div style="width: 100%;"><div style="position: relative; padding-bottom: 56.25%;"><iframe style="position: absolute; width: 100%; height: 100%;" src="https://ikuna.s3.amazonaws.com/sync01/event_660_ccf98b/streaming.html" frameborder="0" allowtransparency="true" allowfullscreen></iframe></div></div>'
                ];
            } else {
                return [
                    'streaming' => '<div style="width: 100%;"><div style="position: relative; padding-bottom: 56.25%;"><iframe style="position: absolute; width: 100%; height: 100%;" src="https://ikuna.s3.amazonaws.com/sync01/event_659_20286a/streaming.html" frameborder="0" allowtransparency="true" allowfullscreen></iframe></div></div>'
                ];
            }
        } elseif ($json['stream'] === 'stream-2-1') {
            // Cuando tentamos el streaming, hacer wrap con
            //     <div class="embed-responsive embed-responsive-16by9">
            if ($lang === 'en') {
                return [
                    'streaming' => '<div style="width: 100%;"><div style="position: relative; padding-bottom: 56.25%;"><iframe style="position: absolute; width: 100%; height: 100%;" src="https://ikuna.s3.amazonaws.com/sync01/event_662_ddeb88/streaming.html" frameborder="0" allowtransparency="true" allowfullscreen></iframe></div></div>'
                ];
            } else {
                return [
                    'streaming' => '<div style="width: 100%;"><div style="position: relative; padding-bottom: 56.25%;"><iframe style="position: absolute; width: 100%; height: 100%;" src="https://ikuna.s3.amazonaws.com/sync01/event_661_10b763/streaming.html" frameborder="0" allowtransparency="true" allowfullscreen></iframe></div></div>'
                ];
            }
        } else {
            if ($lang === 'en') {
                return [
                    'streaming' => '<div style="width: 100%;"><div style="position: relative; padding-bottom: 56.25%;"><iframe style="position: absolute; width: 100%; height: 100%;" src="https://ikuna.s3.amazonaws.com/sync01/event_658_40b7d6/streaming.html" frameborder="0" allowtransparency="true" allowfullscreen></iframe></div></div>'
                ];
            } else {
                return [
                    'streaming' => '<div style="width: 100%;"><div style="position: relative; padding-bottom: 56.25%;"><iframe style="position: absolute; width: 100%; height: 100%;" src="https://ikuna.s3.amazonaws.com/sync01/event_657_993572/streaming.html" frameborder="0" allowtransparency="true" allowfullscreen></iframe></div></div>'
                ];
            }
        }
    }

    public function registrations()
    {
        $user = auth()->user();

        $products = [1, 2];
        $paid = false;
        $productId = null;

        foreach ($user->registrations as $registration) {
            if ($registration->status === 'paid') {
                if (in_array($registration->product_id, $products)) {
                    $paid = true;
                    $productId = $registration->product_id;
                }
            }
        }

        if (!$paid) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        return $this->getRegistrations($productId);
    }

    public function registrationsNoAuth()
    {
        $productId = 2;

        return $this->getRegistrations($productId);
    }

    private function getRegistrations(int $productId)
    {
        $url = 'https://foro.expansion.com/api/speakers.json';
        $JSON = file_get_contents($url);

        $speakers = json_decode($JSON, true);

        $product = Product::findOrFail($productId);

        $registrations = [];

        foreach ($product->registrations as $registration) {
            if ($registration->status === 'paid') {
                $registrations[] = [
                    'name' => $registration->user->full_name_uppercase,
                    'last_name' => strtoupper($registration->user->last_name),
                    'description' => $registration->user->position . ', ' . $registration->user->company,
                    'speaker' => false,
                    'online' => false,
                ];
            }
        }

        $registrations = array_merge($speakers, $registrations);

        if ($productId === 2) {
            $registrations = array_merge($registrations, $this->manualRegistrations());
        }

        $lastName = array_column($registrations, 'last_name');

        array_multisort($lastName, SORT_ASC, $registrations);

        $sortedRegistrations = [];

        foreach ($registrations as $registration) {
            $first_letter = mb_substr($registration['last_name'], 0, 1, 'UTF-8');

            $sortedRegistrations[$first_letter][] = $registration;
        }

        return $sortedRegistrations;
    }

    private function manualRegistrations()
    {
        return [
            [
              "name" => "Xavier GISBERT DA CRUZ",
              "last_name" => "GISBERT DA CRUZ",
              "description" => "Presidente, ASOCIACI??N DE LA ENSE??ANZA BILING??E",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Natalia D??AZ LARRAURA",
              "last_name" => "D??AZ LARRAURA",
              "description" => "Comunicaci??n, ASTRAZENECA",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Marta MORENO",
              "last_name" => "MORENO",
              "description" => "Directora de Asuntos Corporativos y Acceso al Mercado, ASTRAZENECA",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Mar??a ARANGUEREN",
              "last_name" => "ARANGUEREN",
              "description" => "2?? Teniente de Alcalde, AYUNTAMIENTO DE ALCAL?? DE HENARES",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Alberto BLAZQUEZ",
              "last_name" => "BLAZQUEZ",
              "description" => "1er Teniente de Alcalde, AYUNTAMIENTO DE ALCAL?? DE HENARES",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Diana D??AZ",
              "last_name" => "D??AZ",
              "description" => "3er Teniente de Alcalde, AYUNTAMIENTO DE ALCAL?? DE HENARES",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Ricardo GONZ??LEZ-PARRA",
              "last_name" => "GONZ??LEZ-PARRA",
              "description" => "Portavoz Grupo Municipal Ciudadanos, AYUNTAMIENTO DE ALCAL?? DE HENARES",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Teresa L??PER HERVAS",
              "last_name" => "L??PER HERVAS",
              "description" => "Portavoz Grupo municipal Unidas Podemos, AYUNTAMIENTO DE ALCAL?? DE HENARES",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Javier MORENO",
              "last_name" => "MORENO",
              "description" => "Portavoz Grupo Municipal VOX, AYUNTAMIENTO DE ALCAL?? DE HENARES",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Judith PIQUET FLORES",
              "last_name" => "PIQUET FLORES",
              "description" => "Portavoz Grupo Municipal PP, AYUNTAMIENTO DE ALCAL?? DE HENARES",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "V??ctor MARQUEZ",
              "last_name" => "MARQUEZ",
              "description" => "Director de Comunicaci??n, BANCO DE ESPA??A",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Carina MICKEVICIUTE",
              "last_name" => "MICKEVICIUTE",
              "description" => "Corporate Communications Iberia, BLACKROCK",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "M??nica AUSEJO SEGURA",
              "last_name" => "AUSEJO SEGURA",
              "description" => "Directora Market Access Spain & Portugal, BRISTOL MYERS SQUIBB",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Miguel GARRIDO DE LA CIERVA",
              "last_name" => "GARRIDO DE LA CIERVA",
              "description" => "Presidente, CEIM",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Enrique RODR??GUEZ",
              "last_name" => "RODR??GUEZ",
              "description" => "Director de Comunicaci??n, CEPSA",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Juan LLOBELL",
              "last_name" => "LLOBELL",
              "description" => "Director de Comunicaci??n y Relaciones Institucionales, CEPSA",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Ignacio RODR??GEZ-SOLANO",
              "last_name" => "RODR??GEZ-SOLANO",
              "description" => "Responsable de Relaciones Institucionales, CEPSA",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Manuel P??REZ-SALA",
              "last_name" => "P??REZ-SALA",
              "description" => "Presidente, C??RCULO DE EMPRESARIOS",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Maru MERINO",
              "last_name" => "MERINO",
              "description" => "Jefe de Protocolo de la Consejera de Presidencia, COMUNIDAD DE MADRID",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Joaquin GORDON",
              "last_name" => "GORDON",
              "description" => "Director General, ELIZABETH ARDEN",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Hildur Eir JONSDOTTIR",
              "last_name" => "JONSDOTTIR",
              "description" => "Socia directora de Assurance, EY ESPA??A",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Ram??n PALAC??N",
              "last_name" => "PALAC??N",
              "description" => "socio director, EY ESPA??A",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Goyo PANADERO",
              "last_name" => "PANADERO",
              "description" => "Director de Comunicaci??n en Espa??a, EY ESPA??A",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Ignacio REL PLA",
              "last_name" => "REL PLA",
              "description" => "Socio director de Consulting, EY ESPA??A",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Juan PABLO RIESGO",
              "last_name" => "RIESGO",
              "description" => "Socio responsable, EY ESPA??A",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Rafael DEL PINO Y CALVO-SOTELO",
              "last_name" => "DEL PINO Y CALVO-SOTELO",
              "description" => "PRESIDENTE, FERROVIAL",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Ana CABOS",
              "last_name" => "CABOS",
              "description" => "Directora de Comunicaci??n, FUNDACI??N FAES",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Roc??o MART??NEZ-SEMPERE",
              "last_name" => "MART??NEZ-SEMPERE",
              "description" => "Directora, FUNDACI??N FELIPE GONZ??LEZ",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Miguel ??ngel OLIVER",
              "last_name" => "OLIVER",
              "description" => "Secretario de Estado de Comunicaci??n, GOBIERNO DE ESPA??A",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Bego??a DE LA SOTA",
              "last_name" => "DE LA SOTA",
              "description" => "CEO, GROUP M",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Beatriz DELGADO",
              "last_name" => "DELGADO",
              "description" => "CEO, GROUP M",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Jos?? GARC??A",
              "last_name" => "GARC??A",
              "description" => "Socio de la agencia de comunicaci??n Grupo Albi??n, asesor de comunicaci??n, GRUPO ALBIOL",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Raquel GARC??A",
              "last_name" => "GARC??A",
              "description" => "Directora General, GRUPO LAUDER",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Leopoldo SATRUSTEGUI",
              "last_name" => "SATRUSTEGUI",
              "description" => "DIRECTOR GENERAL, HYUNDAI ESPA??A",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "F??lix SANZ ROLD??N",
              "last_name" => "SANZ ROLD??N",
              "description" => "Ex director del CNI, IBERDROLA",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Juan CIERCO",
              "last_name" => "CIERCO",
              "description" => "Director de Comunicaci??n, IBERIA",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Herminio GRANERO",
              "last_name" => "GRANERO",
              "description" => "Executive Director, INGRAM MICRO SPAIN",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Roc??o M??rquez PAPELL",
              "last_name" => "M??RQUEZ PAPELL",
              "description" => "Directora de Comunicaci??n Josep Piqu??",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Dimas GIMENO",
              "last_name" => "GIMENO",
              "description" => "Presidente, KAPITA / WOW",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Ana JAUREGUIZAR",
              "last_name" => "JAUREGUIZAR",
              "description" => "Directora General, L'OREAL DIVISI??N PRODUCTOS DE LUJO",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Juan Alonso DE LOMAS",
              "last_name" => "DE LOMAS",
              "description" => "Presidente y Consejero delegado, L'OREAL ESPA??A",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Juan Pedro ABENIACAR",
              "last_name" => "ABENIACAR",
              "description" => "CEO, LVMH",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Ignacio BAEZA",
              "last_name" => "BAEZA",
              "description" => "Vicepresidente, MAPFRE",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Jos?? Manuel INCHAUSTI",
              "last_name" => "INCHAUSTI",
              "description" => "Vicepresidente y CEO, MAPFRE ESPA??A",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Toni MART??NEZ",
              "last_name" => "MART??NEZ",
              "description" => "Director de Comunicaci??n, MERCADONA",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Miguel Primo de Rivera",
              "last_name" => "PRIMO DE RIVERA",
              "description" => "Conductor del acto, MICHI PRIMO DE RIVERA",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Eduardo C??RDOBA",
              "last_name" => "C??RDOBA",
              "description" => "Comunicaci??n, MINISTERIO DE ASUNTOS EXTERIORES Y COOPERACI??N",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Vicente MONT??VEZ",
              "last_name" => "MONT??VEZ",
              "description" => "Asesor, MINISTERIO DE ASUNTOS EXTERIORES Y COOPERACI??N",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Jordi Garc??a TABERNERO",
              "last_name" => "GARC??A TABERNERO",
              "description" => "DG Sostenibilidad, Marca y RRII, NATURGY",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Patricia BENITO DE MATEO",
              "last_name" => "BENITO DE MATEO",
              "description" => "Directora General, OPEN BANK",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Pedro SORIA",
              "last_name" => "SORIA",
              "description" => "Director, PARADOR DE ALCAL?? DE HENARES",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Pablo CASADO",
              "last_name" => "CASADO",
              "description" => "Presidente, PARTIDO POPULAR",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Joan JORDI VALLVERD??",
              "last_name" => "JORDI VALLVERD??",
              "description" => "CEO, PUBLICIS",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Urbano CAIRO",
              "last_name" => "CAIRO",
              "description" => "Presidente, RCS",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Ant??nio SIM??ES",
              "last_name" => "SIM??ES",
              "description" => "CEO Santander Espa??a y Europa, SANTANDER ESPA??A",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Amalia NAVARRO",
              "last_name" => "NAVARRO",
              "description" => "Directora de Comunicaci??n, Secretar??a General Iberoamericana (SEGIB)",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Andr??s Miguel ROND??N",
              "last_name" => "ROND??N",
              "description" => "Asesor de Gabinete, Secretar??a General Iberoamericana (SEGIB)",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Manuel SERRANO",
              "last_name" => "SERRANO",
              "description" => "Director general financiero, TENDAM",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Ignacio SIERRA",
              "last_name" => "SIERRA",
              "description" => "Director de Comunicaci??n, TENDAM",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Marta ORTIZ",
              "last_name" => "ORTIZ",
              "description" => "Vicepresidenta, THE EUROPEAN HOUSE-AMBROSETTI",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Maria Adelaide PIANO MORTARI",
              "last_name" => "PIANO MORTARI",
              "description" => "Associate Partner, THE EUROPEAN HOUSE-AMBROSETTI",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Jes??s ESCUDERO GONZ??LEZ",
              "last_name" => "ESCUDERO GONZ??LEZ",
              "description" => "Director de Banca Corporativa, UNICAJA",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "David IGLESIAS RICO",
              "last_name" => "IGLESIAS RICO",
              "description" => "Director de Segmento Empresas de Madrid, UNICAJA",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Francisco Javier MOLINUEVO",
              "last_name" => "MOLINUEVO",
              "description" => "Coordinador de Banca Corporativa, UNICAJA",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Isabel VILAPLANA SEMPERE",
              "last_name" => "VILAPLANA SEMPERE",
              "description" => "Directora de Segmento Sector P??blico Norte, UNICAJA",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Mayte ALONSO AYUSO",
              "last_name" => "ALONSO AYUSO",
              "description" => "EXPANSI??N, UNIDAD EDITORIAL",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Rebeca ARROYO",
              "last_name" => "ARROYO",
              "description" => "EXPANSI??N, UNIDAD EDITORIAL",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Stefania BEDOGNI",
              "last_name" => "BEDOGNI",
              "description" => "Directora General y Consejera, UNIDAD EDITORIAL",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Pedro BIURRUN",
              "last_name" => "BIURRUN",
              "description" => "Subdirector de Expansi??n, UNIDAD EDITORIAL",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Roberto CASADO",
              "last_name" => "CASADO",
              "description" => "EXPANSI??N, UNIDAD EDITORIAL",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Gonzalo CASAS",
              "last_name" => "CASAS",
              "description" => "Director de Publicidad, UNIDAD EDITORIAL",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Ra??l CASTILLO HERRERO",
              "last_name" => "CASTILLO HERRERO",
              "description" => "Director Comercial, UNIDAD EDITORIAL",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Mar DE VICENTE",
              "last_name" => "DE VICENTE",
              "description" => "Directora de Publicidad, UNIDAD EDITORIAL",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Manuel DEL POZO",
              "last_name" => "DEL POZO",
              "description" => "Director Adjunto de Expansi??n, UNIDAD EDITORIAL",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Valent??n FERN??NDEZ",
              "last_name" => "FERN??NDEZ",
              "description" => "Redactor Jefe Expansi??n, UNIDAD EDITORIAL",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Aurelio FERN??NDEZ LOZANO",
              "last_name" => "FERN??NDEZ LOZANO",
              "description" => "Director General de Publicaciones, UNIDAD EDITORIAL",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Luis FONT??N",
              "last_name" => "FONT??N",
              "description" => "Director de Negocio de Expansi??n, UNIDAD EDITORIAL",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Ignacio GARAY",
              "last_name" => "GARAY",
              "description" => "Director Adjunto de Expansi??n, UNIDAD EDITORIAL",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Juan Jos?? GARRIDO DE LA CIERVA",
              "last_name" => "GARRIDO DE LA CIERVA",
              "description" => "Redactor Jefe Expansi??n, UNIDAD EDITORIAL",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Miguel GONZ??LEZ CORRAL",
              "last_name" => "GONZ??LEZ CORRAL",
              "description" => "Director del ??rea de Salud, UNIDAD EDITORIAL",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Joaqu??n MANSO",
              "last_name" => "MANSO",
              "description" => "Director Adjunto de El Mundo, UNIDAD EDITORIAL",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Javier MONTALVO",
              "last_name" => "MONTALVO",
              "description" => "Redactor Jefe Expansi??n, UNIDAD EDITORIAL",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Tacho ORERO",
              "last_name" => "ORERO",
              "description" => "Director de Publicidad, UNIDAD EDITORIAL",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Miguel ??ngel PATI??O",
              "last_name" => "PATI??O",
              "description" => "Redactor Jefe de Expansi??n, UNIDAD EDITORIAL",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Amparo POLO",
              "last_name" => "POLO",
              "description" => "EXPANSI??N, UNIDAD EDITORIAL",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Silvia ROM??N",
              "last_name" => "ROM??N",
              "description" => "Redactora Jefe de Internacional de El Mundo, UNIDAD EDITORIAL",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Francisco ROSELL",
              "last_name" => "ROSELL",
              "description" => "Director de El Mundo, UNIDAD EDITORIAL",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Clara RUIZ DE GAUNA",
              "last_name" => "RUIZ DE GAUNA",
              "description" => "Redactora Jefe de Expansi??n, UNIDAD EDITORIAL",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Mart?? SABALLS",
              "last_name" => "SABALLS",
              "description" => "Director Adjunto de El Mundo, UNIDAD EDITORIAL",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Arancha S??NCHEZ FERN??NDEZ",
              "last_name" => "S??NCHEZ FERN??NDEZ",
              "description" => "Directora de Publicidad, UNIDAD EDITORIAL",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Jos?? Luis S??NCHEZ-CRESPO",
              "last_name" => "S??NCHEZ-CRESPO",
              "description" => "Director de Publicidad, UNIDAD EDITORIAL",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Estela SANTOS",
              "last_name" => "SANTOS",
              "description" => "Redactora Jefe de Expansi??n, UNIDAD EDITORIAL",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Chary SERRANO",
              "last_name" => "SERRANO",
              "description" => "Directora de Negocio ??rea Salud, UNIDAD EDITORIAL",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Nicola SPERONI",
              "last_name" => "SPERONI",
              "description" => "Director General y Consejero, UNIDAD EDITORIAL",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Miguel SU??REZ",
              "last_name" => "SU??REZ",
              "description" => "Director de Publicidad, UNIDAD EDITORIAL",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Emelia VIA??A",
              "last_name" => "VIA??A",
              "description" => "Redactora Jefe de Expansi??n, UNIDAD EDITORIAL",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Jes??s ZABALLA",
              "last_name" => "ZABALLA",
              "description" => "Director General de Publicidad, UNIDAD EDITORIAL",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Artur ZANON",
              "last_name" => "ZANON",
              "description" => "EXPANSI??N, UNIDAD EDITORIAL",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Antonio GARC??A TABUENCA",
              "last_name" => "GARC??A TABUENCA",
              "description" => "Decano de la facultad de Economicas, Empresariales y Turismo, UNIVERSIDAD DE ALCAL?? DE HENARES",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Jose GONZALO ANGULO",
              "last_name" => "GONZALO ANGULO",
              "description" => "Director del Dpto de Econom??a y Direcci??n de Empresas, UNIVERSIDAD DE ALCAL?? DE HENARES",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Tom??s MANCHA",
              "last_name" => "MANCHA",
              "description" => "Catedratico de Econom??a Aplicada, UNIVERSIDAD DE ALCAL?? DE HENARES",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Carlos MARIO G??MEZ",
              "last_name" => "MARIO G??MEZ",
              "description" => "Director del Dpto de Econom??a, UNIVERSIDAD DE ALCAL?? DE HENARES",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Carmen ALVEAR",
              "last_name" => "ALVEAR",
              "description" => "Directora de RRII, VODAFONE",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Colman DEEGAN",
              "last_name" => "DEEGAN",
              "description" => "CEO, Vodafone",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Francisco Jos?? P??REZ BOTELLO",
              "last_name" => "P??REZ BOTELLO",
              "description" => "PRESIDENTE, VOLKSWAGEN GROUP",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Jos?? Mar??a GALOFR??",
              "last_name" => "GALOFR??",
              "description" => "Presidente, VOLVO CAR ESPA??A",
              "speaker" => false,
              "online" => false
            ]
        ];
    }
}

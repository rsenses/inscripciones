<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class IIIForoController extends Controller
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
        $url = 'https://api.jsonbin.io/b/628dd569402a5b38020c8fdf';
        $response = Http::get($url);
        $json = json_decode($response->body(), true);

        if ($json['stream'] == 1) {
            if ($lang === 'en') {
                return [
                    'streaming' => '<div style="width: 100%;"><div style="position: relative; padding-bottom: 56.25%;"><iframe style="position: absolute; width: 100%; height: 100%;" src="https://ikuna.s3.amazonaws.com/sync01/event_660_ccf98b/streaming.html" frameborder="0" allowtransparency="true" allowfullscreen></iframe></div></div>'
                ];
            } else {
                return [
                    'streaming' => '<div style="width: 100%;"><div style="position: relative; padding-bottom: 56.25%;"><iframe style="position: absolute; width: 100%; height: 100%;" src="https://ikuna.s3.amazonaws.com/sync01/event_659_20286a/streaming.html" frameborder="0" allowtransparency="true" allowfullscreen></iframe></div></div>'
                ];
            }
        } elseif ($json['stream'] == 2) {
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
              "description" => "Presidente, ASOCIACIÓN DE LA ENSEÑANZA BILINGÜE",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Natalia DÍAZ LARRAURA",
              "last_name" => "DÍAZ LARRAURA",
              "description" => "Comunicación, ASTRAZENECA",
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
              "name" => "María ARANGUEREN",
              "last_name" => "ARANGUEREN",
              "description" => "2º Teniente de Alcalde, AYUNTAMIENTO DE ALCALÁ DE HENARES",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Alberto BLAZQUEZ",
              "last_name" => "BLAZQUEZ",
              "description" => "1er Teniente de Alcalde, AYUNTAMIENTO DE ALCALÁ DE HENARES",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Diana DÍAZ",
              "last_name" => "DÍAZ",
              "description" => "3er Teniente de Alcalde, AYUNTAMIENTO DE ALCALÁ DE HENARES",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Ricardo GONZÁLEZ-PARRA",
              "last_name" => "GONZÁLEZ-PARRA",
              "description" => "Portavoz Grupo Municipal Ciudadanos, AYUNTAMIENTO DE ALCALÁ DE HENARES",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Teresa LÓPER HERVAS",
              "last_name" => "LÓPER HERVAS",
              "description" => "Portavoz Grupo municipal Unidas Podemos, AYUNTAMIENTO DE ALCALÁ DE HENARES",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Javier MORENO",
              "last_name" => "MORENO",
              "description" => "Portavoz Grupo Municipal VOX, AYUNTAMIENTO DE ALCALÁ DE HENARES",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Judith PIQUET FLORES",
              "last_name" => "PIQUET FLORES",
              "description" => "Portavoz Grupo Municipal PP, AYUNTAMIENTO DE ALCALÁ DE HENARES",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Víctor MARQUEZ",
              "last_name" => "MARQUEZ",
              "description" => "Director de Comunicación, BANCO DE ESPAÑA",
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
              "name" => "Mónica AUSEJO SEGURA",
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
              "name" => "Enrique RODRÍGUEZ",
              "last_name" => "RODRÍGUEZ",
              "description" => "Director de Comunicación, CEPSA",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Juan LLOBELL",
              "last_name" => "LLOBELL",
              "description" => "Director de Comunicación y Relaciones Institucionales, CEPSA",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Ignacio RODRÍGEZ-SOLANO",
              "last_name" => "RODRÍGEZ-SOLANO",
              "description" => "Responsable de Relaciones Institucionales, CEPSA",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Manuel PÉREZ-SALA",
              "last_name" => "PÉREZ-SALA",
              "description" => "Presidente, CÍRCULO DE EMPRESARIOS",
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
              "description" => "Socia directora de Assurance, EY ESPAÑA",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Ramón PALACÍN",
              "last_name" => "PALACÍN",
              "description" => "socio director, EY ESPAÑA",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Goyo PANADERO",
              "last_name" => "PANADERO",
              "description" => "Director de Comunicación en España, EY ESPAÑA",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Ignacio REL PLA",
              "last_name" => "REL PLA",
              "description" => "Socio director de Consulting, EY ESPAÑA",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Juan PABLO RIESGO",
              "last_name" => "RIESGO",
              "description" => "Socio responsable, EY ESPAÑA",
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
              "description" => "Directora de Comunicación, FUNDACIÓN FAES",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Rocío MARTÍNEZ-SEMPERE",
              "last_name" => "MARTÍNEZ-SEMPERE",
              "description" => "Directora, FUNDACIÓN FELIPE GONZÁLEZ",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Miguel Ángel OLIVER",
              "last_name" => "OLIVER",
              "description" => "Secretario de Estado de Comunicación, GOBIERNO DE ESPAÑA",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Begoña DE LA SOTA",
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
              "name" => "José GARCÍA",
              "last_name" => "GARCÍA",
              "description" => "Socio de la agencia de comunicación Grupo Albión, asesor de comunicación, GRUPO ALBIOL",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Raquel GARCÍA",
              "last_name" => "GARCÍA",
              "description" => "Directora General, GRUPO LAUDER",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Leopoldo SATRUSTEGUI",
              "last_name" => "SATRUSTEGUI",
              "description" => "DIRECTOR GENERAL, HYUNDAI ESPAÑA",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Félix SANZ ROLDÁN",
              "last_name" => "SANZ ROLDÁN",
              "description" => "Ex director del CNI, IBERDROLA",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Juan CIERCO",
              "last_name" => "CIERCO",
              "description" => "Director de Comunicación, IBERIA",
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
              "name" => "Rocío Márquez PAPELL",
              "last_name" => "MÁRQUEZ PAPELL",
              "description" => "Directora de Comunicación Josep Piqué",
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
              "description" => "Directora General, L'OREAL DIVISIÓN PRODUCTOS DE LUJO",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Juan Alonso DE LOMAS",
              "last_name" => "DE LOMAS",
              "description" => "Presidente y Consejero delegado, L'OREAL ESPAÑA",
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
              "name" => "José Manuel INCHAUSTI",
              "last_name" => "INCHAUSTI",
              "description" => "Vicepresidente y CEO, MAPFRE ESPAÑA",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Toni MARTÍNEZ",
              "last_name" => "MARTÍNEZ",
              "description" => "Director de Comunicación, MERCADONA",
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
              "name" => "Eduardo CÓRDOBA",
              "last_name" => "CÓRDOBA",
              "description" => "Comunicación, MINISTERIO DE ASUNTOS EXTERIORES Y COOPERACIÓN",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Vicente MONTÁVEZ",
              "last_name" => "MONTÁVEZ",
              "description" => "Asesor, MINISTERIO DE ASUNTOS EXTERIORES Y COOPERACIÓN",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Jordi García TABERNERO",
              "last_name" => "GARCÍA TABERNERO",
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
              "description" => "Director, PARADOR DE ALCALÁ DE HENARES",
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
              "name" => "Joan JORDI VALLVERDÚ",
              "last_name" => "JORDI VALLVERDÚ",
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
              "name" => "António SIMÕES",
              "last_name" => "SIMÕES",
              "description" => "CEO Santander España y Europa, SANTANDER ESPAÑA",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Amalia NAVARRO",
              "last_name" => "NAVARRO",
              "description" => "Directora de Comunicación, Secretaría General Iberoamericana (SEGIB)",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Andrés Miguel RONDÓN",
              "last_name" => "RONDÓN",
              "description" => "Asesor de Gabinete, Secretaría General Iberoamericana (SEGIB)",
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
              "description" => "Director de Comunicación, TENDAM",
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
              "name" => "Jesús ESCUDERO GONZÁLEZ",
              "last_name" => "ESCUDERO GONZÁLEZ",
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
              "description" => "Directora de Segmento Sector Público Norte, UNICAJA",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Mayte ALONSO AYUSO",
              "last_name" => "ALONSO AYUSO",
              "description" => "EXPANSIÓN, UNIDAD EDITORIAL",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Rebeca ARROYO",
              "last_name" => "ARROYO",
              "description" => "EXPANSIÓN, UNIDAD EDITORIAL",
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
              "description" => "Subdirector de Expansión, UNIDAD EDITORIAL",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Roberto CASADO",
              "last_name" => "CASADO",
              "description" => "EXPANSIÓN, UNIDAD EDITORIAL",
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
              "name" => "Raúl CASTILLO HERRERO",
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
              "description" => "Director Adjunto de Expansión, UNIDAD EDITORIAL",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Valentín FERNÁNDEZ",
              "last_name" => "FERNÁNDEZ",
              "description" => "Redactor Jefe Expansión, UNIDAD EDITORIAL",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Aurelio FERNÁNDEZ LOZANO",
              "last_name" => "FERNÁNDEZ LOZANO",
              "description" => "Director General de Publicaciones, UNIDAD EDITORIAL",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Luis FONTÁN",
              "last_name" => "FONTÁN",
              "description" => "Director de Negocio de Expansión, UNIDAD EDITORIAL",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Ignacio GARAY",
              "last_name" => "GARAY",
              "description" => "Director Adjunto de Expansión, UNIDAD EDITORIAL",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Juan José GARRIDO DE LA CIERVA",
              "last_name" => "GARRIDO DE LA CIERVA",
              "description" => "Redactor Jefe Expansión, UNIDAD EDITORIAL",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Miguel GONZÁLEZ CORRAL",
              "last_name" => "GONZÁLEZ CORRAL",
              "description" => "Director del Área de Salud, UNIDAD EDITORIAL",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Joaquín MANSO",
              "last_name" => "MANSO",
              "description" => "Director Adjunto de El Mundo, UNIDAD EDITORIAL",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Javier MONTALVO",
              "last_name" => "MONTALVO",
              "description" => "Redactor Jefe Expansión, UNIDAD EDITORIAL",
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
              "name" => "Miguel Ángel PATIÑO",
              "last_name" => "PATIÑO",
              "description" => "Redactor Jefe de Expansión, UNIDAD EDITORIAL",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Amparo POLO",
              "last_name" => "POLO",
              "description" => "EXPANSIÓN, UNIDAD EDITORIAL",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Silvia ROMÁN",
              "last_name" => "ROMÁN",
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
              "description" => "Redactora Jefe de Expansión, UNIDAD EDITORIAL",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Martí SABALLS",
              "last_name" => "SABALLS",
              "description" => "Director Adjunto de El Mundo, UNIDAD EDITORIAL",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Arancha SÁNCHEZ FERNÁNDEZ",
              "last_name" => "SÁNCHEZ FERNÁNDEZ",
              "description" => "Directora de Publicidad, UNIDAD EDITORIAL",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "José Luis SÁNCHEZ-CRESPO",
              "last_name" => "SÁNCHEZ-CRESPO",
              "description" => "Director de Publicidad, UNIDAD EDITORIAL",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Estela SANTOS",
              "last_name" => "SANTOS",
              "description" => "Redactora Jefe de Expansión, UNIDAD EDITORIAL",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Chary SERRANO",
              "last_name" => "SERRANO",
              "description" => "Directora de Negocio Área Salud, UNIDAD EDITORIAL",
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
              "name" => "Miguel SUÁREZ",
              "last_name" => "SUÁREZ",
              "description" => "Director de Publicidad, UNIDAD EDITORIAL",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Emelia VIAÑA",
              "last_name" => "VIAÑA",
              "description" => "Redactora Jefe de Expansión, UNIDAD EDITORIAL",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Jesús ZABALLA",
              "last_name" => "ZABALLA",
              "description" => "Director General de Publicidad, UNIDAD EDITORIAL",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Artur ZANON",
              "last_name" => "ZANON",
              "description" => "EXPANSIÓN, UNIDAD EDITORIAL",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Antonio GARCÍA TABUENCA",
              "last_name" => "GARCÍA TABUENCA",
              "description" => "Decano de la facultad de Economicas, Empresariales y Turismo, UNIVERSIDAD DE ALCALÁ DE HENARES",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Jose GONZALO ANGULO",
              "last_name" => "GONZALO ANGULO",
              "description" => "Director del Dpto de Economía y Dirección de Empresas, UNIVERSIDAD DE ALCALÁ DE HENARES",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Tomás MANCHA",
              "last_name" => "MANCHA",
              "description" => "Catedratico de Economía Aplicada, UNIVERSIDAD DE ALCALÁ DE HENARES",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Carlos MARIO GÓMEZ",
              "last_name" => "MARIO GÓMEZ",
              "description" => "Director del Dpto de Economía, UNIVERSIDAD DE ALCALÁ DE HENARES",
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
              "name" => "Francisco José PÉREZ BOTELLO",
              "last_name" => "PÉREZ BOTELLO",
              "description" => "PRESIDENTE, VOLKSWAGEN GROUP",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "José María GALOFRÉ",
              "last_name" => "GALOFRÉ",
              "description" => "Presidente, VOLVO CAR ESPAÑA",
              "speaker" => false,
              "online" => false
            ]
        ];
    }
}

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
                    'streaming' => '<div style="position: relative; padding-bottom: 56.25%; height: 0;"><iframe src="https://c.themediacdn.com/embed/media/WSsdbK/IKE44b4smLf/imdCcrsYn2I_5" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;" frameborder="0" scrolling="no" webkitallowfullscreen mozallowfullscreen allowfullscreen allow="autoplay; fullscreen;"></iframe></div>'
                ];
            } else {
                return [
                    'streaming' => '<div style="position: relative; padding-bottom: 56.25%; height: 0;"><iframe src="https://c.themediacdn.com/embed/media/WSsdbK/IKE44b4smLf/imdCwbsYn2E_5" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;" frameborder="0" scrolling="no" webkitallowfullscreen mozallowfullscreen allowfullscreen allow="autoplay; fullscreen;"></iframe></div>'
                ];
            }
        } elseif ($json['stream'] === 'stream-2-1') {
            // Cuando tentamos el streaming, hacer wrap con
            //     <div class="embed-responsive embed-responsive-16by9">
            if ($lang === 'en') {
                return [
                    'streaming' => '<div style="position: relative; padding-bottom: 56.25%; height: 0;"><iframe src="https://c.themediacdn.com/embed/media/WSsdbK/IKE44b4smLf/imdeOSsYn2C_5" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;" frameborder="0" scrolling="no" webkitallowfullscreen mozallowfullscreen allowfullscreen allow="autoplay; fullscreen;"></iframe></div>'
                ];
            } else {
                return [
                    'streaming' => '<div style="position: relative; padding-bottom: 56.25%; height: 0;"><iframe src="https://c.themediacdn.com/embed/media/WSsdbK/IKE44b4smLf/imdehosYn2N_5" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;" frameborder="0" scrolling="no" webkitallowfullscreen mozallowfullscreen allowfullscreen allow="autoplay; fullscreen;"></iframe></div>'
                ];
            }
        } else {
            if ($lang === 'en') {
                return [
                    'streaming' => '<div style="position: relative; padding-bottom: 56.25%; height: 0;"><iframe src="https://c.themediacdn.com/embed/media/WSsdbK/IKE44b4smLf/imdvlKsYn2t_5" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;" frameborder="0" scrolling="no" webkitallowfullscreen mozallowfullscreen allowfullscreen allow="autoplay; fullscreen;"></iframe></div>'
                ];
            } else {
                return [
                    'streaming' => '<div style="position: relative; padding-bottom: 56.25%; height: 0;"><iframe src="https://c.themediacdn.com/embed/media/WSsdbK/IKE44b4smLf/imdS3SsYn2X_5" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;" frameborder="0" scrolling="no" webkitallowfullscreen mozallowfullscreen allowfullscreen allow="autoplay; fullscreen;"></iframe></div>'
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
              "name" => "Xavier",
              "last_name" => "Gisbert da Cruz",
              "description" => "Presidente, Asociación de la Enseñanza Bilingüe",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Natalia",
              "last_name" => "Díaz Larraura",
              "description" => "Comunicación, ASTRAZENECA",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Marta",
              "last_name" => "Moreno",
              "description" => "Directora de Asuntos Corporativos y Acceso al Mercado, ASTRAZENECA",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "María",
              "last_name" => "Arangueren",
              "description" => "2º Teniente de Alcalde, AYUNTAMIENTO DE ALCALÁ DE HENARES",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Alberto",
              "last_name" => "Blazquez",
              "description" => "1er Teniente de Alcalde, AYUNTAMIENTO DE ALCALÁ DE HENARES",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Diana",
              "last_name" => "Díaz",
              "description" => "3er Teniente de Alcalde, AYUNTAMIENTO DE ALCALÁ DE HENARES",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Ricardo",
              "last_name" => "González-Parra",
              "description" => "Portavoz Grupo Municipal Ciudadanos, AYUNTAMIENTO DE ALCALÁ DE HENARES",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Teresa",
              "last_name" => "Lóper Hervas",
              "description" => "Portavoz Grupo municipal Unidas Podemos, AYUNTAMIENTO DE ALCALÁ DE HENARES",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Javier",
              "last_name" => "Moreno",
              "description" => "Portavoz Grupo Municipal VOX, AYUNTAMIENTO DE ALCALÁ DE HENARES",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Judith",
              "last_name" => "Piquet Flores",
              "description" => "Portavoz Grupo Municipal PP, AYUNTAMIENTO DE ALCALÁ DE HENARES",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Víctor",
              "last_name" => "Marquez",
              "description" => "Director de Comunicación, BANCO DE ESPAÑA",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Carina",
              "last_name" => "Mickeviciute",
              "description" => "Corporate Communications Iberia, BLACKROCK",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Mónica",
              "last_name" => "Ausejo Segura",
              "description" => "Directora Market Access Spain& Portugal, Bristol Myers Squibb",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Miguel",
              "last_name" => "Garrido de la Cierva",
              "description" => "Presidente, CEIM",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Enrique",
              "last_name" => "Roríguez",
              "description" => "Director de Comunicación, CEPSA",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Juan",
              "last_name" => "Llobell",
              "description" => "Director de Comunicación y Relaciones Institucionales, CEPSA",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Ignacio",
              "last_name" => "Rodrígez-Solano",
              "description" => "Responsable de Relaciones Institucionales, CEPSA",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Manuel",
              "last_name" => "Pérez-Sala",
              "description" => "Presidente, Círculo de Empresarios",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Isabel",
              "last_name" => "Díaz Ayuso",
              "description" => "Presidenta, COMUNIDAD DE MADRID",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Maru",
              "last_name" => "Merino",
              "description" => "Jefe de Protocolo de la Consejera de Presidencia, COMUNIDAD DE MADRID",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Joaquin",
              "last_name" => "Gordon",
              "description" => "Director General, ELIZABETH ARDEN",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Hildur Eir",
              "last_name" => "Jonsdottir",
              "description" => "Socia directora de Assurance, EY España",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Ramón",
              "last_name" => "Palacín",
              "description" => "socio director, EY España",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Goyo",
              "last_name" => "Panadero",
              "description" => "Director de Comunicación en España, EY España",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Ignacio",
              "last_name" => "Rel Pla",
              "description" => "Socio director de Consulting, EY España",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Juan Pablo",
              "last_name" => "Riesgo",
              "description" => "Socio responsable, EY España",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Rafael",
              "last_name" => "del Pino y Calvo-Sotelo",
              "description" => "PRESIDENTE, FERROVIAL",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Ana",
              "last_name" => "Cabos",
              "description" => "Directora de Comunicación, FUNDACIÓN FAES",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Rocío",
              "last_name" => "Martínez-Sempere",
              "description" => "Directora, FUNDACIÓN FELIPE GONZÁLEZ",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Miguel Ángel",
              "last_name" => "Oliver",
              "description" => "Secretario de Estado de Comunicación, GOBIERNO DE ESPAÑA",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Begoña",
              "last_name" => "De la Sota",
              "description" => "CEO, GROUP M",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Beatriz",
              "last_name" => "Delgado",
              "description" => "CEO, GROUP M",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "José",
              "last_name" => "García",
              "description" => "Socio de la agencia de comunicación Grupo Albión, asesor de comunicación, GRUPO ALBIOL (Com. Tendam)",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Raquel",
              "last_name" => "García",
              "description" => "Directora General, GRUPO LAUDER",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Helena",
              "last_name" => "Herrero",
              "description" => "Presidenta de HP para el mercado del sur de Europa, HP",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Leopoldo",
              "last_name" => "Satrustegui",
              "description" => "DIRECTOR GENERAL, HYUNDAI ESPAÑA",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Félix",
              "last_name" => "Sanz Roldán",
              "description" => "Ex director del CNI, IBERDROLA",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Juan",
              "last_name" => "Cierco",
              "description" => "Director de Comunicación, IBERIA",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Herminio",
              "last_name" => "Granero",
              "description" => "Executive Director, Ingram Micro Spain",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Rocío",
              "last_name" => "Márquez Papell",
              "description" => "Directora de Comunicación Josep Piqué, JOSEP PIQUÉ",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Dimas",
              "last_name" => "Gimeno",
              "description" => "Presidente, Kapita / WOW",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Ana",
              "last_name" => "Jaureguizar",
              "description" => "Directora General, L'OREAL DIVISIÓN PRODUCTOS DE LUJO",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Juan Alonso",
              "last_name" => "De Lomas",
              "description" => "Presidente y Consejero delegado, L'OREAL ESPAÑA",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Juan Pedro",
              "last_name" => "Abeniacar",
              "description" => "CEO, LVMH",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Ignacio",
              "last_name" => "Baeza",
              "description" => "Vicepresidente, MAPFRE",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "José Manuel",
              "last_name" => "Inchausti",
              "description" => "Vicepresidente y CEO, MAPFRE España",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Toni",
              "last_name" => "Martínez",
              "description" => "Director de Comunicación, MERCADONA",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Miguel",
              "last_name" => "Primo de Rivera",
              "description" => "Conductor del acto, MICHI PRIMO DE RIVERA",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Nadia",
              "last_name" => "Calviño",
              "description" => "Vicepresidenta segunda del Gobierno, ministra de Asuntos Económicos y Transformación Digital, MINISTERIO DE ASUNTOS ECONÓMICOS Y \"TRANFORMACIÓN DIGITAL",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Eduardo",
              "last_name" => "Córdoba",
              "description" => "Comunicación, MINISTERIO DE ASUNTOS EXTERIORES Y COOPERACIÓN",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Arancha",
              "last_name" => "González Laya",
              "description" => "Ministra, MINISTERIO DE ASUNTOS EXTERIORES Y COOPERACIÓN",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Vicente",
              "last_name" => "Montávez",
              "description" => "Asesor, MINISTERIO DE ASUNTOS EXTERIORES Y COOPERACIÓN",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Teresa",
              "last_name" => "Ribera",
              "description" => "Vicepresidenta cuarta del Gobierno, ministra para la Transcición Ecológica y Reto Demográfico, MINISTERIO DE TRANSCICIÓN ECOLÓGICA Y RETO \"DEMOGRÁFICO",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Jordi",
              "last_name" => "García Tabernero",
              "description" => "DG Sostenibilidad, Marca y RRII, NATURGY",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Patricia",
              "last_name" => "Benito  de Mateo",
              "description" => "Directora General, OPEN BANK( TENDAM)",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Pedro",
              "last_name" => "Soria",
              "description" => "Director, PARADOR DE ALCALÁ DE HENARES",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Pablo",
              "last_name" => "Casado",
              "description" => "Presidente, PARTIDO POPULAR",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Joan",
              "last_name" => "Jordi Vallverdú",
              "description" => "CEO, Publicis",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Urbano",
              "last_name" => "Cairo",
              "description" => "Presidente, RCS",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "António",
              "last_name" => "Simões",
              "description" => "CEO Santander España y Europa, SANTANDER ESPAÑA",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Amalia",
              "last_name" => "Navarro",
              "description" => "Directora de Comunicación, Secretaría General Iberoamericana (SEGIB)",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Andrés Miguel",
              "last_name" => "Rondón",
              "description" => "Asesor de Gabinete, Secretaría General Iberoamericana (SEGIB)",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Manuel",
              "last_name" => "Serrano",
              "description" => "Director general financiero, TENDAM",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Ignacio",
              "last_name" => "Sierra",
              "description" => "Director de Comunicación, TENDAM",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Marta",
              "last_name" => "Ortiz",
              "description" => "Vicepresidenta, THE EUROPEAN HOUSE-AMBROSETTI",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Maria Adelaide",
              "last_name" => "Piano Mortari",
              "description" => "Associate Partner, THE EUROPEAN HOUSE-AMBROSETTI",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Jesús",
              "last_name" => "Escudero González",
              "description" => "Director de Banca Corporativa, UNICAJA",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "David",
              "last_name" => "Iglesias Rico",
              "description" => "Director de Segmento Empresas de Madrid, UNICAJA",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Francisco Javier",
              "last_name" => "Molinuevo",
              "description" => "Coordinador de Banca Corporativa, UNICAJA",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Isabel",
              "last_name" => "Vilaplana Sempere",
              "description" => "Directora de Segmento Sector Público Norte, UNICAJA",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Mayte",
              "last_name" => "Alonso Ayuso",
              "description" => "EXPANSIÓN, UNIDAD EDITORIAL",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Rebeca",
              "last_name" => "Arroyo",
              "description" => "EXPANSIÓN, UNIDAD EDITORIAL",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Stefania",
              "last_name" => "Bedogni",
              "description" => "Directora General y Consejera, UNIDAD EDITORIAL",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Pedro",
              "last_name" => "Biurrun",
              "description" => "Subdirector de Expansión, UNIDAD EDITORIAL",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Roberto",
              "last_name" => "Casado",
              "description" => "EXPANSIÓN, UNIDAD EDITORIAL",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Gonzalo",
              "last_name" => "Casas",
              "description" => "Director de Publicidad, UNIDAD EDITORIAL",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Raúl",
              "last_name" => "Castillo Herrero",
              "description" => "Director Comercial, UNIDAD EDITORIAL",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Mar",
              "last_name" => "De Vicente",
              "description" => "Directora de Publicidad, UNIDAD EDITORIAL",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Manuel",
              "last_name" => "Del Pozo",
              "description" => "Director Adjunto de Expansión, UNIDAD EDITORIAL",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Valentín",
              "last_name" => "Fernández",
              "description" => "Redactor Jefe Expansión, UNIDAD EDITORIAL",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Aurelio",
              "last_name" => "Fernández Lozano",
              "description" => "Director General de Publicaciones, UNIDAD EDITORIAL",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Luis",
              "last_name" => "Fontán",
              "description" => "Director de Negocio de Expansión, UNIDAD EDITORIAL",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Ignacio",
              "last_name" => "Garay",
              "description" => "Director Adjunto de Expansión, UNIDAD EDITORIAL",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Juan José",
              "last_name" => "Garrido de la Cierva",
              "description" => "Redactor Jefe Expansión, UNIDAD EDITORIAL",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Miguel",
              "last_name" => "González Corral",
              "description" => "Director del Área de Salud, UNIDAD EDITORIAL",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Joaquín",
              "last_name" => "Manso",
              "description" => "Director Adjunto de El Mundo, UNIDAD EDITORIAL",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Javier",
              "last_name" => "Montalvo",
              "description" => "Redactor Jefe Expansión, UNIDAD EDITORIAL",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Tacho",
              "last_name" => "Orero",
              "description" => "Director de Publicidad, UNIDAD EDITORIAL",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Miguel Ángel",
              "last_name" => "Patiño",
              "description" => "Redactor Jefe de Expansión, UNIDAD EDITORIAL",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Ana I.",
              "last_name" => "Pereda",
              "description" => "Directora de Expansión, UNIDAD EDITORIAL",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Amparo",
              "last_name" => "Polo",
              "description" => "EXPANSIÓN, UNIDAD EDITORIAL",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Marco",
              "last_name" => "Pompignoli",
              "description" => "Presidente, UNIDAD EDITORIAL",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Silvia",
              "last_name" => "Román",
              "description" => "Redactora Jefe de Internacional de El Mundo, UNIDAD EDITORIAL",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Francisco",
              "last_name" => "Rosell",
              "description" => "Director de El Mundo, UNIDAD EDITORIAL",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Clara",
              "last_name" => "Ruiz de Gauna",
              "description" => "Redactora Jefe de Expansión, UNIDAD EDITORIAL",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Martí",
              "last_name" => "Saballs",
              "description" => "Director Adjunto de El Mundo, UNIDAD EDITORIAL",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Arancha",
              "last_name" => "Sánchez Fernández",
              "description" => "Directora de Publicidad, UNIDAD EDITORIAL",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "José Luis",
              "last_name" => "Sánchez-Crespo",
              "description" => "Director de Publicidad, UNIDAD EDITORIAL",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Estela",
              "last_name" => "Santos",
              "description" => "Redactora Jefe de Expansión, UNIDAD EDITORIAL",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Chary",
              "last_name" => "Serrano",
              "description" => "Directora de Negocio Área Salud, UNIDAD EDITORIAL",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Nicola",
              "last_name" => "Speroni",
              "description" => "Director General y Consejero, UNIDAD EDITORIAL",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Miguel",
              "last_name" => "Suárez",
              "description" => "Director de Publicidad, UNIDAD EDITORIAL",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Emelia",
              "last_name" => "Viaña",
              "description" => "Redactora Jefe de Expansión, UNIDAD EDITORIAL",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Jesús",
              "last_name" => "Zaballa",
              "description" => "Director General de Publicidad, UNIDAD EDITORIAL",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Artur",
              "last_name" => "Zanon",
              "description" => "EXPANSIÓN, UNIDAD EDITORIAL",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Antonio",
              "last_name" => "García Tabuenca",
              "description" => "Decano de la facultad de Economicas, Empresariales y Turismo, UNIVERSIDAD DE ALCALÁ DE HENARES",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Jose",
              "last_name" => "Gonzalo Angulo",
              "description" => "Director del Dpto de Economía y Dirección de Empresas, UNIVERSIDAD DE ALCALÁ DE HENARES",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "",
              "last_name" => "Mancha",
              "description" => "Catedratico de Economía Aplicada, UNIVERSIDAD DE ALCALÁ DE HENARES",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Carlos",
              "last_name" => "Mario Gómez",
              "description" => "Director del Dpto de Economía, UNIVERSIDAD DE ALCALÁ DE HENARES",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Carmen",
              "last_name" => "Alvear",
              "description" => "Directora de RRII, Vodafone",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Colman",
              "last_name" => "Deegan",
              "description" => "CEO, Vodafone",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "Francisco José",
              "last_name" => "Pérez Botello",
              "description" => "PRESIDENTE, VOLKSWAGEN GROUP",
              "speaker" => false,
              "online" => false
            ],
            [
              "name" => "José María",
              "last_name" => "Galofré",
              "description" => "Presidente, VOLVO CAR ESPAÑA",
              "speaker" => false,
              "online" => false
            ]
        ];
    }
}

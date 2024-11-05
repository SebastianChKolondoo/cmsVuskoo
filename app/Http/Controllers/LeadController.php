<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\UtilsController;
use App\Mail\ConfirmacionNewsletter;
use App\Models\Contactenos;
use App\Models\NewsLetter;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\DB;


class LeadController extends Controller
{
    private $utilsController;
    private $visitorIp;

    public function __construct(UtilsController $utilsController)
    {
        $this->utilsController = $utilsController;
        $this->visitorIp = $this->utilsController->obtencionIpRealVisitante();
    }

    function decideCountry(): string
    {
        $return = "es";
        if (isset($GLOBALS["country_instance"])) {
            $return = $GLOBALS["country_instance"];
        } else {
            //registroDeErrores(3, "Funcion decideCountry()", "No está definida la variable Global de País «GLOBALS['country_instance']». Se establece *es* por defecto");
        }
        return $return;
    }

    function leadRecordEnergy(Request $request): ?string
    {
        $data_lead = $request->dataToSend;
        $lead_id = null;
        $IP_data = $this->visitorIp;
        $visitorIp = !empty($IP_data) ? $IP_data->ip : "Sin datos desde IPAPI";
        $user_id = null;
        $country_code = null;
        $decideCountry = $this->decideCountry();

        DB::beginTransaction();
        try {
            $registro_nuevo = false;
            $es_movil = true;
            $tel_usuario = str_replace(" ", "", $data_lead['tel_usuario']);
            if (in_array(Str::substr($data_lead['tel_usuario'], 0, 1), array(8, 9), true)) {
                $es_movil = false;
                $registro_nuevo = true;
            } elseif (!DB::table('usuarios')->where('tlf_movil', $tel_usuario)->exists()) {
                $registro_nuevo = true;
            }

            if ($registro_nuevo) {
                $user = array();
                if ($es_movil) {
                    $user['tlf_movil'] = $tel_usuario;
                } else {
                    $user['tlf_fijo'] = $tel_usuario;
                }
                $user['nombre'] = (empty($data_lead['nombre_usuario']) || ($data_lead['nombre_usuario'] === "n/d")) ? null : $data_lead['nombre_usuario'];
                $user['email'] = (empty($data_lead['email'])) ? null : $data_lead['email'];
                $user['direccion'] = empty($data_lead['direccion_usuario']) ? null : $data_lead['direccion_usuario'];
                $user['poblacion'] = empty($data_lead['poblacion_usuario']) ? null : $data_lead['poblacion_usuario'];
                $user['provincia'] = empty($data_lead['provincia_usuario']) ? null : $data_lead['provincia_usuario'];
                $user['codigo_postal'] = empty($data_lead['cp_usuario']) ? null : $data_lead['cp_usuario'];
                if (intval($data_lead['acepta_comunicaciones_comerciales']) === 1) {
                    $user['acepta_comunicaciones_comerciales'] = true;
                    $user['fecha_aceptacion_comunicaciones_comerciales'] = Carbon::now()->format("Y-m-d H:i:s");
                }

                if (!empty($IP_data)) {
                    $country_code = !empty($IP_data->country_code) ? $IP_data->country_code : null;
                    $user['ip'] = !empty($IP_data->ip) ? $IP_data->ip : null;
                    $user['ip_type'] = !empty($IP_data->type) ? $IP_data->type : null;
                    $user['ip_nombre_continente'] = !empty($IP_data->continent_name) ? $IP_data->continent_name : null;
                    $user['ip_codigo_pais'] = !empty($IP_data->country_code) ? $IP_data->country_code : null;
                    $user['ip_nombre_pais'] = !empty($IP_data->country_name) ? $IP_data->country_name : null;
                    $user['ip_region'] = !empty($IP_data->region_name) ? $IP_data->region_name : null;
                    $user['ip_ciudad'] = !empty($IP_data->city) ? $IP_data->city : null;
                    $user['ip_codigo_postal'] = !empty($IP_data->zip) ? $IP_data->zip : null;
                    $user['ip_latitud'] = !empty($IP_data->longitude) ? $IP_data->longitude : null;
                    $user['ip_longitud'] = !empty($IP_data->latitude) ? $IP_data->latitude : null;
                }

                $user_id = DB::table('usuarios')->insertGetId($user);
            } else {
                $user_id = DB::table('usuarios')->where('tlf_movil', $tel_usuario)->orderby('fecha_registro', 'DESC')->pluck('id')->first();
                if (intval($data_lead['acepta_comunicaciones_comerciales']) === 1) {
                    DB::table('usuarios')->where('id', $user_id)->update([
                        'acepta_comunicaciones_comerciales' => true,
                        'fecha_aceptacion_comunicaciones_comerciales' => Carbon::now()->format("Y-m-d H:i:s")
                    ]);
                }
            }

            //Inserción del lead
            $lead = array();
            $lead['usuario_id'] = $user_id;
            $lead['producto'] = $data_lead['producto'];
            $lead['tipo_conversion'] = $data_lead['tipo_conversion'];
            $lead['tarifa'] = $data_lead['tarifa'];
            $lead['compania'] = $data_lead['compania'];
            $lead['tipo_formulario'] = $data_lead['tipo_formulario'];
            $lead['precio'] = empty($data_lead['precio']) ? null : $data_lead['precio'];
            $lead['preferencia_de_consumo'] = empty($data_lead['consumo']) ? null : $data_lead['consumo'];
            $lead['preferencia_de_pago_luz'] = empty($data_lead['pagar_luz']) ? null : $data_lead['pagar_luz'];
            $lead['energia_verde'] = null;
            if (isset($data_lead['luz_verde'])) {
                $lead['energia_verde'] = $data_lead['luz_verde'];
            }
            $lead['maximo_ahorro'] = null;
            if (isset($data_lead['maximo_ahorro'])) {
                $lead['maximo_ahorro'] = $data_lead['maximo_ahorro'];
            }
            $lead['tengo_gas'] = null;
            if (isset($data_lead['tengo_gas'])) {
                $lead['tengo_gas'] = $data_lead['tengo_gas'];
            }
            $lead['tengo_luz'] = null;
            if (isset($data_lead['tengo_luz'])) {
                $lead['tengo_luz'] = $data_lead['tengo_luz'];
            }
            $lead['dato1'] = empty($data_lead['dato1']) ? null : trim($data_lead['dato1']);
            $lead['dato2'] = empty($data_lead['dato2']) ? null : trim($data_lead['dato2']);
            $lead['dato3'] = empty($data_lead['dato3']) ? null : trim($data_lead['dato3']);
            $lead['dato4'] = empty($data_lead['dato4']) ? null : trim($data_lead['dato4']);
            if ($data_lead['tipo_conversion'] === "cpl") {
                $lead['acepta_cesion_datos_a_proveedor'] = intval($data_lead['acepta_cesion_datos_a_proveedor']) === 1;
            } elseif ($data_lead['tipo_conversion'] === "cpa") {
                $lead['acepta_politica_privacidad_kolondoo'] = intval($data_lead['acepta_politica_privacidad_kolondoo']) === 1;
            } else {
                throw new Exception("ERROR en tipo de conversión en función leadRecordEnergy(), tipo_conversion no es «cpl» ni «cpa» revisar tabla operadoras (" . $data_lead['compania'] . ")");
            }

            //utm params
            $lead['utm_source'] = empty($request->utm_source) ? null : $request->utm_source;
            $lead['utm_medium'] = empty($request->utm_medium) ? null : $request->utm_medium;
            $lead['utm_campaign'] = empty($request->utm_campaign) ? null : $request->utm_campaign;
            $lead['utm_content'] = empty($request->utm_content) ? null : $request->utm_content;
            $lead['utm_term'] = empty($request->utm_term) ? null : $request->utm_term;

            /*
            Reescribimos la procedencia del registro en caso de que estemos en campañas Emailing de Arkeero
            Deberán venir los valores utm_campaign=ark, utm_medium=email y utm_source={definición de campaña, por ejemplo naturgy101022} para que se reconozca como campaña de emailing de arkeero.
        */
            if (!empty($request->utm_source) && !empty($request->utm_medium) && !empty($request->utm_campaign) && Str::lower($request->utm_source) === "ark" && Str::lower($request->utm_medium) === "email") {
                $lead['producto'] = "EMAILING_RECORD_" . Str::upper($request->utm_campaign);
            }

            $lead_id = DB::table('energia')->insertGetId($lead);

            DB::commit();
        } catch (\PDOException | \Exception $e) {
            DB::rollback();
            $lead_id = null;
            $message = "Fallo al registrar el «lead» de *" . ($data_lead['compania']) . "* en función leadRecordEnergy(). - Ip: " . $visitorIp . ' - Fallo ocurrido: ' . $e->getMessage() . " - Datos recibidos del «lead» en la función: " . json_encode($data_lead, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            //registroDeErrores(11, 'Lead ERROR', $message, $country_code, $decideCountry);
        }

        return 'energia_' . (empty($lead_id) ? 'not_registered' : $lead_id);
    }

    //Funcion proveniente de zapier Controller
    //solo la usa repsol
    /* public function leadRegister($request)
    {
        $IP_data = $this->visitorIp;
        $country_code = !empty($IP_data->country_code) ? $IP_data->country_code : null;
        $lead = Lead::create([
            'landing' => 'www.vuskoo.com',
            'urlOffer' => 'www.vuskoo.com',
            'company' => $request->dataToSend['company'],
            'idOferta' => '0',
            'phone' => $request->dataToSend['tel_usuario'],
            'idResponse' => '',
            'nombre_usuario' => $request->dataToSend['nombre_usuario'],
            'email' => $request->dataToSend['email'],
            'producto' => $request->dataToSend['producto'],
            'tipo_conversion' => $request->dataToSend['tipo_conversion'],
            'tarifa' => $request->dataToSend['tarifa'],
            'tipo_formulario' => $request->dataToSend['tipo_formulario'],
            'acepta_politica_privacidad' => $request->dataToSend['acepta_politica_privacidad'],
            'acepta_cesion_datos_a_proveedor' => $request->dataToSend['acepta_cesion_datos_a_proveedor'],
            'acepta_comunicaciones_comerciales' => $request->dataToSend['acepta_comunicaciones_comerciales'],

        ]);
        return $lead->id;
    } */

    public function LeadRegisterInfo(Request $request)
    {
        // Validar los datos del formulario si es necesario
        $request->validate([
            'phone' => 'required',
            'landing' => 'required',
            'company' => 'required',
        ]);

        // Crear una nueva instancia del modelo Lead con los datos del formulario
        $lead = new Lead([
            'idOferta' => $request->input('idOferta'),
            'phone' => $request->input('phone'),
            'landing' => $request->input('landing'),
            'urlOffer' => $request->input('urlOffer'),
            'company' => $request->input('company'),
            'ip' => $this->visitorIp,
        ]);

        // Guardar el nuevo registro en la base de datos
        if ($lead->save()) {
            switch ($request->input('landing')) {
                case 'comparador-fibra':
                case 'comparador-tarifas-fibra-y-movil':
                case 'comparador-movil':
                    return $this->leadMovil($lead, $lead->id);
                case 'comparador-tarifas-luz':
                    return $this->leadLuz($lead, $lead->id);
                default:
                    return $this->leadMovil($lead, $lead->id);
            }
        }
    }

    /* public function facebookZapierCpl(Request $request)
    {
        try {
            $GLOBALS["country_instance"] = "es";

            // Formateamos el número de teléfono
            $phone = $this->utilsController->formatTelephone($request->phone);
            if (empty($phone)) {
                // Retorna respuesta en caso de número vacío o inválido
                return response()->json(['status' => "ko"], 200);
            }

            // Validamos y limpiamos los datos del request
            //$email = (!empty($request->email) && is_string($request->email)) ? trim($request->email) : null;
            //$nombre = $request->nombre ?? null;
            $company = $request->company;
            //$producto = $request->producto;
            $idOferta = $request->idOferta;
            $landing = $request->landing;

            // Obtenemos la instancia de la operadora correspondiente
            $instance = DB::table('1_operadoras')
                ->select('nombre', 'funcion_api')
                ->where('id', $company)
                ->where('tipo_conversion', 'cpl')
                ->whereNotNull('funcion_api')
                ->first();

            // Si existe la función API asociada, la construimos
            $instance_zapier = $instance ? $instance->funcion_api : null;

            // Validamos la existencia de la función API y el número de teléfono
            if (!is_null($instance_zapier) && method_exists($this, $instance_zapier) && !empty($phone)) {

                $dataSend = [
                    "phone" => $tlf_movil,
                    "nombre_usuario" => $nombre,
                    "idOferta" => $idOferta,
                    "company" => $company,
                    "urlOffer" => $landing,
                    "landing" => $landing,
                    "tipo_conversion" => "cpl",
                    "tarifa" => 'n/d',
                    "tipo_formulario" => "c2c",
                    'acepta_politica_privacidad' => 1,
                    'acepta_cesion_datos_a_proveedor' => 1,
                    'acepta_comunicaciones_comerciales' => 1
                ];

                $request = new Request();
                $request->replace($dataSend);

                return $response = $this->LeadRegisterInfo($request);

                // Ejecutamos la función específica para la compañía
                //$response = $this->$instance_zapier($request);

                // Decodificamos la respuesta y validamos el estado
                $responseContent = json_decode($response->content());
                if ($responseContent->call_response === "ok") {
                    return response()->json(['status' => "ok"], 200);
                }

                // En caso de respuesta no exitosa
                return response()->json(['status' => "ko", 'message' => $responseContent], 200);
            } else {
                // Registramos el error en caso de compañía o función no válida
                $this->utilsController->registroDeErrores(
                    4,
                    'facebookZapierCpl',
                    "Intento de acceder a función no permitida. ID de compañía: *$company*. Datos: " . json_encode(['tlf_movil' => $tlf_movil, 'email' => $email, 'nombre' => $nombre, 'company' => $company], JSON_UNESCAPED_UNICODE)
                );
                return response()->json(['status' => "kko"], 500);
            }
        } catch (ConnectionException | \PDOException | \Exception $e) {
            // Registramos el error capturado en el catch
            $this->utilsController->registroDeErrores(
                3,
                'facebookZapierCpl',
                "Error en facebookZapierCpl: " . $e->getMessage()
            );
            return response()->json(['status' => "koo"], 500);
        }
    } */

    public function FormContactanosRegister(Request $request)
    {
        // Crear una nueva instancia del modelo formContactenos con los datos del formulario
        $contactenos = new Contactenos([
            'name' => $request->input('nombre'),
            'message' => $request->input('consulta'),
            'email' => $request->input('email'),
            'politica' => true
        ]);

        if ($contactenos->save()) {
            return response()->json([
                'message' => 'Mensaje enviado con exito',
                'status' => 201
            ], 200);
        } else {
            return response()->json([
                'message' => 'En este momento no podemos procesar tu mensaje',
                'status' => 503
            ], 200);
        }
    }

    public function FormNewsletterRegister(Request $request)
    {
        $email = $request->input('email');
        $envio = UtilsController::class;

        $validacion = NewsLetter::where('email', $email)->count();

        if ($validacion !== 0) {
            return response()->json([
                'message' => 'Este email ya se encuentra registrado',
                'status' => 503
            ], 200);
        }

        $token_email = base64_encode($email);

        $contactenos = new NewsLetter([
            'email' => $email,
            'politica' => true,
            'token' => $token_email,
            'verificacion_email' => 2
        ]);

        if ($contactenos->save()) {
            //$envio = UtilsController::EmailNewsletter($email);
            $envio = UtilsController::EmailNewsletter($email, $token_email);
            return response()->json([
                'message' => 'Suscripción realizada con exito',
                'status' => 201,
                'response' => $envio
            ], 200);
        } else {
            return response()->json([
                'message' => 'En este momento no podemos procesar tu suscripción',
                'status' => 503
            ], 200);
        }
    }

    public function leadMovil($lead, $idLead)
    {
        switch ($lead['company']) {
            case 7:    /*pepePhone*/
                return $this->apiPepephone($lead, $idLead);
            case 27:    /*Lowi*/
                return $this->apiLowi($lead, $idLead);
            case 20:    /*Butik*/
                return $this->apiButik($lead, $idLead);
            case 22:    /*Másmóvil*/
                return $this->apiMasMovil($lead, $idLead);
            case 34:    /*Silbo*/
                return $this->apiSilbo($lead, $idLead);
            default:
                $this->utilsController->registroDeErrores(16, 'Lead saved', 'lead save sin operador ajax', $lead['company'], $this->visitorIp);
                return response()->json([
                    'message' => 'ok: Registrado el numero',
                    'status' => 201
                ], 200);
        }
    }

    public function leadLuz($lead, $idLead)
    {
        switch ($lead['company']) {
            case 13:    /*Plenitude*/
                return $this->apiPlenitude($lead, $idLead);
            case 14:    /*Octopus Energy*/
                break;
            case 15:    /*Frank Energy*/
                return $this->apiFrank($lead, $idLead);
                break;
            case 16:    /*Frank Energy*/
                return $this->apiGanaEnergia($lead, $idLead);
                break;
            default:
                break;
        }
    }

    /* public function leadFibraMovil($lead, $idLead)
    {
        switch ($lead['company']) {
            case 27:    /*Lowi
                return $this->apiLowi($lead, $idLead);
                break;
            case 20:    /*Butik
                return $this->apiButik($lead, $idLead);
                break;
            case 22:    /*Másmóvil
                return $this->apiMasMovil($lead, $idLead);
                break;
            default:
                break;
        }
    } */

    /* public function leadFibra($lead, $idLead)
    {
        switch ($lead['company']) {
            case 20:    /*Butik
                return $this->apiButik($lead, $idLead);
                break;
            case 27:    /*Lowi
                return $this->apiLowi($lead, $idLead);
                break;
            case 22:    /*Lowi
                return $this->apiMasMovil($lead, $idLead);
                break;
            default:
                break;
        }
    } */

    // API CPL Lowi
    public function apiLowi($lead, $idLead)
    {
        try {
            $base_api_url = "https://ws.walmeric.com/provision/wsclient/client_addlead.html";

            $obj = array(
                'format' => 'json',
                'idTag' => '29842f94d414949bf95fb2e6109142cfef1fb2a78114c2c536a36bf5a65b953a2724c2690797eda45de829716997a7ab87bee86aa84414bce8ebd6ca62bdbf093b09fbcdb928d3382a661f74609ff5c0e1a002941ebdbc14932342981ac48d58f4d749b0b5308246a6b0f8135759faee',
                'verifyLeadId' => 'NO',
                'idlead' => $idLead,
                'telefono' => $this->utilsController->formatTelephone($lead['phone']),
            );

            $query_string = http_build_query($obj);
            $full_api_url = $base_api_url . '?' . $query_string;

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'charset' => 'utf-8'
            ])->acceptJson()
                ->timeout(20)
                ->get($full_api_url);

            $responseObj = json_decode($response);

            if ($responseObj->result === "OK") {
                $message = "ok: Registrado el numero " . $lead['phone'] . " con id = " . $responseObj->leadId . ", «lead» de *lowi - " . ($lead['company']) . "* en función apiLowi(). - Ip: " . $this->visitorIp . " - Datos recibidos del «lead» en la función: " . json_encode($responseObj);

                $this->utilsController->registroDeErrores(16, 'Lead saved lowi', $message, $lead['urlOffer'], $this->visitorIp);

                $lead = Lead::find($idLead);
                $lead->idResponse = $responseObj->leadId;
                $lead->save();

                return response()->json([
                    'content' => 'ok',
                    'call_response' => 'ok',
                    'message' => $responseObj->leadId,
                    'status' => 201
                ], 201);
            } else {
                $message = "Fallo al registrar el numero " . $lead['phone'] . ", «lead» de *lowi - " . ($lead['company']) . "* en función apiLowi(). - Ip: " . $this->visitorIp . ' - Fallo ocurrido: ' . json_encode($responseObj);
                $this->utilsController->registroDeErrores(11, 'Lead ERROR', $message, $lead['urlOffer'], $this->visitorIp);
                return response()->json([
                    'content' => 'ko',
                    'call_response' => 'ko',
                    'message' => $response_msg ?? 'Error desconocido',
                    'status' => 502
                ], 502);
            }

            return response()->json([
                'message' => isset($responseObj->message) ? $responseObj->message : $responseObj->result,
                'status' => $responseObj->code
            ], 200);
        } catch (\Exception $e) {
            $message = "Fallo de IpAPI ajaxApiV3 falla al enviar el «lead» desde IP: " . $this->visitorIp . ' -> ERROR: ' . $e->getMessage();
            $this->utilsController->registroDeErrores(10, 'ajaxApiLowi', $message);

            return response()->json([
                'message' => 'En estos momentos no pudimos procesar tu solicitud, intenta mas tarde.',
                'status' => 502
            ], 502);
        }
    }

    public function ajaxApiRepsol(Request $request)
    {
        $return = "ko";
        $response = null;
        $visitorIp = $this->visitorIp;
        $lead_id = null;
        $authorization = 'f7295686-5c03-11ec-bf63-0242ac130002';
        $api_url = 'https://connectors.t2omedia.com/repsol/soportes/'; //env('REDES_API_REPSOL_ENERGIA');

        $lead_id = $this->leadRegister($request);
        if (is_numeric($lead_id)) {
            $customer_name = (empty($request->dataToSend['nombre_usuario']) || ($request->dataToSend['nombre_usuario'] === "n/d")) ? null : $request->dataToSend['nombre_usuario'];
            $cp_usuario = (empty($request->dataToSend['cp_usuario']) || ($request->dataToSend['cp_usuario'] === "n/d")) ? null : $request->dataToSend['cp_usuario'];
            $interes = Str::replace("ENERGIA_", "", $request->dataToSend['producto']);
            $lead_id_repsol = intval(Str::replace("energia_", "", $lead_id));
            $fechaHoraLead = Carbon::now()->format('Y-m-d H:i:s');
            $carbonFechaHora = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now()->format('Y-m-d H:i:s'));
            $fechaLead = $carbonFechaHora->format('Y-m-d');
            $horaLead = $carbonFechaHora->format('H:i:s.u');

            if ($interes === "LUZ") {
                $interes = "Luz";
                $landing = "https://kolondoo.com/es/comparador-luz/luz-repsol-5/";
            } elseif ($interes === "GAS") {
                $interes = "Gas";
                $landing = "https://kolondoo.com/es/comparador-gas/gas-repsol-3/";
            } else {
                $interes = "Dual";
                $landing = "https://kolondoo.com/es/comparador-luz-gas/luz-gas-repsol-1/";
            }

            $object = array(
                "telefono" => $this->utilsController->formatTelephone($request->dataToSend['tel_usuario']),
                "idLead" => "AC62_" . $lead_id_repsol,
                "suborigen" => "AC62",
                "canal" => 18,
                "utm_campaign" => "t2o-kolondocmb-all_2203_reyg-dual",
                "utm_medium" => "cmb",
                "utm_content" => "multi_cmb_all_kolondo_comparador_all_all_pros_all_all_all_all",
                "utm_source" => "SF_144_AC62_kolondo",
                "origen" => 144,
                "interes" => $interes,
                "userIP" => $visitorIp,
                "createDate" => $fechaLead,
                "createTime" => $horaLead,
                "createURL" => $landing
            );

            if (!empty($customer_name)) {
                $object['nombre'] = $customer_name;
            }
            if (!empty($cp_usuario)) {
                $object['postalCode'] = $cp_usuario;
            }

            try {
                $response = Http::withHeaders([
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                    'charset' => 'utf-8',
                    'Authorization' => $authorization
                ])->acceptJson()
                    ->timeout(20)
                    ->post($api_url, $object);
            } catch (ConnectionException $e) {
                $message = "Fallo de API ajaxApiRepsol no responde - ERROR: " . $e->getMessage();
                $this->utilsController->registroDeErrores(9, 'ajaxApiRepsol', $message);
            }
        }


        //Control respuesta API
        if (!empty($response) && $response->successful() && !empty($response->body())) {
            $body = json_decode($response->body());
            if ($response->successful()) {
                $return = "ok";
            } else {
                $this->utilsController->registroDeErrores(10, 'ajaxApiRepsol', "Fallo de API ajaxApiRepsol responde KO, se borra «lead» id: *" . $lead_id . "*, respuesta de WS: " . $response->body());
                $return = "ko";
                //Llamamos a BBDD para borrar el lead falso
                if (isset($lead_id_repsol) && is_numeric($lead_id_repsol)) {
                    DB::table('lead')->where('id', $lead_id_repsol)->update([
                        'idResponse' => 'No enviado',
                    ]);
                }
            }
        } else {
            $this->utilsController->registroDeErrores(10, 'ajaxApiRepsol', "Fallo de API ajaxApiRepsol objeto HTTP response vacío o cuerpo de la respuesta no contiene nada.");
        }

        sleep(2);
        return response()->json(array('call_response' => $return, 'lead_id' => $lead_id), 200);
    }

    public function apiMasMovil($lead, $idLead)
    {
        $apiUrl = 'https://api.byside.com/1.0/call/createCall';
        $authHeader = 'Basic Qzk4NTdFNkIxOTpUZU9ZR0l6eUxVdXlOYW8wRm5wZUlWN0ow';

        $requestData = [
            'phone' => '+34' . $this->utilsController->formatTelephone($lead['phone']),
            'schedule_datetime' => 'NOW',
            'branch_id' => '26970',
            'channel' => 'proveedores',
            'lang' => 'es',
            'uuid' => time(),
            'is_uid_authenticated' => false,
            'url' => $lead['urlOffer'],
            'user_ip' => $this->visitorIp,
            'info' => [
                'proveedor_id' => 'Arkeero',
                'mm_external_campaign_900' => '900696940'
            ],
        ];


        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'charset' => 'utf-8',
            'Authorization' => $authHeader,
        ])->post($apiUrl, $requestData);

        $data = $response->json();

        // Verificar si el 'message' existe y asignar variables
        $response_id = $data['message']['id'] ?? null;
        $response_status = $data['message']['status'] ?? null;
        $response_msg = $data['message']['status_msg'] ?? null;

        if ($response_id != null) {
            $message = "ok: Registrado el numero " . $requestData['phone'] . " con id = " . $data['message']['id'] . ", «lead» de *mas movil - " . ($lead['company']) . "* en función apiMasMovil(). - Ip: " . $this->visitorIp . " - Datos recibidos del «lead» en la función: " . json_encode($data);
            $this->utilsController->registroDeErrores(16, 'Lead saved mas movil', $message, $lead['urlOffer'], $this->visitorIp);
            $codigo = 201;

            // Guardar el ID de respuesta en el lead
            $lead = Lead::find($idLead);
            $lead->idResponse = $response_id;
            $lead->save();

            // Retornar respuesta exitosa
            return response()->json([
                'content' => 'ok',
                'call_response' => 'ok',
                'message' => $response_msg ?? $response_id,
                'status' => 201
            ], 201);
        } else {
            if (in_array($response_status, ['-8', '-5', '-4', '-2', '-3'])) {
                $message = $data['message']['status'] . ": Fallo al registrar el numero " . $requestData['phone'] . ", «lead» de *mas movil - " . ($lead['company']) . "* en función apiMasMovil(). - Ip: " . $this->visitorIp . ' - Fallo ocurrido: ' . $data['message']['status_msg'] . " - Datos recibidos del «lead» en la función: " . json_encode($data);
                $this->utilsController->registroDeErrores(11, 'Lead ERROR', $message, $lead['urlOffer'], $this->visitorIp);
                return response()->json([
                    'content' => 'ko',
                    'call_response' => 'ko',
                    'message' => $response_msg ?? 'Error desconocido',
                    'status' => 502
                ], 502);
            }
        }
    }

    public function apiSilbo($lead, $idLead)
    {
        $apiUrl = 'https://ws.grupov3.com/BulkC2C/';
        $authHeader = 'Authorization: Bearer c2lsYm9hZmlsaWFkb3M6eFRheXBZVTg3UmJTaEJrRGNRdW4zSg==';


        $requestData = [
            'LeadId' => time(),
            'name' => '',
            'surname' => '',
            'email' => '',
            'createDate' => date('Y-m-d H:i:s'),
            'telephone' => $this->utilsController->formatTelephone($lead['phone']),
            "url" => "vuskoo.com/es",
            "utm" => "9800000000",
            "leadType" => "CMB",
            "subCampaign" => "affiliate-arkeero",
        ];

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'charset' => 'utf-8',
            'Authorization' => $authHeader,
        ])->post($apiUrl, $requestData);

        $data = $response->json();

        if (isset($data[0]['Detail']) == '1000') {
            $message = "ok: Registrado el numero " . $requestData['telephone'] . " con id = " . $idLead . ", «lead» de *Silbo - " . ($lead['company']) . "* en función apiSilbo(). - Ip: " . $this->visitorIp . " - Datos recibidos del «lead» en la función: " . json_encode($data);
            $this->utilsController->registroDeErrores(16, 'Lead saved Silbo', $message, $lead['urlOffer'], $this->visitorIp);
            $codigo = 201;

            $leadValidation = Lead::find($idLead);
            if ($leadValidation) {
                $leadValidation->idResponse = $data[0]['CampaingId'] . '-' . $data[0]['TraceId'];
                $leadValidation->save();
            } else {
                $message = "-0: Fallo al registrar el numero " . $requestData['telephone'] . ", «lead» de *Silbo - " . ($lead['company']) . "* en función apiSilbo(). - Ip: " . $this->visitorIp . ' - Fallo ocurrido: ' . $data[0]['Detail'] . " - Datos recibidos del «lead» en la función: " . json_encode($data);
                $this->utilsController->registroDeErrores(11, 'Lead ERROR', $message, $lead['urlOffer'], $this->visitorIp);
            }
            return response()->json([
                'message' => 'OK. Lead insertado correctamente',
                'status' => $codigo
            ], 200);
        } else {
            $errorLead = '';
            $respuestaLead = '';
            switch (isset($data[0]['Detail'])) {
                case '1000':
                    $respuestaLead = 'OK. Lead insertado correctamente';
                    $codigo = 201;
                    break;
                case '1100':
                    $respuestaLead = 'Lead no válido repetido.';
                    $codigo = 502;
                    break;
                case '1300':
                    $respuestaLead = 'Lead no válido Ya cliente.';
                    $codigo = 502;
                    break;
                case '1301':
                    $respuestaLead = 'Lead no válido Ya cliente grupo';
                    $codigo = 502;
                    break;
                case '1400':
                    $respuestaLead = 'Lead no válido Blacklist/Robinson/No Llamable';
                    $codigo = 502;
                    break;
            }

            $message = $data['message']['status'] . ": Fallo al registrar el numero " . $requestData['telephone'] . ", «lead» de *Silbo - " . ($lead['company']) . "* en función apiSilbo(). - Ip: " . $this->visitorIp . ' - Fallo ocurrido: ' . $respuestaLead . " - Datos recibidos del «lead» en la función: " . json_encode($data);
            $this->utilsController->registroDeErrores(11, 'Lead ERROR', $message, $lead['urlOffer'], $this->visitorIp);
            //$codigo = 502;
        }
        return response()->json([
            'message' => $respuestaLead,
            'status' => $codigo
        ], 200);
    }

    public function apiButik($lead, $idLead)
    {
        //$this->visitorIp = $this->utilsController->$this->visitorIp;
        try {
            $response = null;
            //$customer_name = (empty($request->dataToSend['nombre_usuario']) || ($request->dataToSend['nombre_usuario'] === "n/d")) ? "N/A" : $request->dataToSend['nombre_usuario'];
            $customer_name = "N/A";
            $base_api_url = "https://app.whatconverts.com/api/v1/leads/";

            //Basic Auth:  user => pass; '4273-1dc57737c98d47b7' => 'aa1a2e99df72fdd82ab7045f8d9fa6ad'
            $obj = array(
                'profile_id' => '97488',
                'send_notification' => 'false',
                'lead_type' => 'web_form',
                'lead_source' => 'kolondoo',
                'lead_medium' => 'affiliate',
                'lead_campaign' => 'telco_kolondoo_comparador_pros',
                'additional_fields[Phone Number]' => $this->utilsController->formatTelephone($lead['phone']),
                'phone_number' => $this->utilsController->formatTelephone($lead['phone']),
                //'additional_fields[Contact_name]' => $customer_name,
                'ip_address' => $this->visitorIp
            );
            $header = array(
                'Authorization: Basic NDI3My0xZGM1NzczN2M5OGQ0N2I3OmFhMWEyZTk5ZGY3MmZkZDgyYWI3MDQ1ZjhkOWZhNmFk',
                'Cookie: AWSALB=j8227SuD3vMelmJqAqqL38D7Qvm7L09lF8YztrOQPtjw4RK6KcQI3qto1WuSAk3DIOlfRu6vYFZl76LOwBsra2HzeFcwYoLQdNv68GldF1t5q1EXcKbv/iSmJ5wg; AWSALBCORS=j8227SuD3vMelmJqAqqL38D7Qvm7L09lF8YztrOQPtjw4RK6KcQI3qto1WuSAk3DIOlfRu6vYFZl76LOwBsra2HzeFcwYoLQdNv68GldF1t5q1EXcKbv/iSmJ5wg'
            );
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $base_api_url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => $obj,
                CURLOPT_HTTPHEADER => $header,
            ));

            $response = curl_exec($curl);
            curl_close($curl);
            $responseObj = json_decode($response);

            if ($responseObj->lead_state === 'Completed') {

                $leadValidation = Lead::find($idLead);
                if ($leadValidation) {
                    $leadValidation->idResponse = $responseObj->lead_id;
                    $leadValidation->save();
                } else {
                    $message = "-0: Fallo al registrar el numero " . $lead['phone'] . ", «lead» de *mas butik - " . ($lead['company']) . "* en función butik(). - Ip: " . $this->visitorIp . ' - Fallo ocurrido: ' . $responseObj->status . " - Datos recibidos del «lead» en la función: " . json_encode($responseObj);
                    $this->utilsController->registroDeErrores(11, 'Lead ERROR', $message, $lead['urlOffer'], $this->visitorIp);
                }
                $message = "ok: Registrado el numero " . $lead['phone'] . " con id = " . $idLead . ", «lead» de *Butik - " . ($lead['company']) . "* en función apiButik(). - Ip: " . $this->visitorIp . " - Datos recibidos del «lead» en la función: " . json_encode($responseObj);
                $this->utilsController->registroDeErrores(16, 'Lead saved Butik', $message, $lead['urlOffer'], $this->visitorIp);
                $responseObj->code = 201;
            } else {
                $message = "Fallo al registrar el numero " . $lead['phone'] . ", «lead» de *Butik - " . ($lead['company']) . "* en función apiButik(). - Ip: " . $this->visitorIp . ' - Fallo ocurrido: ' . json_encode($responseObj);
                $this->utilsController->registroDeErrores(10, 'ajaxApiButik', $message);
                $responseObj->code = 502;
            }

            return response()->json([
                'message' => $responseObj->lead_state,
                'status' => $responseObj->code
            ], 200);
        } catch (ConnectionException $e) {
            $message = "Fallo de IpAPI ajaxApiAlternaTelco falla al enviar el «lead» desde IP: " . $this->visitorIp . ' -> ERROR: ' . $e->getMessage();
        }
    }

    public function apiPlenitude($lead, $idLead)
    {
        //$this->visitorIp = $this->utilsController->$this->visitorIp;
        try {
            $response = null;
            $base_api_url = "https://hooks.zapier.com/hooks/catch/13049102/bpkbypb/";

            $obj = array(
                'telefono' => $this->utilsController->formatTelephone($lead['phone']),
                'interes' =>  explode('/', $lead['urlOffer'])[4],
                'source' =>  "desar",
            );

            $query_string = http_build_query($obj);
            $full_api_url = $base_api_url . '?' . $query_string;

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'charset' => 'utf-8'
            ])->acceptJson()
                ->timeout(20)
                ->get($full_api_url);

            $responseObj = json_decode($response);

            if (isset($responseObj->status) && $responseObj->status === "success") {

                $leadValidation = Lead::find($idLead);
                if ($leadValidation) {
                    $leadValidation->idResponse = $responseObj->id;
                    $leadValidation->save();
                } else {
                    $message = "-0: Fallo al registrar el numero " . $lead['phone'] . ", «lead» de *mas plenitude - " . ($lead['company']) . "* en función plenitude(). - Ip: " . $this->visitorIp . ' - Fallo ocurrido: ' . $responseObj->status . " - Datos recibidos del «lead» en la función: " . json_encode($responseObj);
                    $this->utilsController->registroDeErrores(11, 'Lead ERROR', $message, $lead['urlOffer'], $this->visitorIp);
                }

                $message = "ok: Registrado el numero " . $lead['phone'] . " con id = " . $idLead . ", «lead» de *Plenitude - " . ($lead['company']) . "* en función apiPlenitude(). - Ip: " . $this->visitorIp . " - Datos recibidos del «lead» en la función: " . json_encode($responseObj);
                $this->utilsController->registroDeErrores(16, 'Lead saved Plenitude', $message, $lead['urlOffer'], $this->visitorIp);
                $responseObj->code = 201;
            } else {
                $message = "Fallo al registrar el numero " . $lead['phone'] . ", «lead» de *Plenitude - " . ($lead['company']) . "* en función apiPlenitude(). - Ip: " . $this->visitorIp . ' - Fallo ocurrido: ' . json_encode($responseObj);
                $this->utilsController->registroDeErrores(10, 'ajaxApiPlenitude', $message);
                $responseObj->code = 502;
            }

            return response()->json([
                'message' => $responseObj->status,
                'status' => $responseObj->code
            ], 200);
        } catch (ConnectionException $e) {
            $fallo_envio_lead = true;
            $message = "Fallo de IpAPI ajaxApiV3 falla al enviar el «lead» desde IP: " . $this->visitorIp . ' -> ERROR: ' . $e->getMessage();
            $this->utilsController->registroDeErrores(10, 'ajaxApiV3', $message);
        }
    }

    public function apiFrank($lead, $idLead)
{
    try {
        $apiKey = "xyz-leads-api-123";
        $signingKey = "xyz-leads-signing-123";
        $baseApiUrl = "https://preview.frank-api.nl/admin/webhooks/lead";
        //$baseApiUrl = "https://frank-api.nl/admin/webhooks/lead"; /* prod */

        // Datos del lead a enviar
        $leadData = [
            'firstName' => "Arkeero",
            'lastName' => "Vuskoo",
            'lastName2' => null,
            'phoneNumber' => $this->utilsController->formatTelephone($lead['phone']),
            'emailAddress' => "",
            'country' => "ES",
            'leadReference' => time(),
            'originOfLead' => $lead['landing'],
        ];

        $timestamp = round(microtime(true) * 1000);
        $signature = hash_hmac('sha256', $timestamp.json_encode($leadData), $signingKey);

        return $response = Http::withHeaders([
            'ApiKey' => $apiKey,
            'Content-Type' => 'application/json',
            'X-Signature' => "t=$timestamp,v1=$signature"
        ])->post($baseApiUrl, $leadData);

        $responseObj = json_decode($response);

        if (isset($responseObj->status) && $responseObj->status === "success") {
            $leadValidation = Lead::find($idLead);
            if ($leadValidation) {
                $leadValidation->idResponse = $responseObj->id;
                $leadValidation->save();
            }

            $message = "ok: Registrado el numero " . $lead['phone'] . " con id = " . $idLead . ", «lead» de *Plenitude - " . ($lead['company']) . "* en función apiPlenitude(). - Ip: " . $this->visitorIp . " - Datos recibidos del «lead» en la función: " . json_encode($responseObj);
            $this->utilsController->registroDeErrores(16, 'Lead saved Plenitude', $message, $lead['urlOffer'], $this->visitorIp);
            $responseObj->code = 201;
        } else {
            $message = "Fallo al registrar el numero " . $lead['phone'] . ", «lead» de *Plenitude - " . ($lead['company']) . "* en función apiPlenitude(). - Ip: " . $this->visitorIp . ' - Fallo ocurrido: ' . json_encode($responseObj);
            $this->utilsController->registroDeErrores(10, 'ajaxApiPlenitude', $message);
            $responseObj->code = 502;
        }

        return response()->json([
            'message' => $responseObj->status,
            'status' => $responseObj->code
        ], 200);
    } catch (ConnectionException $e) {
        $message = "Fallo de IpAPI ajaxApiV3 falla al enviar el «lead» desde IP: " . $this->visitorIp . ' -> ERROR: ' . $e->getMessage();
        $this->utilsController->registroDeErrores(10, 'ajaxApiV3', $message);
        
        return response()->json([
            'message' => 'Connection failed',
            'status' => 500
        ], 500);
    }
}


    public function apiGanaEnergia($lead, $idLead)
    {
        $response = null;
        $campana = '6310a3a3977bf0af9704cdbd';
        $base_api_url = "https://salesforce.gaolania.com.es/addlead";

        // Construir la URL con los parámetros en la cadena de consulta
        $queryParams = http_build_query([
            'cid' => $campana,
            'phone' => intval($this->utilsController->formatTelephone($lead['phone'])),
        ]);

        $response = Http::get("https://salesforce.gaolania.com.es/addlead", [
            'cid' => '6310a3a3977bf0af9704cdbd',
            'phone' => intval($this->utilsController->formatTelephone($lead['phone'])),
        ]);

        // Decodifica la respuesta JSON
        $responseData = $response->json();

        $message = '';
        if (isset($responseData["error"]) == true) {
            $message = "Fallo al registrar el numero " . $lead['phone'] . ", «lead» de *gana Energia - " . ($lead['company']) . "* en función ganaEnergia(). - Ip: " . $this->visitorIp . ' - Fallo ocurrido: ' . $responseData["msg"] . " - Datos recibidos del «lead» en la función: " . json_encode($responseData);
            $this->utilsController->registroDeErrores(11, 'Lead ERROR', $message, $lead['urlOffer'], $this->visitorIp);
            return response()->json([
                'content' => 'ko',
                'call_response' => 'ko',
                'message' => $message,
                'status' => 502
            ], 502);
        }

        $data = $responseData['data'];
        $statusCode = $responseData['statusCode'];
        $recordId = $responseData['recordId'];
        $msg = $responseData['msg'];

        if (isset($data) == 'OK') {
            $message = "ok: Registrado el numero " . $lead['phone'] . " con id = " . $msg . ", «lead» de *gana energia - " . ($lead['company']) . "* en función ganaEnergia(). - Ip: " . $this->visitorIp . " - Datos recibidos del «lead» en la función: " . json_encode($response);
            $this->utilsController->registroDeErrores(16, 'Lead saved gana energia', $message, $lead['urlOffer'], $this->visitorIp);
            $codigo = 201;

            $lead = Lead::find($idLead);
            $lead->idResponse = $recordId;
            $lead->save();

            // Retornar respuesta exitosa
            return response()->json([
                'content' => 'ok',
                'call_response' => 'ok',
                'message' => $recordId . ' - ' . $msg,
                'status' => 201
            ], 201);
        } else {

            $message = $data['message']['status'] . ": Fallo al registrar el numero " . $data['phone'] . ", «lead» de *gana Energia - " . ($lead['company']) . "* en función ganaEnergia(). - Ip: " . $this->visitorIp . ' - Fallo ocurrido: ' . $responseData["data"] . " - Datos recibidos del «lead» en la función: " . json_encode($responseData);
            $this->utilsController->registroDeErrores(11, 'Lead ERROR', $message, $lead['urlOffer'], $this->visitorIp);
            return response()->json([
                'content' => 'ko',
                'call_response' => 'ko',
                'message' => $message . ' - ' . $msg,
                'status' => 502
            ], 502);
        }
    }

    public function apiPepephone($lead, $idLead)
    {
        $code = "";
        $api_url = "https://cmbr.pepephone.com:3198/CMB/cmbr";
        $auth_user = "kolondoo";
        $auth_password = "Mr171WjKp#913@";

        $phone = $this->utilsController->formatTelephone($lead['phone']);

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'charset' => 'utf-8'
        ])->acceptJson()
            ->timeout(20)
            ->post(
                $api_url,
                [
                    'auth_user' => $auth_user,
                    'auth_password' => $auth_password,
                    'phone' => '+34' . $phone,
                    'customer_name' => 'nombre no facilitado',
                ]
            );

        $responseObj = $response->json();


        if ($responseObj['Resultado'] == "OK") {
            $lead = Lead::find($idLead);
            $lead->idResponse = $responseObj['Resultado'];
            $lead->save();

            $message = "ok: Registrado el numero " . $lead['phone'] . " con id = " . $idLead . ", «lead» de *pepephone - " . ($lead['company']) . "* en función apipepephone(). - Ip: " . $this->visitorIp . " - Datos recibidos del «lead» en la función: " . json_encode($responseObj);
            $this->utilsController->registroDeErrores(16, 'Lead saved pepephone', $message, $lead['urlOffer'], $this->visitorIp);
            $code = 201;
        } else {
            $message = "Fallo al registrar el numero " . $lead['phone'] . ", «lead» de *pepephone - " . ($lead['company']) . "* en función apipepephone(). - Ip: " . $this->visitorIp . ' - Fallo ocurrido: ' . json_encode($responseObj);
            $this->utilsController->registroDeErrores(10, 'ajaxApipepephone', $message);
            $code = 502;
        }

        return response()->json([
            'message' => $responseObj['Resultado'],
            'status' => $code
        ], 200);
    }
}

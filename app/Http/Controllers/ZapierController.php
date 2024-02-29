<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lead;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Hamcrest\Type\IsInteger;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Client\ConnectionException;
use \Illuminate\Http\JsonResponse;

class ZapierController extends Controller
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

    public function leadRegister($request)
    {
        $IP_data = $this->visitorIp;
        $lead = new Lead([
            'landing' => 'Facebook',
            'urlOffer' => 'Facebook',
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
        $lead->save();
        return $lead->id;
    }

    public function facebookZapierCpl(Request $request)
    {
        try {
            $GLOBALS["country_instance"]  = "es";
            $tlf_movil = $this->utilsController->formatTelephone($request->tlf_movil);
            if (empty($tlf_movil)) {
                //$this->utilsController->registroDeErrores(4, 'Número «banneado» o vacío en facebookZapierCpl() function', 'Número: *'.$tlf_movil."*", null, decideCountry());
                return response()->json(array('status' => "ko"), 200);
            }
            $email = (!empty($request->email) && is_string($request->email)) ? trim($request->email) : null;
            $nombre = (!empty($request->nombre)) ? $request->nombre : null;
            $company = $request->company;
            //$instance = DB::table('1_operadoras')->select('nombre', 'funcion_api')->where('id', $company)->where('tipo_conversion', 'cpl')->whereNotNull('funcion_api')->where('estado', '1')->first();
            $instance = DB::table('1_operadoras')->select('nombre', 'funcion_api')->where('id', $company)->where('tipo_conversion', 'cpl')->whereNotNull('funcion_api')->first();
            $instance_zapier = !is_null($instance) ? ($instance->funcion_api) . "ZapierCpl" : null;
            //return print_r($instance_zapier);
            if (!is_null($instance_zapier) && method_exists($this, $instance_zapier) && !empty($tlf_movil)) {
                //Sobreescribimos el objeto $request para el registro del «lead» en nuestra BBDD
                $request->dataToSend =  array(
                    "tel_usuario" => $tlf_movil,
                    "nombre_usuario" => $nombre,
                    "email" => $email,
                    "company" => $company,
                    "producto" => "FACEBOOK",
                    "tipo_conversion" => "cpl",
                    "tarifa" => 'n/d',
                    "tipo_formulario" => "c2c",
                    'acepta_politica_privacidad' => 1,
                    'acepta_cesion_datos_a_proveedor' => 1,
                    'acepta_comunicaciones_comerciales' => 1
                );

                $response = $this->$instance_zapier($request);
                if (json_decode($response->content())->call_response === "ok") {
                    // DADO DE BAJA 
                    //$this->audienceTalkingOfflineLeadCommunication('fblead', 'c2c', $tlf_movil, 'TELCO', $this->formatCloseLeadsValues('atkey', $instance->nombre), 'facebook','social');
                    return response()->json(array('status' => "ok"), 200);
                } else {
                    return response()->json(array('status' => "ko"), 200);
                }
            } else {
                //$this->utilsController->registroDeErrores(4, 'facebookZapierCpl', "Se intenta acceder a la función sin identificador de compañía válido o a función no permitida. id de compañía solicitada: *".$company."*. Datos recibidos del formulario: ".json_encode(array('tlf_movil' => $tlf_movil,'email' => $email,'nombre' => $nombre,'company' => $company)), JSON_UNESCAPED_UNICODE);
                return response()->json(array('status' => "ko"), 500);
            }
        } catch (ConnectionException | \PDOException | \Exception $e) {
            //$this->utilsController->registroDeErrores(3, 'facebookZapierCpl', "Fallo en  facebookZapierCpl. ERROR capturado en catch: " . $e->getMessage());
            return response()->json(array('status' => "ko"), 500);
        }
    }

    public function ajaxApiPepephoneZapierCpl(Request $request)
    {
        $return = "ko";
        $response = null;
        $visitorIp = $this->visitorIp;
        $lead_id = null;

        $api_url = "https://cmbr.pepephone.com:3198/CMB/cmbr";
        $auth_user = "kolondoo";
        $auth_password = "Mr171WjKp#913@";
        $customer_name = ($request->dataToSend['nombre_usuario'] === "n/d") || empty($request->dataToSend['nombre_usuario']) ? "nombre no facilitado" : $request->dataToSend['nombre_usuario'];
        $phone = $this->utilsController->formatTelephone($request->dataToSend['tel_usuario']);

        try {
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
                        'phone' => $phone,
                        'customer_name' => Str::substr($customer_name, 0, 30),
                    ]
                );
        } catch (ConnectionException $e) {
            echo $e->getMessage();
            $message = "Fallo de IpAPI ajaxApiPepephoneZapierCpl no responde - ERROR: " . $e->getMessage();
            //$this->utilsController->registroDeErrores(9, 'ApiPepephoneZapierCpl', $message);
        }
        //Control respuesta API
        if (!empty($response) && $response->successful() && !empty($response->body())) {
            $return = Str::lower(json_decode($response->body())->Resultado);
            if ($return === "ko") {
                //$this->utilsController->registroDeErrores(10, 'ApiPepephoneZapierCpl', "Fallo de API ajaxApiPepephoneZapierCpl responde KO: " . $response->body());
            } elseif ($return == "ok") {
                //Registramos en BBDD el lead
                $this->$this->leadRegister($request);
                return response()->json(array('call_response' => 'ok', 'lead_id' => $lead_id), 200);
            }
        } else {
            //$this->utilsController->registroDeErrores(10, 'ajaxApiPepephoneZapierCpl', "Fallo de IpAPI ajaxApiPepephoneZapierCpl objeto HTTP response vacío");
        }
        return response()->json(array('call_response' => $return, 'lead_id' => $lead_id), 200);
    }

    public function ajaxApiVodafoneZapierCpl(Request $request)
    {
        $return = "ko";
        $response = null;
        $visitorIp = $this->visitorIp;
        $lead_id = null;
        $api_url = "https://ws.walmeric.com/provision/wsclient/client_addlead.html";
        $customer_name = ($request->dataToSend['nombre_usuario'] === "n/d") ? "Nombre no facilitado" : $request->dataToSend['nombre_usuario'];
        $phone = $this->utilsController->formatTelephone($request->dataToSend['tel_usuario']);

        /**
         * Si está definido el valor $request->dataToSend['tarifa'] implica que viene de la web. Si no es así, posiblemente venga de FB por lo que usamos una URL por defecto.
         */

        if (isset($request->dataToSend['tarifa'])) {
            $id_tarifa = substr($request->dataToSend['tarifa'], 0, 2);

            if ($id_tarifa == "36") {
                $url_envio = "https://kolondoo.com/es/comparador-solo-fibra/solo-fibra-vodafone-36/?afp=afiliado.kolondo:cp-vdf_tol_continuidad:cn-afiliacion_propia:dt-20230720:wn-tol:cl-no_cliente:sp-Kolondo:ta-comparador:pr-fibra";
            } elseif ($id_tarifa == "19") {
                $url_envio = "https://kolondoo.com/es/comparador-fibra-movil-television/fibra-movil-television-vodafone-19/?afp=afiliado.kolondo:cp-vdf_tol_continuidad:cn-afiliacion_propia:dt-20230720:wn-tol:cl-no_cliente:sp-Kolondo:ta-comparador:pr-convergente";
            } elseif ($id_tarifa == "53") {
                $url_envio = "https://kolondoo.com/es/comparador-fibra-movil/fibra-movil-vodafone-53/?afp=afiliado.kolondo:cp-vdf_tol_continuidad:cn-afiliacion_propia:dt-20230720:wn-tol:cl-no_cliente:sp-Kolondo:ta-comparador:pr-convergente";
            } elseif ($id_tarifa == "37") {
                $url_envio = "https://kolondoo.com/es/comparador-solo-fibra/solo-fibra-vodafone-37/?afp=afiliado.kolondo:cp-vdf_tol_continuidad:cn-afiliacion_propia:dt-20230720:wn-tol:cl-no_cliente:sp-Kolondo:ta-comparador:pr-fibra";
            } elseif ($id_tarifa == "35") {
                $url_envio = "https://kolondoo.com/es/comparador-tarifa-movil/tarifa-movil-vodafone-35/?afp=afiliado.kolondo:cp-vdf_tol_continuidad:cn-afiliacion_propia:dt-20230720:wn-tol:cl-no_cliente:sp-Kolondo:ta-comparador:pr-voz";
            } elseif ($id_tarifa == "20") {
                $url_envio = "https://kolondoo.com/es/comparador-fibra-movil-television/fibra-movil-television-vodafone-20/?afp=afiliado.kolondo:cp-vdf_tol_continuidad:cn-afiliacion_propia:dt-20230720:wn-tol:cl-no_cliente:sp-Kolondo:ta-comparador:pr-convergente";
            } else {
                $url_envio = "https://kolondoo.com/es/comparador-fibra-movil/fibra-movil-vodafone-51/?afp=afiliado.kolondo:cp-vdf_tol_continuidad:cn-afiliacion_propia:dt-20230720:wn-tol:cl-no_cliente:sp-Kolondo:ta-comparador:pr-convergente";
            }
        } else {
            $url_envio = "https://kolondoo.com/es/comparador-solo-fibra/solo-fibra-vodafone-36/?afp=afiliado.kolondo:cp-vdf_tol_continuidad:cn-afiliacion_propia:dt-20230720:wn-tol:cl-no_cliente:sp-Kolondo:ta-comparador:pr-fibra";
        }

        try {
            $sending_info = array(
                'format' => 'json',
                'leadOrigin' => 2,
                'verifyLeadId' => 'NO',
                'idTag' => '29842f94d414949bf95fb2e6109142cfef1fb2a78114c2c536a36bf5a65b953a5fc1ca581ceb7bf8fd143a36f4eb693794c0f95c76664a12dbaa532a82b5988a207dd2d28aa08a82723b60cd54ef0e48c74633b53f730f0cd49704764ddbffcfc2acce400df040d0c0c089089936cd1f',
                'phone' => $phone,
                'nombre' => $customer_name,
                'Gb_channel' => 'Particulares',
                'Gb_asset_name' => 'kolondo',
                'url' => $url_envio,
                'EConversion' => json_encode([['id' => 7, 'value' => 'comparador']], JSON_UNESCAPED_UNICODE),
                'EVisit' => json_encode([['id' => 0, 'value' => 'no_cliente'], ['id' => 1, 'value' => $this->getVodafoneEVisit($request->dataToSend['producto'])]], JSON_UNESCAPED_UNICODE),
            );

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'charset' => 'utf-8'
            ])->acceptJson()
                ->timeout(20)
                ->get($api_url, $sending_info);
        } catch (ConnectionException $e) {
            $message = "Fallo de API ajaxApiVodafoneZapierCpl no responde - ERROR: " . $e->getMessage();
           // $this->utilsController->registroDeErrores(9, 'ajaxApiVodafoneZapierCpl', $message);
        }
        //Control respuesta API
        if (!empty($response) && !empty($response->body())) {
            $result = json_decode($response->body());
            $return = Str::lower($result->result);
            if ($response->successful()) {
                $lead_id = $this->leadRegister($request);
            } else {
               // $this->utilsController->registroDeErrores(10, 'ajaxApiVodafoneZapierCpl', "Fallo de IpAPI ajaxApiVodafoneZapierCpl responde: " . $result->message);
            }
        } else {
           // $this->utilsController->registroDeErrores(10, 'ajaxApiVodafoneZapierCpl', "Fallo de IpAPI ajaxApiVodafoneZapierCpl objeto HTTP response vacío");
        }

        return response()->json(array('call_response' => $return, 'lead_id' => $lead_id), 200);
    }

    private function getVodafoneEVisit($service): string
    {
        $return = null;
        switch ($service) {
            case "TELCO_FIBRA":
            case "TELCO_INTERNET_RURAL":
                $return = "2p";
                break;
            case "TELCO_MOVIL":
                $return = "Voz";
                break;
            case "TELCO_TV":
                $return = "TV";
                break;
            default:
                $return = "One";
                break;
        }

        return $return;
    }

    public function redesSocialesZapier(Request $request)
    {
        $red_social = Str::replace("-zapier", "", Route::current()->getName());
        try {
            /*
                Lo establecemos a mano, ya que para la ruta que lanza esta función no se usa InstanceMiddleware (Se llama desde la IP de Zapier)  por lo que esta variable no se establece es este Middleware.
               Como IberiaController es exclusivo de España:  GLOBALS["country_instance"]  = "es".
               GLOBALS["country_instance"]  es necesario inicializarlo, ya que se llamará a esta variable en la función connexionDB();
           */
            $GLOBALS["country_instance"]  = "es";
            $api_url = "https://ocm.kolondoo.com/add-lead-rrss";
            $response = null;
            $result = "ko";

            //Datos de tabla
            $tlf_movil = $this->utilsController->formatTelephone($request->tlf_movil);
            $email = (!empty($request->email) && is_string($request->email)) ? trim($request->email) : null;
            $nombre = (!empty($request->nombre)) ? $request->nombre : null;
            $company = $request->company;
            $rrss = $request->rrss_origin;

            /* Banneo de números de teléfono presentes en la lista negra. */
            /* if (empty($tlf_movil) || isBannedPhone($tlf_movil)) {
               // $this->utilsController->registroDeErrores(4, 'Número «banneado» o vacío en función redesSocialesZapier()/' . $red_social, 'Número: *' . $tlf_movil . "*", null, decideCountry());
                return response()->json(array('status' => "ko"), 200);
            } */

            //Guardamos el «lead»
            $user_id = null;

            if (DB::table('lead')->where('phone', $tlf_movil)->exists()) {
                $user_id = DB::table('lead')->where('phone', $tlf_movil)->pluck('id')->first();
                DB::table('lead')->where('id', $user_id)->update(array('email' => $email, 'nombre_usuario' => $nombre, 'acepta_politica_privacidad' => 1, 'acepta_cesion_datos_a_proveedor' => 1, 'acepta_comunicaciones_comerciales' => 1, 'fecha_aceptacion_comunicaciones_comerciales' => Carbon::now()->format("Y-m-d H:i:s")));
            } else {
                $lead = new Lead([
                    "phone" => $tlf_movil,
                    "nombre_usuario" => $nombre,
                    "landing" => $rrss,
                    "email" => $email,
                    "company" => $company,
                    "producto" => Str::upper($red_social),
                    "tipo_conversion" => "cpa",
                    "tarifa" => 'n/d',
                    "company" => 'n/d',
                    "tipo_formulario" => "c2c",
                    'acepta_politica_privacidad' => 1,
                    'acepta_cesion_datos_a_proveedor' => 1,
                    'acepta_comunicaciones_comerciales' => 1,
                    'fecha_aceptacion_comunicaciones_comerciales' => Carbon::now()->format("Y-m-d H:i:s")
                ]);
                if ($lead->save()) {
                    $result = "ok";
                } else {
                    $result = "ko";
                }
            }
        } catch (ConnectionException | \PDOException | \Exception $e) {
            $message = "Fallo en  redesSocialesZapier()/'.$red_social'. ERROR capturado en catch: " . $e->getMessage();
            //$this->utilsController->registroDeErrores(3, 'redesSocialesZapier()/' . $red_social, $message);
            return response()->json(array('status' => "ko"), 500);
        }

        return response()->json(array('status' => $result), 200);
    }

    public function redesSocialesEnergyZapier(Request $request)
    {
        $GLOBALS["country_instance"]  = "es";

        //Control sobre el teléfono de usuario
        $tel_usuario = $this->utilsController->formatTelephone($request->tlf_movil);
        if (empty($tel_usuario) || !is_string($tel_usuario) || strlen($tel_usuario) !== 9 || !Str::startsWith($tel_usuario, ['6', '7', '8', '9']) || !is_numeric($tel_usuario)) {
            //$this->utilsController->registroDeErrores(10, 'redesSocialesEnergyZapier', "Parámetro tlf_movil no cumple con el estándar: *" . $tel_usuario . "*");
            return response()->json(array('call_response' => 'ko', 'message' => 'Teléfono erróneo.'), 200);
        }
        if ($request->user !== env("USER_ENERGY_RRSS_ACCESS") && $request->pass !== env("PASS_ENERGY_RRSS_ACCESS")) //Acceso para redes sociales desde Zapier
        {
            //$this->utilsController->registroDeErrores(5, 'Intento de acceso no permitido', 'Se bloquea acceso a función redesSocialesEnergyZapier() protegida con usuario y contraseña. Post: ' . json_encode($request->post()) . ", User Auth: " . $request->getUser() . ", Pass Auth: " . $request->getPassword());
            exit();
        }
        /* Control de parámetros de entrada y salida */
        $response = null;
        $company_control_fails = true;
        $politica_privacidad_fails = true;
        $lead_type_is_cpa = null;
        $company = DB::table('1_comercializadoras')->where('id', $request->company)->pluck('nombre')->first();
        $tipo_conversion = null;

        switch ($company) {
                //Clientes cpl
            case "Repsol":
            case "Plenitude":
                $company_control_fails = false;
                $tipo_conversion = "cpl";
                $lead_type_is_cpa = false;
                $politica_privacidad_fails = (intval($request->acepta_cesion_datos_a_proveedor) !== 1) ? 1 : 0;
                break;
        }

        if ($company_control_fails) {
            //$this->utilsController->registroDeErrores(13, 'redesSocialesEnergyZapier', "Parámetro recibido «cmnpany» no contemplado. Llamada recibida:  *" . json_encode($request->post()) . "*");
            return response()->json(array('call_response' => 'ko', 'message' => "El parámetro «cmnpany» debe ser uno de los siguientes: Repsol, Holaluz, Lucera, Alterna, PepeEnergy, LuzDosTres, Iberdrola, Endesa, Naturgy, Sweno, Wombbat, Gana Energía o Naturgy By. Se ha recibido: {company_id: " . ($request->company) . "}"), 200);
        } elseif ($politica_privacidad_fails) {
            //$this->utilsController->registroDeErrores(13,  'redesSocialesEnergyZapier', "Política de privacidad no aceptada correctamente redesSocialesEnergyZapier(). Llamada recibida:  *" . json_encode($request->post()) . "*");
            return response()->json(array('call_response' => "ko", 'message' => "Debe incluir el campo «" . ($lead_type_is_cpa ? "acepta_politica_privacidad" : "acepta_cesion_datos_a_proveedor") . "» con valor numérico: 1"), 200);
        }

        //Construimos objeto
        //Para pasar la barrera $request->ajax()
        $request->headers->add(array('X-Requested-With' => 'XMLHttpRequest'));
        $request->dataToSend = array(
            'tel_usuario' => $tel_usuario,
            'is_mobile' => (in_array(Str::substr($tel_usuario, 0, 1), array(8, 9), true)) ? 0 : 1,
            'tarifa' => empty($request->tarifa) ? "N/D" : $request->tarifa,
            'tipo_formulario' => 'c2c',
            'landing' => $request->rrss_origin,
            'company' => $request->company,
            'acepta_comunicaciones_comerciales' => 1,
            'producto' =>  $request->rrss_origin,
            'tipo_conversion' => $tipo_conversion,
            'precio' => empty($request->precio) ? null : $request->precio,
            'direccion_usuario' => $request->direccion_usuario ?? null,
            'acepta_politica_privacidad' => 0,
            'acepta_cesion_datos_a_proveedor' => 0,
            'poblacion_usuario' => $request->poblacion_usuario ?? null,
            'provincia_usuario' => $request->provincia_usuario ?? null,
            'cp_usuario' => $request->cp_usuario ?? null,
            'nombre_usuario' => $request->nombre_usuario ?? null,
            'email' => $request->email ?? null
        );

        $request->utm_source = Str::lower($request->rrss_origin);

        switch ($company) {
            case "Repsol":
                $request->dataToSend['acepta_cesion_datos_a_proveedor'] = (intval($request->acepta_cesion_datos_a_proveedor) === 1) ? 1 : 0;
                $response = $this->ajaxApiRepsol($request);
                break;
            case "Plenitude":
                $request->dataToSend['acepta_cesion_datos_a_proveedor'] = (intval($request->acepta_cesion_datos_a_proveedor) === 1) ? 1 : 0;
                $response = $this->ajaxApiV3($request);
                break;
        }

        if (!empty($response->original) && $response->original['call_response'] === 'ok') {
            // DADO DE BAJA $this->audienceTalkingOfflineLeadCommunication('fblead', 'c2c', $tel_usuario, 'ENERGIA', $this->formatCloseLeadsValues('atkey', $company), 'facebook','social');
            $response = $response->original;
        } else {
            $response = array('call_response' => 'ko', 'message' => "Sin respuesta del WS destino de la compañía: {" . $company . "}");
           // $this->utilsController->registroDeErrores(13, 'redesSocialesEnergyZapier', "WS de la compañía: {" . $company . "}, no devolvió respuesta. Llamada recibida:  " . json_encode($request->post()));
        }

        return response()->json($response, 200);
    }

    public function ajaxApiEnergiaCPA(Request $request)
    {
        $return = "ko";
        $lead_id = null;

        if ($request->ajax()) {
            $visitorIp = $this->visitorIp;
            $response = null;
            $lead_id = $this->leadRecordEnergy($request);
            if ($lead_id !== "energia_not_registered") {
                echo '1';
                //Definimos el objeto a mandar a «call center»
                $lead_identifier = intval(Str::replace('energia_', '', $lead_id));
                $api_url = "https://ocm.kolondoo.com/add-lead-energy";
                $nombre = (empty($request->dataToSend['nombre_usuario']) || $request->dataToSend['nombre_usuario'] === "n/d") ? null : $request->dataToSend['nombre_usuario'];
                $phone = $this->formatTelephone($request->dataToSend['tel_usuario']);
                $tlf_movil = null;
                $tlf_fijo = null;
                if (intval($request->dataToSend['is_mobile']) === 1) {
                    $tlf_movil = $phone;
                } else {
                    $tlf_fijo = $phone;
                }
                $email = empty($request->dataToSend['email']) ? null : trim($request->dataToSend['email']);
                $direccion = empty($request->dataToSend['direccion_usuario']) ? null : trim($request->dataToSend['direccion_usuario']);
                $poblacion = empty($request->dataToSend['poblacion_usuario']) ? null : trim($request->dataToSend['poblacion_usuario']);
                $provincia = empty($request->dataToSend['provincia_usuario']) ? null : trim($request->dataToSend['provincia_usuario']);
                $codigo_postal = empty($request->dataToSend['cp_usuario']) ? null : trim($request->dataToSend['cp_usuario']);
                $acepta_politica_proveedor_kolondoo = !empty($request->dataToSend['acepta_politica_privacidad']) && (intval(trim($request->dataToSend['acepta_politica_privacidad'])) === 1);
                $company = empty($request->dataToSend['company']) ? null : $request->dataToSend['company'];
                $aux = explode('_', $request->dataToSend['producto']);
                $mercado = $aux[0];
                unset($aux[0]);
                $servicio = implode("_", $aux);
                $detalle_oferta = empty($request->dataToSend['tarifa']) ? null : $request->dataToSend['tarifa'];
                $preferencia_de_consumo = empty($request->dataToSend['consumo']) ? null : trim($request->dataToSend['consumo']);
                $preferencia_de_pago_luz = empty($request->dataToSend['pagar_luz']) ? null : trim($request->dataToSend['pagar_luz']);

                $energia_verde = empty($request->dataToSend['luz_verde']) ? null : (intval(trim($request->dataToSend['luz_verde'])) === 1);
                $maximo_ahorro = empty($request->dataToSend['maximo_ahorro']) ? null : (intval(trim($request->dataToSend['maximo_ahorro'])) === 1);
                $tengo_gas = null;
                if (isset($request->dataToSend['tengo_gas'])) {
                    $tengo_gas = empty($request->dataToSend['tengo_gas']) ? null : (intval(trim($request->dataToSend['tengo_gas'])) === 1);
                }
                $tengo_luz = null;
                if (isset($request->dataToSend['tengo_luz'])) {
                    $tengo_luz = empty($request->dataToSend['tengo_luz']) ? null : (intval(trim($request->dataToSend['tengo_luz'])) === 1);
                }

                $precio = empty($request->dataToSend['precio']) ? null : floatval($request->dataToSend['precio']);
                $tipo_formulario = empty($request->dataToSend['tipo_formulario']) ? null : trim($request->dataToSend['tipo_formulario']);

                //Comprobación de aceptación de política de privacidad extra y envío a marcadora
                if ($acepta_politica_proveedor_kolondoo) {
                    $dataToSend = $this->encryptDataToCallCenter(
                        json_encode(
                            array(
                                'lead_id' => $lead_identifier,
                                'prioridad' => $this->getPriority(isset($request->utm_source) ? $request->utm_source : null),
                                'tlf_movil' => $tlf_movil,
                                'tlf_fijo' => $tlf_fijo,
                                'email' => $email,
                                'nombre' => $nombre,
                                'direccion' => $direccion,
                                'poblacion' => $poblacion,
                                'provincia' => $provincia,
                                'codigo_postal' => $codigo_postal,
                                'acepta_politica_proveedor_kolondoo' => true,
                                'company' => $company,
                                'mercado' => $mercado,
                                'servicio' => $servicio,
                                'detalle_oferta' => $detalle_oferta,
                                'preferencia_de_consumo' => $preferencia_de_consumo,
                                'preferencia_de_pago_luz' => $preferencia_de_pago_luz,
                                'energia_verde' => $energia_verde,
                                'maximo_ahorro' => $maximo_ahorro,
                                'tengo_gas' => $tengo_gas,
                                'tengo_luz' => $tengo_luz,
                                'precio' => strval($precio),
                                'origen' => (isset($request->utm_source) && !empty($request->utm_source)) ? ($request->utm_source) : "direct",
                                'formulario' => $tipo_formulario
                            ),
                            JSON_UNESCAPED_UNICODE
                        ),
                        "encrypt"
                    );

                    try {
                        $response = Http::withHeaders([
                            'Content-Type' => 'application/json',
                            'Accept' => 'application/json',
                            'charset' => 'utf-8'
                        ])->acceptJson()
                            ->timeout(20)
                            ->post($api_url, array('Authorization' => $dataToSend));
                    } catch (ConnectionException $e) {
                        $message = "Fallo en ajaxApiEnergiaCPA no responde - ERROR: " . $e->getMessage();
                       // $this->utilsController->registroDeErrores(9, 'ajaxApiEnergiaCPA', $message);
                    }
                }

                //Comprobación de comunicación con API marcadora
                if (!empty($response) && !empty($response->status()) && ($response->status() === 200) &&  !empty(json_decode($response->body())->status) && (json_decode($response->body())->status === "ok")) {
                    //Respuesta correcta del WS
                    $return = "ok";
                } else {
                    /*
                        Códigos de error del WS. Cabecera de llamadas:
                        501) Error obteniendo desde tabla ocm_skill_loads el registro con idLoad solicitado en función SacarNombreSkill(), clase Modelo_Ocm
                        502) Excepción capturada en SacarNombreSkill(), clase Modelo_Ocm: ......(catch capturado)
                        503) Error insertando registro en funcion InsertarLeadData(), clase Modelo_Ocm. ERROR: .......(mensaje de error de la conexión)
                        504) Excepción capturada en InsertarLeadData(), clase Modelo_Ocm: ......(catch capturado)
                        505) Error insertando registro en funcion InsertarLeadDataExtend(), clase Modelo_Ocm. ERROR: .......(mensaje de error de la conexión)
                        506) Excepción capturada en InsertarLeadDataExtend(), clase Modelo_Ocm: ......(catch capturado)
                        507) Falta parámetro teléfono requerido en la llamada
                        508) Error conectando a BBDD, ERROR: .....(error producido)
                        509) Error al preparando la query: ......(query)
                    */
                    $error = (!empty($response) && !empty($response->status())) ? ("Cabecera https: *" . $response->status() . "*") : "No hay respuesta correcta de la llamada https a ajaxApiEnergiaCPA";
                    if (!$acepta_politica_proveedor_kolondoo) {
                        $error = "Política de privacidad NO ACEPTADA ha llegado a la función, valor recibido en el «field acepta_politica_privacidad»: " . (empty($request->dataToSend['acepta_politica_privacidad']) ? '*null*' : "*" . $request->dataToSend['acepta_politica_privacidad'] . "*");
                    }
                   // $this->utilsController->registroDeErrores(10, 'ajaxApiEnergiaCPA', "Fallo de IpAPI ajaxApiEnergiaCPA responde KO - ERROR: " . $error);
                    $return = "ko";
                }
            } else {
               // $this->utilsController->registroDeErrores(10, 'Fallo ajaxApiEnergiaCPA', 'id_lead no es como se espera (esperado: energia_*lead_id numérico*), recibido: ' . $lead_id);
            }
        } else {
            /*
                 En este punto estamos registrando una llamada a ajaxApiEnergiaCPA desde un script ajeno a kolondoo.com por lo que bloqueamos dicha llamada. Mandamos decideCountry(),
                ya que esta ruta está condicionada por el «middleware InstanceMiddleware» y se decide por el prefijo de ruta (no se llama a IPAPI).
                El valor «null» enviado en// $this->utilsController->registroDeErrores() correspondería al país de origen de llamada, mandamos null para evitar llamar a IPAPI  en ataques por fuerza bruta que consumirían stock IpAPI.
            */
           // $this->utilsController->registroDeErrores(4, 'Llamada Ajax no permitida', 'Llamada a funcion ajaxApiEnergiaCPA con origen no ajax. Se bloquea acceso', null, decideCountry());
        }

        sleep(2);
        return response()->json(array('call_response' => $return, 'lead_id' => $lead_id), 200);
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

    public function ajaxApiAlternaEnergy(Request $request)
    {
        /* Módulo de seguridad para evitar generar «leads» en la instancia desde otro país */
        if (!checkingLeadComesFromOurCountryInstance('ajaxApiAlternaEnergy')) {
            return response()->json(array('call_response' => "ko", 'lead_id' => null), 200);
        }

        /* Banneo de números de teléfono presentes en la lista negra. */
        if (isset($request->dataToSend['tel_usuario']) && isBannedPhone($this->formatTelephone($request->dataToSend['tel_usuario']))) {
           // $this->utilsController->registroDeErrores(4, 'Número «banneado»en función ajaxApiAlternaEnergy()', 'Número: *' . $this->formatTelephone($request->dataToSend['tel_usuario']) . "*", null, decideCountry());
            return response()->json(array('call_response' => "ko", 'lead_id' => null), 200);
        }

        $call_response = "ko";
        $lead_id = null;
        $visitorIp = $this->visitorIp;
        if ($request->ajax()) {
            try {
                $response = null;
                $phone = $this->formatTelephone($request->dataToSend['tel_usuario']);
                $customer_name = (empty($request->dataToSend['nombre_usuario']) || ($request->dataToSend['nombre_usuario'] === "n/d")) ? "N/A" : $request->dataToSend['nombre_usuario'];
                $base_api_url = "https://app.whatconverts.com/api/v1/leads/";
                $lead_id = $this->leadRegister($request);

                //Basic Auth:  user => pass; '4273-1dc57737c98d47b7' => 'aa1a2e99df72fdd82ab7045f8d9fa6ad'
                $obj = array(
                    'profile_id' => '90124',
                    'send_notification' => 'false',
                    'lead_type' => 'web_form',
                    'lead_source' => 'kolondoo',
                    'lead_medium' => 'affiliate',
                    'lead_campaign' => 'energia_kolondoo_comparador_pros',
                    'additional_fields[Phone Number]' => $phone,
                    'phone_number' => $phone,
                    //'additional_fields[Contact_name]' => $customer_name,
                    'ip_address' => $visitorIp
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

                if (isset($responseObj->lead_id) && !empty($responseObj->lead_id)) {
                    $call_response = "ok";
                } else {
                    $call_response = "ko";
                    $message = "Fallo de API ajaxApiAlternaEnergy responde KO. Enviado a la API: " . json_encode($obj) . ", Respuesta del WS ajaxApiAlternaEnergy: " . $response;
                   // $this->utilsController->registroDeErrores(10, 'ajaxApiAlternaEnergy', $message);
                }
            } catch (ConnectionException $e) {
                $fallo_envio_lead = true;
                $message = "Fallo de IpAPI ajaxApiAlternaEnergy falla al enviar el «lead» desde IP: " . $visitorIp . ' -> ERROR: ' . $e->getMessage();
            }
        }

        sleep(2);
        return response()->json(array('call_response' => $call_response, 'lead_id' => $lead_id), 200);
    }

    public function ajaxApiHolaluz(Request $request)
    {
        /* Módulo de seguridad para evitar generar «leads» en la instancia desde otro país */
        if (!checkingLeadComesFromOurCountryInstance('ajaxApiHolaluz')) {
            return response()->json(array('call_response' => "ko", 'lead_id' => null), 200);
        }

        /* Banneo de números de teléfono presentes en la lista negra. */
        if (isset($request->dataToSend['tel_usuario']) && isBannedPhone($this->formatTelephone($request->dataToSend['tel_usuario']))) {
           // $this->utilsController->registroDeErrores(4, 'Número «banneado»en función ajaxApiHolaluz()', 'Número: *' . $this->formatTelephone($request->dataToSend['tel_usuario']) . "*", null, decideCountry());
            return response()->json(array('call_response' => "ko", 'lead_id' => null), 200);
        }

        $return = "ko";
        $response = null;
        $lead_id = null;

        if ($request->ajax()) {
            $api_url = "https://leads.bysidecar.me/lead/store/"; //Producción

            $lead_id = $this->leadRegister($request);
            if ($lead_id !== "energia_not_registered") {
                $object = array(
                    "sou_id" => 88,
                    "lea_type" => 9,
                    "phone" => $this->formatTelephone($request->dataToSend['tel_usuario']),
                    "utm_source" => "185",
                    "smartcenter" => true,
                );

                try {
                    $response = Http::withHeaders([
                        'Content-Type' => 'application/json',
                        'Accept' => 'application/json',
                        'charset' => 'utf-8',
                    ])->acceptJson()
                        ->timeout(20)
                        ->post($api_url, $object);

                    if (!empty($response) && $response->successful() && !empty($response->body())) {
                        $body = json_decode($response->body());
                        if (isset($body->response)) {
                            if ($body->response === "OK") {
                                $return = "ok";
                            } else {
                                $return = "ko";
                                $message = "Fallo de API ajaxApiHolaluz responde KO. Enviado a la API: " . json_encode($object) . ", Respuesta del WS HolaLuz: " . $response->body();
                               // $this->utilsController->registroDeErrores(10, 'ajaxApiHolaluz', $message);
                            }
                        }
                    } else {
                        $message = "Fallo de API ajaxApiHolaluz responde KO. Objeto de respuesta id null o no existe respuesta. Enviado a la API: " . json_encode($object);
                       // $this->utilsController->registroDeErrores(10, 'ajaxApiHolaluz', $message);
                    }
                } catch (ConnectionException $e) {
                    $message = "Fallo de API ajaxApiHolaluz no responde - ERROR: " . $e->getMessage();
                   // $this->utilsController->registroDeErrores(9, 'ajaxApiHolaluz', $message);
                }
            }
        } else {
           // $this->utilsController->registroDeErrores(10, 'ajaxApiHolaluz', "Fallo de API ajaxApiHolaluz objeto HTTP response vacío o cuerpo de la respuesta no contiene nada.");
        }

        sleep(2);
        return response()->json(array('call_response' => $return, 'lead_id' => $lead_id), 200);
    }

    public function ajaxApiPepephone(Request $request)
    {
        /*
        sleep(2);
        $lead_id = leadRecordTelco($request);
        return response()->json(array('call_response' => "ok", 'lead_id' => $lead_id), 200);
        */

        /* Módulo de seguridad para evitar generar «leads» en la instancia desde otro país */
        if (!checkingLeadComesFromOurCountryInstance('ajaxApiPepephone')) {
            return response()->json(array('call_response' => "ko", 'lead_id' => null), 200);
        }

        /* Banneo de números de teléfono presentes en la lista negra. */
        if (isset($request->dataToSend['tel_usuario']) && isBannedPhone($this->formatTelephone($request->dataToSend['tel_usuario']))) {
           // $this->utilsController->registroDeErrores(4, 'Número «banneado»en función ajaxApiPepephone()', 'Número: *' . $this->formatTelephone($request->dataToSend['tel_usuario']) . "*", null, decideCountry());
            return response()->json(array('call_response' => "ko", 'lead_id' => null), 200);
        }

        $return = "ko";
        $response = null;
        $visitorIp = $this->visitorIp;
        $lead_id = null;
        $api_url = "https://cmbr.pepephone.com:3198/CMB/cmbr";
        $auth_user = null;
        $auth_password = null;
        $functionSaveLead = null;
        $market = "NO MARKET";

        //Si venimos de función redesSocialesEnergyZapier() existe el parámetro $request->rrss_energia. Vamos a usarlo para determinar que mercado cargar.
        $case = getMarket(isset($request->rrss_energia) ? ($request->rrss_energia) : $request->dataToSend['producto']);
        switch ($case) {
            case "telco":
                $auth_user = "kolondoo";
                $auth_password = "Mr171WjKp#913@";
                $functionSaveLead = "leadRecordTelco";
                $market = "Telco";
                break;
            case "energia":
                $auth_user = "kolondoo_EN";
                $auth_password = "En871WjKp@876#";
                $functionSaveLead = "$this->leadRegister";
                $market = "Energia";
                break;
        }

        if ($request->ajax()) {
            $customer_name = (empty($request->dataToSend['nombre_usuario']) || ($request->dataToSend['nombre_usuario'] === "n/d")) ? "nombre no facilitado" : $request->dataToSend['nombre_usuario'];
            $phone = $this->formatTelephone($request->dataToSend['tel_usuario']);

            try {
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
                            'phone' => $phone,
                            'customer_name' => Str::substr($customer_name, 0, 30),
                        ]
                    );
            } catch (ConnectionException $e) {
                $message = "Fallo de API Pepephone (" . $market . ") no responde - ERROR: " . $e->getMessage();
               // $this->utilsController->registroDeErrores(9, 'ApiPepephone', $message);
            }
        }

        //Control respuesta API
        if (!empty($response) && $response->successful() && empty($response->body()->Resultado)) {
            $return = Str::lower(json_decode($response->body())->Resultado);
            if ($return === "ko") {
               // $this->utilsController->registroDeErrores(10, 'ApiPepephone', "Fallo de API Pepephone (" . $market . ") responde KO: " . $response->body());
            } elseif ($return === "ok") {
                //Registramos en BBDD el lead
                $lead_id = $functionSaveLead($request);
                //createFileLog('local', 'pepe', $response->body());
            }
        } else {
           // $this->utilsController->registroDeErrores(10, 'ajaxApiPepephone', "Fallo de API Pepephone (" . $market . ") objeto HTTP response vacío");
        }

        return response()->json(array('call_response' => $return, 'lead_id' => $lead_id), 200);
    }

    public function ajaxApiNaturgyByHorizon(Request $request)
    {
        /* Módulo de seguridad para evitar generar «leads» en la instancia desde otro país */
        if (!checkingLeadComesFromOurCountryInstance('ajaxApiNaturgyByHorizon')) {
            return response()->json(array('call_response' => "ko", 'lead_id' => null), 200);
        }

        /* Banneo de números de teléfono presentes en la lista negra. */
        if (isset($request->dataToSend['tel_usuario']) && isBannedPhone($this->formatTelephone($request->dataToSend['tel_usuario']))) {
           // $this->utilsController->registroDeErrores(4, 'Número «banneado»en función ajaxApiNaturgyByHorizon()', 'Número: *' . $this->formatTelephone($request->dataToSend['tel_usuario']) . "*", null, decideCountry());
            return response()->json(array('call_response' => "ko", 'lead_id' => null), 200);
        }

        $return = "ko";
        $response = null;
        $lead_id = null;

        if ($request->ajax()) {
            $lead_id = $this->leadRegister($request);
            if ($lead_id !== "energia_not_registered") {
                $api_url = "https://jofnmyz3vrioxpt3r6w3d7lvty0fljih.lambda-url.eu-west-3.on.aws/kolondoo/lead"; /* Producción */
                $object = array(
                    "phone" => $this->formatTelephone($request->dataToSend['tel_usuario']),
                );

                try {
                    //'Authorization' => 'Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzaXRlIjo1LCJ0ZXN0IjoxfQ.H9gfdabZs7zW0JeIGKb2Qo4OlVJ3ZyubXCccruHJxG4', //Desarrollo y pruebas
                    $response = Http::withHeaders([
                        'Content-Type' => 'application/json',
                        'Accept' => 'application/json',
                        'Authorization' => 'Bearer eyJhbGciOiJIUzI1NiJ9.eyJzaXRlIjo1LCJjb21wIjo1LCJjYW1wIjoiOTAxMDEwMDAyIn0.10l5l27SWZtpWzPuRUd28Trk4wKXHKg6Lvvvd1RzsIs', //Producción
                    ])->acceptJson()
                        ->timeout(20)
                        ->post($api_url, $object);

                    if (!empty($response) && $response->successful() && !empty($response->body())) {
                        $body_decoded = json_decode($response->body());

                        if (isset($body_decoded->status) && $body_decoded->status) {
                            $return = "ok";
                           // $this->utilsController->registroDeErrores(1, 'ajaxApiNaturgyByHorizon', $response->body());
                        } else {
                            $return = "ko";
                            $message = "Fallo de API ajaxApiNaturgyByHorizon responde KO. Enviado a la API: " . json_encode($object) . ", Respuesta del WS Horizon: " . $response->body();
                           // $this->utilsController->registroDeErrores(10, 'ajaxApiNaturgyByHorizon', $message);
                        }
                    } else {
                        $message = "Fallo de API ajaxApiNaturgyByHorizon responde KO. Objeto de respuesta id null o no existe respuesta. Enviado a la API: " . json_encode($object);
                       // $this->utilsController->registroDeErrores(10, 'ajaxApiNaturgyByHorizon', $message);
                    }
                } catch (ConnectionException $e) {
                    $message = "Fallo de API ajaxApiNaturgyByHorizon catch capturado - ERROR: " . $e->getMessage() . ", LINE: " . $e->getLine();
                   // $this->utilsController->registroDeErrores(3, 'ajaxApiNaturgyByHorizon', $message);
                }
            }
        } else {
           // $this->utilsController->registroDeErrores(4, 'ajaxApiNaturgyByHorizon', "Fallo de API ajaxApiNaturgyByHorizon llamada NO Ajax. Se bloquea el acceso.");
        }

        return response()->json(array('call_response' => $return, 'lead_id' => $lead_id), 200);
    }

    public function ajaxApiV3(Request $request)
    {
        $call_response = "ko";
        $lead_id = null;
        $visitorIp = $this->visitorIp;
        if ($request->ajax()) {
            try {
                $response = null;
                $phone = $this->utilsController->formatTelephone($request->dataToSend['tel_usuario']);
                $base_api_url = "https://hooks.zapier.com/hooks/catch/13049102/bpkbypb/";
                $lead_id = $this->leadRegister($request);

                $obj = array(
                    'telefono' => $phone,
                    'interes' =>  str_replace("ENERGIA_", "", !empty($request->dataToSend['producto']) ? $request->dataToSend['producto'] : "N/D"),
                    'source' =>  "Kolondoo",
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
                    $call_response = "ok";
                   // $this->utilsController->registroDeErrores(1, 'ajaxApiV3', $response . "[****]" . json_encode($obj));
                } else {
                    $call_response = "ko";
                    $message = "Fallo de API ajaxApiV3 responde KO. Enviado a la API: " . json_encode($obj) . ", Respuesta del WS ajaxApiV3: " . $response;
                   // $this->utilsController->registroDeErrores(10, 'ajaxApiV3', $message);
                }
            } catch (ConnectionException $e) {
                $fallo_envio_lead = true;
                $message = "Fallo de IpAPI ajaxApiV3 falla al enviar el «lead» desde IP: " . $visitorIp . ' -> ERROR: ' . $e->getMessage();
               // $this->utilsController->registroDeErrores(10, 'ajaxApiV3', $message);
            }
        }

        return response()->json(array('call_response' => $call_response, 'lead_id' => $lead_id), 200);
    }

    public function ajaxApiTelcoCPAZapierCpl(Request $request)
    {
        $return = "ko";
        $response = null;
        $visitorIp = $this->visitorIp;
        $lead_id = $this->leadRegister($request);
        $base_api_url = "https://ws.walmeric.com/provision/wsclient/client_addlead.html";
        $phone = $this->utilsController->formatTelephone($request->dataToSend['tel_usuario']);

        $obj = array(
            'format' => 'json',
            'idTag' => '29842f94d414949bf95fb2e6109142cfef1fb2a78114c2c536a36bf5a65b953a2724c2690797eda45de829716997a7ab87bee86aa84414bce8ebd6ca62bdbf093b09fbcdb928d3382a661f74609ff5c0e1a002941ebdbc14932342981ac48d58f4d749b0b5308246a6b0f8135759faee',
            'verifyLeadId' => 'NO',
            'idlead' => $lead_id,
            'telefono' => $phone,
        );

        $query_string = http_build_query($obj);
        $full_api_url = $base_api_url . '?' . $query_string;

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'charset' => 'utf-8'
            ])->acceptJson()
                ->timeout(20)
                ->get($full_api_url);
        } catch (ConnectionException $e) {
            $message = "Fallo de IpAPI ajaxApiLowiZapierCpl no responde - ERROR: " . $e->getMessage();
           // $this->utilsController->registroDeErrores(9, 'ApiLowiZapierCpl', $message);
        }

        $responseObj = json_decode($response);
        if ($responseObj->result === "OK") {
            $call_response = "ok";
           // $this->utilsController->registroDeErrores(1, 'ajaxApiLowiZapierCpl', $response . "[****]" . json_encode($obj));
        } else {
            $call_response = "ko";
            $message = "Fallo de API ajaxApiLowiZapierCpl responde KO. Enviado a la API: " . json_encode($obj) . ", URL Enviada: " . $full_api_url . ", Respuesta del WS ajaxApiLowi: " . $response;
           // $this->utilsController->registroDeErrores(10, 'ajaxApiLowi', $message);
        }

        return response()->json(array('call_response' => $return, 'lead_id' => $lead_id), 200);
    }

    public function ajaxApiAlternaTelcoZapierCpl(Request $request)
    {
        $call_response = "ko";
        $lead_id = null;
        $visitorIp = $this->visitorIp;
        try {
            $response = null;
            $phone = str_replace($request->tlf_movil, '+34', '');
            $customer_name = $request->dataToSend['nombre_usuario'];
            $base_api_url = "https://app.whatconverts.com/api/v1/leads/";

            $lead_id = $this->leadRegister($request);
            //Basic Auth:  user => pass; '4273-1dc57737c98d47b7' => 'aa1a2e99df72fdd82ab7045f8d9fa6ad'
            $obj = array(
                'profile_id' => '97488',
                'send_notification' => 'false',
                'lead_type' => 'web_form',
                'lead_source' => 'kolondoo',
                'lead_medium' => 'affiliate',
                'lead_campaign' => 'telco_kolondoo_comparador_pros',
                'additional_fields[Phone Number]' => $phone,
                'phone_number' => $phone,
                //'additional_fields[Contact_name]' => $customer_name,
                'ip_address' => $visitorIp
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

            if ($request->dataToSend['company'] == 20) {
                $leadValidation = Lead::find($lead_id);
                $leadValidation->idResponse = $responseObj->lead_id;
                $leadValidation->save();
            }

            if (isset($responseObj->lead_id) && !empty($responseObj->lead_id)) {
                $call_response = "ok";
            } else {
                $call_response = "ko";
                $message = "Fallo de API Whatconverts responde KO. Enviado a la API: " . json_encode($obj) . ", Respuesta del WS ajaxApiAlternaTelcoZapierCpl: " . $response;
               // $this->utilsController->registroDeErrores(10, 'ajaxApiAlternaTelcoZapierCpl', $message);
            }
        } catch (ConnectionException $e) {
            $fallo_envio_lead = true;
            $message = "Fallo de IpAPI ajaxApiAlternaTelcoZapierCpl falla al enviar el «lead» desde IP: " . $visitorIp . ' -> ERROR: ' . $e->getMessage();
        }

        return response()->json(array('call_response' => $call_response, 'lead_id' => $lead_id), 200);
    }

    private function audienceTalkingOfflineLeadCommunication(string $event, string $type, string $phone, string $atcat, string $atkey, string $source, string $medium)
    {
        $phone = $this->utilsController->formatTelephone($phone);
        $api_url = "";
        $data = [
            'event' => $event,
            'type' => $type,
            'displayPhone' => '',
            'callerId' => $phone,
            'source' => $source,
            'medium' => $medium
        ];

        return $data;

        //Si las variables de data son todas «n/d» no hace falta mandarlas.
        $semaphore = false;
        foreach (array('atcat', 'atkey') as $item) {
            if (Str::lower($$item) !== "n/d") {
                $semaphore = true;
            }
        }

        if ($semaphore) {
            $data['data'] = [
                'atcat' => $atcat,
                'atkey' => $atkey
            ];
        }

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'charset' => 'utf-8'
            ])->acceptJson()
                ->timeout(20)
                ->post($api_url, $data);
        } catch (ConnectionException $e) {
            $message = "Fallo de  función audienceTalkingOfflineLeadCommunication() - ERROR: " . $e->getMessage();
            //$this->utilsController->registroDeErrores(9, 'Audience Talking Communication Error', $message);
        }

        if (!empty($response) && $response->successful() && !empty($response->body())) {
            //createFileLog('local', 'audienceOffline', Carbon::now()->format("Y-m-d H:i:s) ").$response->body().", Objeto enviado: ".json_encode($data, JSON_UNESCAPED_UNICODE));
        } else {
            //$this->utilsController->registroDeErrores(10, 'Audience Talking Communication Error', "Fallo de  función audienceTalkingOfflineLeadCommunication() objeto HTTP response vacío");
        }
    }
}

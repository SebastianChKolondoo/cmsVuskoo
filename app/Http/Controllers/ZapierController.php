<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lead;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Carbon\Carbon;
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

    public function leadRegister($request)
    {
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
            'acepta_politica_privacidad_kolondoo' => $request->dataToSend['acepta_politica_privacidad_kolondoo'],
            'acepta_cesion_datos_a_proveedor' => $request->dataToSend['acepta_cesion_datos_a_proveedor'],
            'acepta_comunicaciones_comerciales_kolondoo' => $request->dataToSend['acepta_comunicaciones_comerciales_kolondoo'],
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
                    "compania" => $instance->nombre,
                    "tipo_formulario" => "c2c",
                    'acepta_politica_privacidad_kolondoo' => 1,
                    'acepta_cesion_datos_a_proveedor' => 1,
                    'acepta_comunicaciones_comerciales_kolondoo' => 1
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
                //$this->utilsController->registroDeErrores(4, 'facebookZapierCpl', "Se intenta acceder a la función sin identificador de compañía válido o a función no permitida. id de compañía solicitada: *".$company."*. Datos recibidos del formulario: ".json_encode(array('tlf_movil' => $tlf_movil,'email' => $email,'nombre' => $nombre,'compania' => $company)), JSON_UNESCAPED_UNICODE);
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
            $this->utilsController->registroDeErrores(9, 'ajaxApiVodafoneZapierCpl', $message);
        }
        //Control respuesta API
        if (!empty($response) && !empty($response->body())) {
            $result = json_decode($response->body());
            $return = Str::lower($result->result);
            if ($response->successful()) {
                $lead_id = $this->leadRegister($request);
            } else {
                $this->utilsController->registroDeErrores(10, 'ajaxApiVodafoneZapierCpl', "Fallo de IpAPI ajaxApiVodafoneZapierCpl responde: " . $result->message);
            }
        } else {
            $this->utilsController->registroDeErrores(10, 'ajaxApiVodafoneZapierCpl', "Fallo de IpAPI ajaxApiVodafoneZapierCpl objeto HTTP response vacío");
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
            
            /* Banneo de números de teléfono presentes en la lista negra. */
            /* if (empty($tlf_movil) || isBannedPhone($tlf_movil)) {
                $this->utilsController->registroDeErrores(4, 'Número «banneado» o vacío en función redesSocialesZapier()/' . $red_social, 'Número: *' . $tlf_movil . "*", null, decideCountry());
                return response()->json(array('status' => "ko"), 200);
            } */

            //Guardamos el «lead»
            $user_id = null;
            if (DB::table('usuarios')->where('tlf_movil', $tlf_movil)->exists()) {
                $user_id = DB::table('usuarios')->where('tlf_movil', $tlf_movil)->pluck('id')->first();
                //Actualizamos el usuario con la aceptación de comunicaciones comerciales al venir implícito por formulario de «Facebook»
                DB::table('usuarios')->where('id', $user_id)->update(array('email' => $email, 'nombre' => $nombre, 'acepta_comunicaciones_comerciales' => true, 'fecha_aceptacion_comunicaciones_comerciales' => Carbon::now()->format("Y-m-d H:i:s")));
            } else {
                $user_id = DB::table('usuarios')->insertGetId(array('tlf_movil' => $tlf_movil, 'email' => $email, 'nombre' => $nombre, 'acepta_comunicaciones_comerciales' => true, 'fecha_aceptacion_comunicaciones_comerciales' => Carbon::now()->format("Y-m-d H:i:s")));
            }
            $lead_data = array(
                'producto' => Str::upper($red_social),
                'usuario_id' => $user_id,
                'tipo_conversion' => 'cpa',
                'tarifa' => 'n/d',
                'compania' => 'n/d',
                'tipo_formulario' => 'c2c',
                'acepta_politica_privacidad_kolondoo' => 1,
                'acepta_cesion_datos_a_proveedor' => 1
            );
            $lead_id = DB::table('telco')->insertGetId($lead_data);

            if (is_int($lead_id)) {
                $dataToSend = $this->encryptDataToCallCenter(json_encode(array(
                    'lead_id' => $lead_id,
                    'prioridad' => $request->prioridad,
                    'tlf_movil' => $tlf_movil,
                    'email' => $email,
                    'nombre' => $nombre,
                    'origen' => $red_social,
                    'formulario' => "c2c"
                ), JSON_UNESCAPED_UNICODE), "encrypt");

                //Comunicamos llamada al «call center»
                $response = Http::withHeaders([
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                    'charset' => 'utf-8'
                ])->acceptJson()
                    ->timeout(20)
                    ->post($api_url, array('Authorization' => $dataToSend));

                if (!empty($response) && $response->successful()) {
                    $mask = "fblead";
                    switch ($red_social) {
                        case "tiktok":
                            $mask = "tklead";
                            break;
                    }

                    // DADO DE BAJA $this->audienceTalkingOfflineLeadCommunication($mask, 'c2c', $tlf_movil, 'TELCO', 'multiskill', $red_social,'social');
                    $result = "ok";
                } else {
                    $this->utilsController->registroDeErrores(9, 'redesSocialesZapier()/' . $red_social, 'Llamada al «call center» resultó errónea. Datos registro: ' . json_encode($lead_data, JSON_UNESCAPED_UNICODE));
                }
            }
        } catch (ConnectionException | \PDOException | \Exception $e) {
            $message = "Fallo en  redesSocialesZapier()/'.$red_social'. ERROR capturado en catch: " . $e->getMessage();
            $this->utilsController->registroDeErrores(3, 'redesSocialesZapier()/' . $red_social, $message);
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
            $this->utilsController->registroDeErrores(10, 'redesSocialesEnergyZapier', "Parámetro tlf_movil no cumple con el estándar: *" . $tel_usuario . "*");
            return response()->json(array('call_response' => 'ko', 'message' => 'Teléfono erróneo.'), 200);
        }

        /* Banneo de números de teléfono presentes en la lista negra. */
        if (isBannedPhone($tel_usuario)) {
            $this->utilsController->registroDeErrores(4, 'Número «banneado» en función redesSocialesEnergyZapier()', 'Número: *' . $tel_usuario . "*", null, decideCountry());
            return response()->json(array('call_response' => "ko", 'message' => 'Número de teléfono «banneado»'), 200);
        }

        if ($request->user !== env("USER_ENERGY_RRSS_ACCESS") && $request->pass !== env("PASS_ENERGY_RRSS_ACCESS")) //Acceso para redes sociales desde Zapier
        {
            $this->utilsController->registroDeErrores(5, 'Intento de acceso no permitido', 'Se bloquea acceso a función redesSocialesEnergyZapier() protegida con usuario y contraseña. Post: ' . json_encode($request->post()) . ", User Auth: " . $request->getUser() . ", Pass Auth: " . $request->getPassword());
            exit();
        }

        /* Control de parámetros de entrada y salida */
        $response = null;
        $company_control_fails = true;
        $politica_privacidad_fails = true;
        $lead_type_is_cpa = null;
        $company = connexionDB('master')->table('1_comercializadoras')->where('id', $request->company)->pluck('nombre')->first();
        $tipo_conversion = null;

        switch ($company) {
                //Clientes cpl
            case "Repsol":
            case "Holaluz":
            case "Lucera":
            case "Alterna":
            case "PepeEnergy":
            case "LuzDosTres":
            case "Naturgy By":
            case "Plenitude":
                $company_control_fails = false;
                $tipo_conversion = "cpl";
                $lead_type_is_cpa = false;
                $politica_privacidad_fails = (intval($request->acepta_cesion_datos_a_proveedor) !== 1) ? 1 : 0;
                break;

                //Clientes cpa
            case "Iberdrola":
            case "Endesa":
            case "Naturgy":
            case "Sweno":
            case "Wombbat":
            case "Gana Energía":
                $company_control_fails = false;
                $tipo_conversion = "cpa";
                $lead_type_is_cpa = true;
                $politica_privacidad_fails = (intval($request->acepta_politica_privacidad_kolondoo) !== 1) ? 1 : 0;
                break;
        }

        if ($company_control_fails) {
            $this->utilsController->registroDeErrores(13, 'redesSocialesEnergyZapier', "Parámetro recibido «compania» no contemplado. Llamada recibida:  *" . json_encode($request->post()) . "*");
            return response()->json(array('call_response' => 'ko', 'message' => "El parámetro «compania» debe ser uno de los siguientes: Repsol, Holaluz, Lucera, Alterna, PepeEnergy, LuzDosTres, Iberdrola, Endesa, Naturgy, Sweno, Wombbat, Gana Energía o Naturgy By. Se ha recibido: {company_id: " . ($request->company) . "}"), 200);
        } elseif ($politica_privacidad_fails) {
            $this->utilsController->registroDeErrores(13,  'redesSocialesEnergyZapier', "Política de privacidad no aceptada correctamente redesSocialesEnergyZapier(). Llamada recibida:  *" . json_encode($request->post()) . "*");
            return response()->json(array('call_response' => "ko", 'message' => "Debe incluir el campo «" . ($lead_type_is_cpa ? "acepta_politica_privacidad_kolondoo" : "acepta_cesion_datos_a_proveedor") . "» con valor numérico: 1"), 200);
        }

        //Construimos objeto
        //Para pasar la barrera $request->ajax()
        $request->headers->add(array('X-Requested-With' => 'XMLHttpRequest'));
        $request->dataToSend = array(
            'tel_usuario' => $tel_usuario,
            'is_mobile' => (in_array(Str::substr($tel_usuario, 0, 1), array(8, 9), true)) ? 0 : 1,
            'tarifa' => empty($request->tarifa) ? "N/D" : $request->tarifa,
            'tipo_formulario' => 'c2c',
            'origen' => $request->rrss_origin,
            'compania' => $company,
            'acepta_comunicaciones_comerciales_kolondoo' => 1,
            'producto' =>  $request->rrss_origin,
            'tipo_conversion' => $tipo_conversion,
            'precio' => empty($request->precio) ? null : $request->precio,
            'direccion_usuario' => $request->direccion_usuario ?? null,
            'poblacion_usuario' => $request->poblacion_usuario ?? null,
            'provincia_usuario' => $request->provincia_usuario ?? null,
            'cp_usuario' => $request->cp_usuario ?? null,
            'nombre_usuario' => $request->nombre_usuario ?? null,
            'email' => $request->email ?? null
        );
        $request->utm_source = Str::lower($request->rrss_origin);

        switch ($company) {
            case "Iberdrola":
            case "Endesa":
            case "Naturgy":
            case "Sweno":
            case "Wombbat":
            case "Gana Energía":
                $request->dataToSend['acepta_politica_privacidad_kolondoo'] = (intval($request->acepta_politica_privacidad_kolondoo) === 1) ? 1 : 0;
                $response = $this->ajaxApiEnergiaCPA($request);
                break;
            case "Repsol":
                $request->dataToSend['acepta_cesion_datos_a_proveedor'] = (intval($request->acepta_cesion_datos_a_proveedor) === 1) ? 1 : 0;
                $response = $this->ajaxApiRepsol($request);
                break;
            case "Alterna":
                $request->dataToSend['acepta_cesion_datos_a_proveedor'] = (intval($request->acepta_cesion_datos_a_proveedor) === 1) ? 1 : 0;
                $response = $this->ajaxApiAlternaEnergy($request);
                break;
            case "HolaLuz":
                $request->dataToSend['acepta_cesion_datos_a_proveedor'] = (intval($request->acepta_cesion_datos_a_proveedor) === 1) ? 1 : 0;
                $response = $this->ajaxApiHolaluz($request);
                break;
            case "PepeEnergy":
                $request->dataToSend['acepta_cesion_datos_a_proveedor'] = (intval($request->acepta_cesion_datos_a_proveedor) === 1) ? 1 : 0;
                $request->rrss_energia = 'ENERGIA';
                $response = $this->ajaxApiPepephone($request);
                break;
            case "Naturgy By":
                $request->dataToSend['acepta_cesion_datos_a_proveedor'] = (intval($request->acepta_cesion_datos_a_proveedor) === 1) ? 1 : 0;
                $response = $this->ajaxApiNaturgyByHorizon($request);
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
            $this->utilsController->registroDeErrores(13, 'redesSocialesEnergyZapier', "WS de la compañía: {" . $company . "}, no devolvió respuesta. Llamada recibida:  " . json_encode($request->post()));
        }

        return response()->json($response, 200);
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
            $this->utilsController->registroDeErrores(9, 'ApiLowiZapierCpl', $message);
        }

        $responseObj = json_decode($response);
        if ($responseObj->result === "OK") {
            $call_response = "ok";
            $this->utilsController->registroDeErrores(1, 'ajaxApiLowiZapierCpl', $response . "[****]" . json_encode($obj));
        } else {
            $call_response = "ko";
            $message = "Fallo de API ajaxApiLowiZapierCpl responde KO. Enviado a la API: " . json_encode($obj) . ", URL Enviada: " . $full_api_url . ", Respuesta del WS ajaxApiLowi: " . $response;
            $this->utilsController->registroDeErrores(10, 'ajaxApiLowi', $message);
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
                $this->utilsController->registroDeErrores(10, 'ajaxApiAlternaTelcoZapierCpl', $message);
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

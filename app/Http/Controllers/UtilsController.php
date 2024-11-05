<?php

namespace App\Http\Controllers;

use App\Models\Events;
use App\Models\NewsLetter;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class UtilsController extends Controller
{
    function formatTelephone($phone)
    {
        // Elimina espacios y el símbolo '+' si está presente
        $phone = str_replace([" ", "+"], "", $phone);

        // Si comienza con '0034' y tiene longitud 13, elimina los primeros 4 caracteres
        if (Str::startsWith($phone, "0034") && strlen($phone) === 13) {
            $phone = Str::substr($phone, 4);
        }
        // Si comienza con '34' y tiene longitud 11, elimina los primeros 2 caracteres
        elseif (Str::startsWith($phone, "34") && strlen($phone) === 11) {
            $phone = Str::substr($phone, 2);
        }

        return $phone;
    }

    function getEmailConfirmation($token)
    {
        $count = NewsLetter::where('token', $token)->where('verificacion_email', 2)->count();

        if ($count == 1) {
            $data = NewsLetter::where('token', $token)->where('verificacion_email', 2)->first();
            $data->verificacion_email = 1;
            $data->token = true;
            $data->fecha_verificacion_email = now();
            $data->save();
            return ['status' => 'ok', 'message' => 'Usuario registrado con exito', 'code' => 201];
        } else {
            return ['status' => 'ko', 'message' => 'Usuario no registrado con exito', 'code' => 501];
        }
    }


    //Para evitar entrar en bucle en funciones y no saturar/consumir las llamadas a IpAPI, tenemos los parámetros $country_code (recogido a partir de checkingGuestLocationApi()) y $decideCountry (que viene de la función homologa) recibidos en la función cuando se quieran registrar. En cualquier caso, guarda laIP.
    /**
     * Función de registro eventos
     *
     * @param int $tipo
     * @param string $origen
     * @param string $mensaje
     * @param string|null $country_code
     * @param string|null $decideCountry
     * @return void
     */
    function registroDeErrores(int $tipo, string $origen, string $mensaje, string|null $country_code = null, string|null $decideCountry = null): void
    {
        $data = DB::table('events')->insert(
            array(
                'event_type' => $tipo,
                'source' => $origen,
                'message' => $mensaje,
                'country_code' => $country_code,
                'instance' => $decideCountry,
                'route' =>  !empty($_SERVER["REQUEST_URI"]) ? (url('/') . $_SERVER["REQUEST_URI"]) : null,
                'calling_IP' => $this->obtencionIpRealVisitante()
            )
        );
    }

    /*  */
    function addError(Request $request)
    {
        Events::create([
            'event_type' => $request->event_type,
            'source' => $request->source,
            'message' => $request->message,
            'country_code' => $request->country_code,
            'instance' => $request->instance,
            'route' => $request->route,
            'calling_IP' => $request->calling_IP
        ]);

        return response()->json([
            'message' => 'Incidencia reportada con exito',
            'status' => 201
        ], 200);
    }

    /**
     * Obtencion de la IP REAL del visitante
     *
     * @return string
     */
    function obtencionIpRealVisitante(): string
    {
        $return = null;

        $headers = [
            "HTTP_CLIENT_IP",
            "HTTP_X_FORWARDED_FOR",
            "HTTP_X_FORWARDED",
            "HTTP_FORWARDED_FOR",
            "HTTP_FORWARDED",
            "REMOTE_ADDR"
        ];

        foreach ($headers as $header) {
            if (isset($_SERVER[$header])) {
                $return = $_SERVER[$header];
                break;
            }
        }

        if ($return === null) {
            $return = "no registrado";
        }

        return $return;
    }


    /**
     * Obtención de los datos por IPAPI
     *
     * @param bool $just_country_code
     * @return mixed
     */
    /* IPAPI  Devuelve null, código de país en minúsculas o objeto */
    function checkingGuestLocationApi(bool $just_country_code = null, $ip = null): mixed
    {
        $visitorIp = empty($ip) ? $this->obtencionIpRealVisitante() : $ip;
        $visitorIp = "181.53.96.39";
        $ipapi_url = "https://api.ipapi.com/api/$visitorIp?";
        $ipapi_key = "213e41b9b546cb54f68186a1d2b6b394";
        $response = null;

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'charset' => 'utf-8'
            ])->acceptJson()
                ->timeout(10)
                ->get(
                    $ipapi_url,
                    [
                        'access_key' => $ipapi_key,
                        'language' => null,
                        'output' => 'json',
                    ]
                );

            //$this->registroDeErrores(15, 'IpAPI', 'Conexion exitosa');
        } catch (ConnectionException $e) {
            $message = "Fallo de IpAPI no responde. - ERROR: " . $e->getMessage();
            //$this->registroDeErrores(6, 'IpAPI', $message);
            return null;
        }

        if (!empty($response) && $response->successful()) {
            $return = json_decode($response->body());
            if (isset($return->country_code) && is_string($return->country_code)) {
                if ($just_country_code) {
                    return Str::lower($return->country_code);
                } else {
                    return $return;
                }
            } else {
                $message = "Fallo IPAPI, responde con mensaje de ERROR: ";
                if (!empty($return->error->code) && !empty($return->error->info)) {
                    $message .= ": " . $return->error->code . " -> " . $return->error->info;
                } else {
                    $message .= " SIN INFO";
                }
                //$this->registroDeErrores(6, 'IpAPI', $message);
                return null;
            }
        } else {
            $message = "Fallo de IpAPI objeto vacío - Objeto response: " . json_encode($response) . ", Objeto enviado: " . json_encode(['access_key' => $ipapi_key, 'language' => null, 'output' => 'json', 'fields' => 'ip,type,continent_code,continent_name,country_code,country_name,region_name,city,zip,latitude,longitude']);
            //$this->registroDeErrores(6, 'IpAPI', $message);
            return null;
        }
    }

    /**
     * Comprueba si el telefono está en la lista negra
     *
     * @param string $phone
     */
    function isBannedPhone(mixed $phone): bool
    {
        return DB::connection('common_event_log')->table('banned_phones')->where('phone', preg_replace('/\s+/', '', $phone))->exists();
    }

    function quitarTildes($cadena)
    {
        $buscar = array('Á', 'É', 'Í', 'Ó', 'Ú', 'á', 'é', 'í', 'ó', 'ú');
        $reemplazar = array('A', 'E', 'I', 'O', 'U', 'a', 'e', 'i', 'o', 'u');
        $resultado = str_replace($buscar, $reemplazar, $cadena);
        return $resultado;
    }

    /* public static function EmailNewsletter($mail)
    {
        // URL de la API
        $url = 'https://hapi.crm-hermes.com/api/Notification/SendEmails';

        // Token para autenticación
        $token = 'a8086d4d-1313-4286-8fb3-424ceafd2c29';
        $idruta = 126;
        $emailList = ["dmalagon@arkeero.com", "netadv@outlook.es", $mail];
        $htmlContent = '<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Confirmación de suscripción a vuskoo.com</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"></head><body style="background-color: #f4f4f4;"><div class="container my-5"><div class="row justify-content-center"><div class="col-12 col-md-8"><div class="card shadow-lg"><div class="card-header text-center bg-white"><img src="https://www.vuskoo.com/img/logos/logo.svg" alt="Vuskoo" class="img-fluid" style="max-width: 150px;"></div><div class="card-body text-center"><h1 class="card-title">¡Gracias por suscribirte!</h1><p class="card-text">Hola,</p><p class="card-text">Estamos encantados de que te hayas suscrito a nuestro boletín de noticias. A partir de ahora, recibirás nuestras actualizaciones y las últimas novedades directamente en tu bandeja de entrada.</p></div><div class="card-footer text-center bg-light"><p class="mb-0">Si no realizaste esta solicitud, puedes ignorar este correo.</p><p class="text-muted mb-0">© 2024 Vuskoo. Todos los derechos reservados.</p></div></div></div></div></div><script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script></body></html>';
        $subject = 'Confirmación a newsLetter';
        $fromName = 'Confirmación a newsLetter';
        $presender = 'notification';

        // Cuerpo de la solicitud
        $body = [
            'token' => $token,
            'idruta' => $idruta,
            'emailList' => $emailList,
            'html' => $htmlContent,
            'asunto' => $subject,
            'fromname' => $fromName,
            'presender' => $presender
        ];

        // Envío de la solicitud POST
        $response = Http::post($url, $body);

        // Manejo de la respuesta
        if ($response->successful()) {
            return $response->json(); // Respuesta exitosa
        } else {
            return [
                'error' => true,
                'message' => 'Error al enviar el correo electrónico',
                'status_code' => $response->status()
            ];
        }
    } */

    public static function EmailNewsletter($mail, $token_email)
    {
        // URL de la API
        $url = 'https://hapi.crm-hermes.com/api/Notification/SendEmails';

        // Token para autenticación
        $token = 'a8086d4d-1313-4286-8fb3-424ceafd2c29';
        $idruta = 126;
        $emailList = ["dmalagon@arkeero.com", "netadv@outlook.es", $mail];

        // HTML con estilos en línea
        $htmlContent = '<!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Verificación de Cuenta</title>
    </head>
    <body style="background-color: #f4f4f4; font-family: Arial, sans-serif; margin: 0; padding: 0;">
        <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
            <div style="background-color: #ffffff; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
                <div style="text-align: center; margin-bottom: 20px;">
                    <img src="https://www.vuskoo.com/img/logos/logo.svg" alt="Vuskoo" style="max-width: 150px;">
                </div>
                <h2 style="color: #333333; text-align: center;">¡Estás a un paso de suscribirte!</h2>
                <p style="color: #666666; text-align: center;">Antes de que puedas empezar a recibir nuestras actualizaciones y las últimas novedades directamente en tu bandeja de entrada, por favor verifica tu cuenta haciendo clic en el siguiente enlace:</p>
                <div style="text-align: center; margin-top: 30px;">
                    <a href="https://www.vuskoo.com/verificacion-de-cuenta/' . $token_email . '" style="background-color: #007bff; color: #ffffff; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block;">Verificar cuenta</a>
                </div>
            </div>
            <p style="text-align: center; color: #999999; margin-top: 20px;">Si no realizaste esta solicitud, puedes ignorar este correo.<br>© 2024 Vuskoo. Todos los derechos reservados.</p>
        </div>
    </body>
    </html>';

        $subject = 'Confirmación a newsLetter';
        $fromName = 'Confirmación a newsLetter';
        $presender = 'notification';

        // Cuerpo de la solicitud
        $body = [
            'token' => $token,
            'idruta' => $idruta,
            'emailList' => $emailList,
            'html' => $htmlContent,
            'asunto' => $subject,
            'fromname' => $fromName,
            'presender' => $presender
        ];

        // Envío de la solicitud POST
        $response = Http::post($url, $body);

        // Manejo de la respuesta
        if ($response->successful()) {
            return $response->json(); // Respuesta exitosa
        } else {
            return [
                'error' => true,
                'message' => 'Error al enviar el correo electrónico',
                'status_code' => $response->status()
            ];
        }
    }
}

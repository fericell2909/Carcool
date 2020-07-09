<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if ($this->isHttpException($exception)) {
            switch ($exception->getStatusCode()) {
    
                // No Authorizado
                case '403':
                     
                     $response =  $this->response(false, 'Error : ' . $exception->getStatusCode(), 'No Authorizado' , []);
                     return response()->json($response, 403);
                     break;

                // No Encontrada la Url
                case '404':
                    $response =  $this->response(false, 'Error : ' . $exception->getStatusCode() , 'Url No Encontrado' , []);
                    return response()->json($response, 404);
                    break;
    
                // error 500
                case '500':
                    
                    $response = $this->response(false, 'Error : ' . $exception->getStatusCode() . ' ' .$exception->getMessage(), 'Error Interno del Servidor' , []);
                    return response()->json($response, 500);
                    break;
    
                default:
                    $response =  $this->response(false, 'Error : ' . $exception->getStatusCode(), $exception->getMessage() , []);
                    return response()->json($response, $exception->getStatusCode());
                    break;
            }
        } else {
            return parent::render($request, $exception);
        }
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'No Autenticado.'], 401);
        }

        return redirect()->guest('login');
    }

    protected function response($respuesta, $mensaje, $errores , $data)
    {

        return [
            'respuesta' => $respuesta,
            'mensaje' => $mensaje,
            'errores'  => Array('data' => $errores),
            'success' => Array('data' => $data)
        ];

    }


}

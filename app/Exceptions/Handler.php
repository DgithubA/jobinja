<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;


use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Js;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;
use App\Helpers;
class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {


        //$this->renderable([$this,'myrender']);
    }

    public static function myrender(Throwable $e,Request $request){
        if ($request->is('api/*')) {
            $message = $e->getMessage();
            if($e instanceof NotFoundHttpException) $message = 'Record not found.';
            if($e instanceof AuthenticationException) $message = $e->getMessage();
            return response()->json([
                'ok'=>false,
                'message' => $message,
            ], 404,options: Helpers\JSON_OPTIONS);
        }
    }
    /*public function render($request, Throwable $e){
        $parent = parent::render($request,$e);
        if ($request->is('api/*')) {
            if ($parent instanceof JsonResponse) {
                return response()->json([
                        'ok' => false,
                    ] + $parent->getData(true), $parent->getStatusCode(), options: Helpers\JSON_OPTIONS);
            }
        }
        return $parent;
    }*/

    private function handleApiException($request, \Throwable $exception){
        $exception = $this->prepareException($exception);

        if ($exception instanceof \Illuminate\Http\Exceptions\HttpResponseException) {
            $exception = $exception->getResponse();
        }

        if ($exception instanceof \Illuminate\Auth\AuthenticationException) {
            return $this->unauthenticated($request, $exception);
        }

        if($exception instanceof \Illuminate\Validation\ValidationException){
            return $this->convertValidationExceptionToResponse($exception, $request);
        }

        return $this->customApiResponse($exception);
    }


    private function customApiResponse($exception){
        if (method_exists($exception, 'getStatusCode')) {
            $statusCode = $exception->getStatusCode();
        } else {
            $statusCode = 500;
        }

        $response = [];

        switch ($statusCode) {
            case 401:
                $response['message'] = 'Unauthorized';
                break;
            case 403:
                $response['message'] = 'Forbidden';
                break;
            case 404:
                $response['message'] = 'Not Found';
                break;
            case 405:
                $response['message'] = 'Method Not Allowed';
                break;
            case 422:
                $response['message'] = $exception->original['message'];
                $response['errors'] = $exception->original['errors'];
                break;
            default:
                $response['message'] = ($statusCode == 500) ? 'Whoops, looks like something went wrong' : $exception->getMessage();
                break;
        }

        if (config('app.debug')) {
            $response['trace'] = $exception->getTrace();
            $response['code'] = $exception->getCode();
        }

        $response['status'] = $statusCode;

        return response()->json($response, $statusCode);
    }

}

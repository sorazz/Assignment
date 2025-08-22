<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable as Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\App;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\Mailer\Exception\TransportException;
use GuzzleHttp\Exception\ClientException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class Handler extends ExceptionHandler
{

    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    public function render($request, Exception $e)
    {

        //set language according to the content language else default
        $locale = $request->header('Content-Language');
        if (!$locale) {
            $locale = app()->getLocale();
        }
        App::setLocale($locale);
        //set error response related to token expiry
         if ($e instanceof ValidationException) {
            return response()->json(['success' => false, 'message' => $e->errors()], 413);
        } else if ($e instanceof AuthorizationException) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 403);
        } else if ($e instanceof UnauthorizedHttpException) {
            return response()->json([
                'success' => false,
                'message' => 'Token is invalid'
            ], $e->getStatusCode());
        } else if ($e instanceof \Error) {
            return response()->json(['success' => false, 'message' => trans('exceptions.exceptions')], 500);
        } else if ($e instanceof NotFoundHttpException) {
            return response()->json([
                'success' => false,
                'message' => "Data not found"
            ], 404);
        } else if ($e instanceof AccessDeniedHttpException) {
            return response()->json([
                'success' => false,
                'message' => trans('exceptions.unAuthorize')
            ], 403);
        } else if ($e instanceof TransportException) {
            return response()->json([
                'success' => false,
                'message' =>"Data not found"
            ], 404);
        } else if ($e instanceof ModelNotFoundException) {
            return response()->json([
                'success' => false,
                'message' => "Data not found"
            ], 404);
        } elseif ($e instanceof MethodNotAllowedHttpException) {
            return response()->json([
                'success' => false,
                'message' =>  trans('exceptions.Method_not_allow')
            ], 405);
        }
        return parent::render($request, $e);
    }
}

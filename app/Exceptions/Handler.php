<?php

namespace App\Exceptions;

use App\Shared\Exceptions\NotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

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
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e): JsonResponse|Response
    {
        if ($e instanceof MethodNotAllowedHttpException) {
            return response()->json('Invalid method', 405);
        }

        if ($e instanceof NotFoundHttpException) {
            return response()->json('Not Found', 404);
        }

        if ($e instanceof NotFoundException) {
            return response()->json($e->getMessage() ?: 'Not found', 404);
        }

        if ($e instanceof HttpException) {
            return response()->json($e->getMessage(), $e->getStatusCode());
        }

        if (config('app.debug')) {
            return parent::render($request, $e);
        }

        return response()->json('Unexpected Exception. Try later', 500);
    }
}

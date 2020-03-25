<?php

namespace App\Exceptions;

use Exception;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
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
     * @throws \Exception
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @throws \Exception
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function render($request, Exception $exception)
    {
        // handle exceptions code in json view(use expectsJson).
        if ($request->expectsJson()) {
            // handle 404, model not found. eg: employee not found
            if ($exception instanceof ModelNotFoundException) {
                return response()->json([
                    'error' => 'Model not found',
                    // 'error' => $exception->getMessage(),
                ], Response::HTTP_NOT_FOUND);
            }

            // handle 404, http not found. eg: wrong routes
            if ($exception instanceof NotFoundHttpException) {
                return response()->json([
                    'error' => 'Incorrect URI.',
                ], Response::HTTP_NOT_FOUND);
            }

            // handle 403, forbidden.
            if ($exception instanceof AccessDeniedHttpException) {
                return response()->json([
                    'error' => 'This action is unauthorized.',
                ], Response::HTTP_FORBIDDEN);
            }

            // handle 500. eg: server down
            if ($exception instanceof RequestException) {
                return response()->json([
                    'error' => 'External API call failed.',
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }

        return parent::render($request, $exception);
    }
}

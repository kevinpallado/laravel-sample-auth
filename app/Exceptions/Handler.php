<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
// web exceptions
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
// database exceptions
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
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
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
        
        $this->renderable(function (NotFoundHttpException $e, $request) {
            if($e instanceof NotFoundHttpException && $request->wantsJson()){ 
                return response()->json(['message' => 'Not Found!'], 404);
            }
            
            return response()->view('errors.404',[], 404);
        });

        $this->renderable(function (QueryException $e, $request) {
            if($e instanceof QueryException && $request->wantsJson()){ 
                return response()->json(['message' => 'Duplicate data found'], 422);
            }
            return response()->view('errors.404',[], 404);
        });

        $this->renderable(function (AccessDeniedHttpException $e, $request) {
            if($e instanceof AccessDeniedHttpException && $request->wantsJson()){ 
                return response()->json(['message' => $e->getMessage()], $e->getStatusCode());
            }
            return response()->view('errors.404',[], 404);
        });
    }
}

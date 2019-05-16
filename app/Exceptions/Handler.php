<?php

namespace App\Exceptions;

use App\Traits\ApiResponser;
use Asm89\Stack\CorsService;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    use ApiResponser;
    
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

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        $response = $this->handleException($request, $exception);

        // esto lo hacemos para las rutas que no existen
        app(CorsService::class)->addActualRequestHeaders($response, $request);

        return $response;
    }

    public function handleException($request, Exception $exception)
    {
        if($exception instanceof ValidationException) 
        {
            return $this->convertValidationExceptionToResponse($exception, $request);
        }

        if($exception instanceof AuthenticationException) 
        {
            return $this->unauthenticated($request, $exception);
        }

        if($exception instanceof ModelNotFoundException)
        {
            return $this->errorResponse('Does not exists instance with the specified id', 404);
        }

        if($exception instanceof NotFoundHttpException)
        {
            return $this->errorResponse('Does not exists any endpoint matching with that URL', $exception->getStatusCode());
        }

        if($exception instanceof MethodNotAllowedHttpException)
        {
            return $this->errorResponse('HTTP method does not match with any endpoint', $exception->getStatusCode());
        }

        if($exception instanceof HttpException)
        {
            $message = $exception->getMessage();
            $return = 'File: '.$exception->getFile().' Line:'. $exception->getLine();
            return $this->errorResponse($message ? $message : $return, $exception->getStatusCode());
        }

        if (config('app.debug')) {
            return parent::render($request, $exception);
        }

        return $this->errorResponse('Unexpected error', 500);
    }

    protected function convertValidationExceptionToResponse(ValidationException $e, $request)
    {
        $errors = $e->validator->errors()->getMessages();

        if($this->isFronted($request))
        {
            return $request->ajax() ? response()->json($errors, 422) : redirect()->back()->withInput($request->input())->withErrors($errors);
        }

        return $this->errorResponse($errors, 422);
    }

    /**
     * Convert an authentication exception into a response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($this->isFronted($request)) {
            return redirect()->guest(route('login'));
        }

        return $this->errorResponse('Unauthenticated', 401); 
    }

    public function isFronted($request)
    {
        return $request->acceptsHtml() && collect($request->route()->middleware())->contains('web');
    }
}

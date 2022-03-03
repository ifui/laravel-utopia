<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $e
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $e)
    {
        if (method_exists($e, 'render') && $response = $e->render($request)) {
            return Router::toResponse($request, $response);
        }

        if ($e instanceof Responsable) {
            return $e->toResponse($request);
        }

        $e = $this->prepareException($this->mapException($e));

        if ($response = $this->renderViaCallbacks($request, $e)) {
            return $response;
        }

        return match (true) {
            $e instanceof AuthenticationException => $this->unauthenticated($request, $e),
            $e instanceof AccessDeniedHttpException => $this->unauthenticated($request, $e),
            $e instanceof ValidationException => $this->convertValidationExceptionToResponse($e, $request),
            $e instanceof NotFoundHttpException => $this->notFoundHttp($request),
            default => $this->renderExceptionResponse($request, $e),
        };
    }

    /**
     * 重写登录状态失效时的返回信息格式
     *
     * @param \Illuminate\Http\Request  $request
     * @param UnauthorizedException $exception
     * @return void
     */
    protected function unauthenticated($request, $exception)
    {
        return error('code.10403', __($exception->getMessage()));
    }

    /**
     * 重写表单验证失败时的返回信息格式
     *
     * @param ValidationException $exception
     * @param [type] $request
     * @return void
     */
    public function convertValidationExceptionToResponse(ValidationException $exception, $request)
    {
        return error('code.10422', __($exception->getMessage()), $exception->validator->getMessageBag());
    }

    /**
     * 重写没有找到页面返回信息格式
     *
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function notFoundHttp(Request $request)
    {
        return error('code.10404', __('code.10404'), $request->url());
    }

    /**
     * 重写默认错误返回方式
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $e
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function renderExceptionResponse($request, Throwable $e)
    {
        $message = $e->getMessage() ? __($e->getMessage()) : __('code.10400');

        return error('code.10400', $message, $this->convertExceptionToArray($e));
    }
}

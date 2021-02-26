<?php

namespace App\Exceptions;

use App\Http\Controllers\Controller;
use Dingo\Api\Http\Request;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Lang;
use Illuminate\Validation\ValidationException;
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
        } elseif ($e instanceof Responsable) {
            return $e->toResponse($request);
        }

        $e = $this->prepareException($this->mapException($e));

        foreach ($this->renderCallbacks as $renderCallback) {
            if (is_a($e, $this->firstClosureParameterType($renderCallback))) {
                $response = $renderCallback($e, $request);

                if (!is_null($response)) {
                    return $response;
                }
            }
        }

        if ($e instanceof AuthorizationException || $e instanceof AuthenticationException) {
            return $this->unauthenticated($request, $e);
        } else if ($e instanceof ValidationException) {
            return $this->convertValidationExceptionToResponse($e, $request);
        } else if ($e instanceof NotFoundHttpException) {
            return $this->notFoundHttp($request);
        }

        return $this->prepareJsonResponse($request, $e);
    }

    /**
     * 重写无权限时的返回信息格式
     *
     * @param \Illuminate\Http\Request $request
     * @param AuthenticationException|AuthorizationException $exception
     * @return void
     */
    protected function unauthenticated($request, $exception)
    {
        return Controller::error(Lang::get('code.unauthenticated'), $exception->getMessage());
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
        return Controller::error(Lang::get('code.validation_invalid'), $exception->validator->getMessageBag());
    }

    /**
     * 重写没有找到页面返回信息格式
     *
     * @param Request $request
     * @return void
     */
    public function notFoundHttp(Request $request)
    {
        return Controller::error(Lang::get('Not Found'), $request->url());
    }

    /**
     * 重写 Prepare a JSON response for the given exception.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $e
     * @return \Illuminate\Http\JsonResponse
     */
    public function prepareJsonResponse($request, Throwable $e)
    {
        return Controller::error(Lang::get($e->getMessage()), $this->convertExceptionToArray($e));
    }
}

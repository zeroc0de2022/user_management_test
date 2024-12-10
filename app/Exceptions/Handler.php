<?php

namespace App\Exceptions;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = ['current_password',
                            'password',
                            'password_confirmation',];

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
     * @param Request $request
     * @param Throwable $exception
     * @return \Illuminate\Http\Response|JsonResponse|Response
     * @throws Throwable
     */
    public function render($request, Throwable $exception): \Illuminate\Http\Response|JsonResponse|Response
    {
        // Обработка ошибок валидации
        if($exception instanceof ValidationException && $request->expectsJson()) {
            return response()->json(['message' => 'Ошибка валидации',
                                     'errors'  => $exception->errors()], 422);
        }
        // Обработка ошибки "Модель не найдена"
        if($exception instanceof ModelNotFoundException && $request->expectsJson()) {
            return response()->json(['message' => 'Ресурс не найден'], 404);
        }
        // Обработка других ошибок
        if($request->expectsJson()) {
            return response()->json(['message' => 'Что-то пошло не так',
                                     'error'   => $exception->getMessage()], 500);
        }
        return parent::render($request, $exception);
    }
}

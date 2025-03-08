<?php

namespace App\Exceptions;

use App\Traits\JsonResponseTrait;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Throwable;

class Handler extends ExceptionHandler
{
    use JsonResponseTrait;
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
        $this->reportable(function (Throwable $e) {
            if (app()->environment('production') || app()->environment('staging')) {
                if (app()->bound('sentry')) {
                    app('sentry')->captureException($e);
                }
            }
        });
    }

    public function render($request, Exception|Throwable $exception)
    {
        if ($exception instanceof UnauthorizedException) {
            return $this->errorResponse(
                'شما اجازه دسترسی به این بخش را ندارید',
                403
            );
        }

        return parent::render($request, $exception);
    }
}

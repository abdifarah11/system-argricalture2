<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    protected $levels = [];

    protected $dontReport = [];

    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception)
    {
        if ($exception instanceof NotFoundHttpException) {
            return response()->view('errors.404', [], 404);
        }

        return parent::render($request, $exception);
    }
    public function update(Request $request, $userId)
{
    $user = auth()->user();           // The current logged-in user
    $targetUser = User::find($userId); // The user whose password is being changed

    // ❌ If target user is admin and current user is not admin → block
    if ($targetUser && $targetUser->role === 'admin' && $user->role !== 'admin') {
        return redirect()->route('dashboard')->with('error', 'You are not allowed to change an admin\'s password.');
    }

    // ✅ Proceed to update password
    $request->validate([
        'password' => 'required|string|min:8|confirmed',
    ]);

    $targetUser->password = bcrypt($request->password);
    $targetUser->save();

    return redirect()->route('dashboard')->with('success', 'Password updated successfully.');
}

}

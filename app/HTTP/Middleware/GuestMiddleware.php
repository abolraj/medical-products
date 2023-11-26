<?php
namespace Http\Middleware;
use Model\User;
use Pecee\Http\Middleware\IMiddleware;
use Pecee\Http\Request;

class GuestMiddleware implements IMiddleware
{
    public function handle(Request $request): void
    {

        // Authenticate user, will be available using request()->user
        $request->user = User::current_user();
        // If authentication failed, redirect request to user-login page.
        if ($request->user) {
            $request->setRewriteUrl(url('home'));
        }
    }
}

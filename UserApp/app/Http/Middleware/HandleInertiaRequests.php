<?php
namespace App\Http\Middleware;
use Illuminate\Http\Request;
use Inertia\Middleware;
class HandleInertiaRequests extends Middleware{

    protected $rootView = 'app';

    public function version(Request $request): ?string{
        return parent::version($request);
    }

    public function share(Request $request): array{
        return array_merge(parent::share($request), [
            'auth' => [
                'user' => fn () => $request->user() ? $request->user()->loadMissing('profile') : null,
            ],  // if a user is logged in then in frontend we can access the user and profile data using auth.user
            'flash' => [
                'success' => fn() => $request->session()->get('success'),
                'error' => fn() => $request->session()->get('error'),
            ],
        ]);
    }
}
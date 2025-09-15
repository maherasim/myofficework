<?php


	namespace Modules\User\Controllers\Auth;


	use Illuminate\Auth\Access\AuthorizationException;
	use Illuminate\Auth\Events\Verified;
	use Illuminate\Http\Request;

	class VerificationController extends \App\Http\Controllers\Auth\VerificationController
	{

		protected $redirectTo = '/user/profile';

		public function verify(Request $request)
		{
			if ($request->route('id') != $request->user()->getKey()) {
				throw new AuthorizationException;
			}

			if ($request->user()->hasVerifiedEmail()) {
				return redirect($this->redirectPath());
			}

			if ($request->user()->markEmailAsVerified()) {
				event(new Verified($request->user()));
				// Send Welcome email after activation
				try {
					$register_as = $request->user()->hasPermissionTo('dashboard_vendor_access') ? 'host' : 'guest';
					$request->user()->sendEmailWelcomeNotification($register_as);
				} catch (\Throwable $e) {
					// swallow to not block verification redirect
				}
			}

			return redirect($this->redirectPath())->with('verified', true);
		}

		public function resend(Request $request)
		{
			if ($request->user()->hasVerifiedEmail()) {
				return redirect($this->redirectPath());
			}

			try {
				$register_as = $request->user()->hasPermissionTo('dashboard_vendor_access') ? 'host' : 'guest';
				$request->user()->sendEmailUserVerificationNotification($register_as);
			} catch (\Throwable $e) {
				// ignore errors to maintain UX
			}

			return back()->with('resent', true);
		}

	}
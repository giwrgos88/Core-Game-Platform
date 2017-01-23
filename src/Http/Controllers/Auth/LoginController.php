<?php

namespace Giwrgos88\Game\Core\Http\Controllers\Auth;

use Giwrgos88\Game\Core\Http\Controllers\Controller;
use Giwrgos88\Game\Core\Models\Admin\Users;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller {
/*
|--------------------------------------------------------------------------
| Login Controller
|--------------------------------------------------------------------------
|
| This controller handles authenticating users for the application and
| redirecting them to your home screen. The controller uses a trait
| to conveniently provide its functionality to your applications.
|
 */
	use AuthenticatesUsers;

	/**
	 * Where to redirect users after login.
	 *
	 * @var string
	 */
	protected $redirectTo = '/';

	protected $redirectAfterLogout = '/';

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct() {
		$this->middleware('guest', ['except' => 'logout']);
	}

	public function showPasswordLoginForm() {
		return view('futsal::auth.login_password');
	}

	public function showLoginForm() {
		return view('core::auth.login.login');
	}

	protected function guard() {
		return Auth::guard('core_user');
	}

	protected function authenticated(Request $request, Users $user) {
		return redirect()->route('Core::admin.dashboard');
	}
}
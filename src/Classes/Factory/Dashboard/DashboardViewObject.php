<?php

namespace Giwrgos88\Game\Core\Classes\Factory\Dashboard;

use Auth;
use Giwrgos88\Game\Core\Models\Admin\Participants;
use Giwrgos88\Game\Core\Repositories\Interfaces\Factory\FactoryInterface as IFactory;

final class DashboardViewObject implements IFactory {
	/**
	 * @var Singleton
	 */
	private static $instance;

	/**
	 * gets the instance via lazy initialization (created on first usage)
	 */
	public static function getInstance(): DashboardViewObject {
		if (null === static::$instance) {
			static::$instance = new static();
		}

		return static::$instance;
	}

	/**
	 * is not allowed to call from outside to prevent from creating multiple instances,
	 * to use the singleton, you have to obtain the instance from Singleton::getInstance() instead
	 */
	private function __construct() {
	}

	/**
	 * prevent the instance from being cloned (which would create a second instance of it)
	 */
	private function __clone() {
	}

	/**
	 * prevent from being unserialized (which would create a second instance of it)
	 */
	private function __wakeup() {
	}

	public function get() {
		$this->all_participants = Participants::count();
		$this->new_participants = 0;
		$this->latest_participants = [];
		if (is_null(Auth::guard('core_user')->user()->last_login_at)) {
			$this->new_participants = Participants::count();
			$this->latest_participants = Participants::with('meta')->take(config('core_game.dashboard_latest_participants'))->get();
		} else {
			$this->new_participants = Participants::where('created_at', '>=', Auth::guard('core_user')->user()->last_login_at)->count();
			$this->latest_participants = Participants::with('meta')->where('created_at', '>=', Auth::guard('core_user')->user()->last_login_at)->take(config('core_game.dashboard_latest_participants'))->get();
		}

		return $this;
	}
}
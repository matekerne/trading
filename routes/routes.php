<?php

return array(
	// Winner 
	'winner/create' => 'Site\Winner/create',
	'winner/notify' => 'Site\Winner/notify',

	// Bet
	'bet/create' => 'Site\Bet/create',
	
	// Lot
	'lot/check-time-stop' => 'Site\Lot/check_time_stop',
	'lot/[0-9]+' => 'Site\Lot/show',
	'lot/change-status' => 'Site\Lot/change_status',

	/* Admin */

	// Lot
	'lot/delete' => 'Admin\Lot/delete',
	'lot/update' => 'Admin\Lot/update',
	'lot/edit/[0-9]+' => 'Admin\Lot/edit',
	'lot/create' => 'Admin\Lot/create',
	'lots' => 'Admin\Lot/index',

	// User
	'user/notify' => 'Admin\User/notify',
	'user/delete' => 'Admin\User/delete',
	'user/update' => 'Admin\User/update',
	'user/edit/[0-9]+' => 'Admin\User/edit',
	'user/create' => 'Admin\User/create',
	'users' => 'Admin\User/index',

	// Group
	'group/delete' => 'Admin\Group/delete',
	'group/update' => 'Admin\Group/update',
	'group/edit/[0-9]+' => 'Admin\Group/edit',
	'group/create' => 'Admin\Group/create',
	'groups' => 'Admin\Group/index',

	/* Admin */
	
	// Auth
	'login/user' => 'Auth\Auth/login',
	'logout' => 'Auth\Auth/logout',
	'login' => 'Auth\Auth/index',

	'' => 'Site\Home/index',
);
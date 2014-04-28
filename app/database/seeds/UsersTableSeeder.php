<?php

class UsersTableSeeder extends Seeder {

	public function run()
	{
		// Add Users

		// User::create([
		// 	'username' 	=> 'webmaster',
		// 	'email' 	=> 'webmaster@ag-aus.org',
		// 	'password' 	=> Hash::make('password'),
		// 	'confirmed' => 1
		// ]);

		// $user = new User;
		// $user->username = 'webmaster';
		// $user->email = '';
		// $user->password = ;
		// $user->confirmed = 1;
		// $user->save();

		$user = new User;

        $user->username = 'webmaster';
        $user->email = 'webmaster@ag-aus.org';
        $user->password = 'password';

        // The password confirmation will be removed from model
        // before saving. This field will be used in Ardent's
        // auto validation.
        $user->password_confirmation = 'password';
        $user->confirmed = 1;

        // Save if valid. Password field will be hashed before save
        $user->save();

		// Add Roles

		$owner = new Role;
		$owner->name = 'Owner';
		$owner->save();

		$admin = new Role;
		$admin->name = 'Administrator';
		$admin->save();

		$mod = new Role;
		$mod->name = 'Moderator';
		$mod->save();

		// Add Permissions

		$manageConfigs = new Permission;
		$manageConfigs->name = 'manage_configs';
		$manageConfigs->display_name = 'Manage Configs';
		$manageConfigs->save();

		$manageBans = new Permission;
		$manageBans->name = 'manage_bans';
		$manageBans->display_name = 'Manage Bans';
		$manageBans->save();

		$manageDonations = new Permission;
		$manageDonations->name = 'manage_donations';
		$manageDonations->display_name = 'Manage Donations';
		$manageDonations->save();

		$manageMaps = new Permission;
		$manageMaps->name = 'manage_maps';
		$manageMaps->display_name = 'Manage Maps';
		$manageMaps->save();

		$manageUsers = new Permission;
		$manageUsers->name = 'manage_users';
		$manageUsers->display_name = 'Manage Users';
		$manageUsers->save();

		// Add Permissions to Roles
		$owner->perms()->sync([
			$manageConfigs->id,
			$manageUsers->id,
			$manageMaps->id,
			$manageDonations->id,
			$manageBans->id
		]);

		$admin->perms()->sync([
			$manageConfigs->id,
			$manageMaps->id,
			$manageDonations->id,
			$manageBans->id
		]);

		$mod->perms()->sync([
			$manageConfigs->id,
			$manageMaps->id,
			$manageBans->id
		]);

		// $user = User::where('username','webmaster')->first();
		// $owner = \role::where('name', 'Owner')->get()->first();

		// // Add User to Role
		// //$user->roles()->attach( $owner->id );
		// $user->attachRole( $owner );
	}
}
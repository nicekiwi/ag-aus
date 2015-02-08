<?php

class UsersTableSeeder extends Seeder {

	public function run()
	{
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

		$viewOptions = new Permission;
		$viewOptions->name = 'options.view';
		$viewOptions->display_name = 'View Options';
		$viewOptions->save();

		$manageOptions = new Permission;
		$manageOptions->name = 'options.manage';
		$manageOptions->display_name = 'Manage Options';
		$manageOptions->save();

		$viewUsers = new Permission;
		$viewUsers->name = 'users.view';
		$viewUsers->display_name = 'View Users';
		$viewUsers->save();

		$manageUsers = new Permission;
		$manageUsers->name = 'users.manage';
		$manageUsers->display_name = 'Manage Users';
		$manageUsers->save();

		$manageReports = new Permission;
		$manageReports->name = 'reports.manage';
		$manageReports->display_name = 'Manage Reports';
		$manageReports->save();

		$viewDonations = new Permission;
		$viewDonations->name = 'donations.view';
		$viewDonations->display_name = 'View Donations';
		$viewDonations->save();

		$manageDonations = new Permission;
		$manageDonations->name = 'donations.manage';
		$manageDonations->display_name = 'Manage Donations';
		$manageDonations->save();

		$manageMaps = new Permission;
		$manageMaps->name = 'maps.manage';
		$manageMaps->display_name = 'Manage Maps';
		$manageMaps->save();

		$manageBans = new Permission;
		$manageBans->name = 'bans.manage';
		$manageBans->display_name = 'Manage Bans';
		$manageBans->save();


		// Add Permissions to Roles
		$owner->perms()->sync([

			$viewOptions->id,
			$viewUsers->id,
			$viewDonations->id,

			$manageReports->id,
			$manageOptions->id,
			$manageUsers->id,
			$manageDonations->id,
			$manageMaps->id,
			$manageBans->id
		]);

		$admin->perms()->sync([

			$viewOptions->id,
			$viewUsers->id,
			$viewDonations->id,

			$manageReports->id,
			$manageOptions->id,
			$manageDonations->id,
			$manageMaps->id,
			$manageBans->id
		]);

		$mod->perms()->sync([

			$viewOptions->id,
			$viewUsers->id,
			$viewDonations->id,

			$manageMaps->id,
			$manageBans->id
		]);

		// Add Users
		$user = new User;

        $user->username = 	'webmaster';
        $user->email = 		'webmaster@ag-aus.org';
        $user->password = 	'password';

        // The password confirmation will be removed from model
        // before saving. This field will be used in Ardent's
        // auto validation.
        $user->password_confirmation = $user->password;
        $user->confirmed = 1;

        // Save if valid. Password field will be hashed before save
        $user->save();

		/* role attach alias */
		$user->attachRole( $owner ); // Parameter can be an Role object, array or id.
	}
}
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

		$managePosts = new Permission;
		$managePosts->name = 'manage_posts';
		$managePosts->display_name = 'Manage Posts';
		$managePosts->save();

		$manageUsers = new Permission;
		$manageUsers->name = 'manage_users';
		$manageUsers->display_name = 'Manage Users';
		$manageUsers->save();

		$manageOptions = new Permission;
		$manageOptions->name = 'manage_options';
		$manageOptions->display_name = 'Manage Options';
		$manageOptions->save();

		$runJukebox = new Permission;
		$runJukebox->name = 'run_jukebox';
		$runJukebox->display_name = 'Run Jukebox';
		$runJukebox->save();

		$readVariables = new Permission;
		$readVariables->name = 'read_config_variable';
		$readVariables->display_name = 'Read Config Variables';
		$readVariables->save();

		$writeVariables = new Permission;
		$writeVariables->name = 'write_config_variable';
		$writeVariables->display_name = 'Write Config Variables';
		$writeVariables->save();

		// Add Permissions to Roles
		$owner->perms()->sync([
			$runJukebox->id,
			$manageOptions->id,
			$manageConfigs->id,
			$manageUsers->id,
			$manageMaps->id,
			$managePosts->id,
			$manageDonations->id,
			$manageBans->id,
			$writeVariables->id,
			$readVariables->id
		]);

		$admin->perms()->sync([
			$runJukebox->id,
			$manageConfigs->id,
			$manageMaps->id,
			$managePosts->id,
			$manageDonations->id,
			$manageBans->id,
			$readVariables->id
		]);

		$mod->perms()->sync([
			$runJukebox->id,
			$manageConfigs->id,
			$manageMaps->id,
			$manageBans->id,
			$readVariables->id
		]);

		// Add Users
		$user = new User;

        $user->username = 'webmaster';
        $user->email = 'webmaster@ag-aus.org';
        $user->password = 'password';

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
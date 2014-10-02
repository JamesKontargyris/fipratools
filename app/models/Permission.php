<?php

use Zizaco\Entrust\EntrustPermission;

class Permission extends EntrustPermission
{
	public static function getPermsForRole($role, $makePretty = false)
	{
		$found_role = '';

		if(is_string($role))
		{
			$found_role = Role::where('name', '=', $role)->first();
		}
		elseif(is_numeric($role))
		{
			$found_role = Role::find($role);
		}

		$perms = [];

		foreach($found_role->perms as $permission)
		{
			$perms[] = $permission->display_name;
		}

		return ($makePretty) ? pretty_text_list($perms) : $perms;
	}
}
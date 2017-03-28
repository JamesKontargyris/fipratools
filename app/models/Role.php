<?php

use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{
	public static function getRolesForFormSelect($blank_entry = false, $prefix = "")
	{
		$roles = [];
		//Remove whitespace from $prefix and add a space on the end, so there is a space
		//between the prefix and the unit name
		$prefix = trim($prefix) . ' ';

		if($blank_entry) $roles[''] = 'Please select...';

		foreach(Role::orderBy('name')->get() as $role)
		{
			$roles[$role->id] = $prefix . $role->name;
		}

		return $roles;
	}
}
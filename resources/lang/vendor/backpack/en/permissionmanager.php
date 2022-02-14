<?php

// --------------------------------------------------------
// This is only a pointer file, not an actual language file
// --------------------------------------------------------
//
// If you've copied this file to your /resources/lang/vendor/backpack/
// folder, please delete it, it's no use there. You need to copy/publish the
// actual language file, from the package.

// If a langfile with the same name exists in the package, load that one
if (file_exists(__DIR__.'/../../../../../permissionmanager/src/resources/lang/'.basename(__DIR__).'/'.basename(__FILE__))) {
    return include __DIR__.'/../../../../../permissionmanager/src/resources/lang/'.basename(__DIR__).'/'.basename(__FILE__);
}

return [
    'name'                  => 'Name',
    'role'                  => 'Role',
    'roles'                 => 'Roles',
    'roles_have_permission' => 'Roles that have this permission',
    'permission_singular'   => 'permission',
    'permission_plural'     => 'permissions',
    'user_singular'         => 'User',
    'user_plural'           => 'Users',
    'email'                 => 'Email',
    'extra_permissions'     => 'Extra Permissions',
    'password'              => 'Password',
    'password_confirmation' => 'Password Confirmation',
    'user_role_permission'  => 'User Role Permissions',
    'user'                  => 'User',
    'users'                 => 'Users',
    'guard_type'            => 'Guard Type',
];

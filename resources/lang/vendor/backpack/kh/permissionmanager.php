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
    'name'                  => 'ឈ្មោះ',
    'role'                  => 'តួនាទី',
    'roles'                 => 'តួនាទី',
    'roles_have_permission' => 'តួនាទីដែលមានការអនុញ្ញាតនេះ',
    'permission_singular'   => 'ការអនុញ្ញាត',
    'permission_plural'     => 'ការអនុញ្ញាត',
    'user_singular'         => 'អ្នក​ប្រើ',
    'user_plural'           => 'អ្នក​ប្រើ',
    'email'                 => 'អ៊ីមែល',
    'extra_permissions'     => 'ការអនុញ្ញាតបន្ថែម',
    'password'              => 'ពាក្យសម្ងាត់',
    'password_confirmation' => 'ការ​បញ្ជាក់​ពាក្យ​សម្ងាត់',
    'user_role_permission'  => 'ការអនុញ្ញាតតួនាទីអ្នកប្រើប្រាស់',
    'user'                  => 'អ្នក​ប្រើ',
    'users'                 => 'អ្នក​ប្រើ',
    'guard_type'            => 'ប្រភេទឆ្មាំ',
];

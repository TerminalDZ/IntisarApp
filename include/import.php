<?php
require  'vendor/qr/qrlib.php';

$settings = Settings::get();
$profile = User::my_profile();

//Permission

//User
$add_user = Permission::YouHavePermission('add_user');
$edit_user = Permission::YouHavePermission('edit_user');
$delete_user = Permission::YouHavePermission('delete_user');
$show_users = Permission::YouHavePermission('show_users');

//Member
$show_scout = Permission::YouHavePermission('show_scout');
$add_scout = Permission::YouHavePermission('add_scout');
$edit_scout = Permission::YouHavePermission('edit_scout');
$delete_scout = Permission::YouHavePermission('delete_scout');

//Insurance
$show_insurance = Permission::YouHavePermission('show_insurance');
$add_insurance = Permission::YouHavePermission('add_insurance');	
$edit_insurance = Permission::YouHavePermission('edit_insurance');
$delete_insurance = Permission::YouHavePermission('delete_insurance');

//Uniform
$show_uniform = Permission::YouHavePermission('show_uniform');
$add_uniform = Permission::YouHavePermission('add_uniform');
$edit_uniform = Permission::YouHavePermission('edit_uniform');
$delete_uniform = Permission::YouHavePermission('delete_uniform');


//Settings
$edit_insurance_settings = Permission::YouHavePermission('edit_insurance_settings');
$edit_website_settings = Permission::YouHavePermission('edit_website_settings');

//Role and Permission
$add_role_permission = 	Permission::YouHavePermission('add_role_permission');
$edit_role_permission = Permission::YouHavePermission('edit_role_permission');
$delet_role_permission = Permission::YouHavePermission('delet_role_permission');
$show_role_permission = Permission::YouHavePermission('show_role_permission');






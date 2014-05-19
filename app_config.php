<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
	
	domain settings
	example:
	account_suffix = '@you-domain.com'; // is a string
	base_dn = 'DC=you-domain,DC=com'; // is a string
	domain_controllers = array ('127.0.0.1'); // is an array
	ad_username = 'you_username_for_read_the_AD'; // is a string
	ad_password = 'password_for_the_read_user'; // is a string
	real_primarygroup = true : false; // no required parameter for detect the primary group. is a bool
	use_ssl = true : false; // Use SSL (LDAPS), your server needs to be setup. is a bool
	use_tls = true : false; // Use TLS. If you wish to use TLS you should ensure that use_ssl is set to false and vice-versa. is a bool
	recursive_groups = true : false; // When querying group memberships, do it recursively. is a bool
	admin_group = 'you-group-in-domain'; // is a string. 
	
*/

$config['account_suffix']	= ''; 
$config['base_dn']		= '';
$config['domain_controllers']	= array ();
$config['ad_username']		= '';
$config['ad_password']		= '';
$config['real_primarygroup']	= true;
$config['use_ssl']		= false;
$config['use_tls'] 		= false;
$config['recursive_groups']	= true;
$config['admin_group']	= "";

/*

	wifi settings 
	
*/
	
$config['wifi_user'] = ""; // is a string. use for auth at the smartpass server
$config['wifi_password'] = ""; // is a string. use for auth at the smartpass server
$config['wifi_protocol'] = "https";  // is a string. protocol of the smartpass server
$config['wifi_host'] = 'smartpass.megafon-retail.ru'; // is a string. hostname of the smartpass server 
$config['wifi_service_url'] = 'webservice/provision/v1'; // is a string. api path of the smartpass server
$config['wifi_types_url'] = 'user-types'; // is a string. types path of the smartpass server
$config['wifi_users_url'] = 'users'; // is a string. users path of the smartpass server

/*
	SMPP settings
*/	

$config['smpp_enable'] = 0; // 1 - enable, 0 - disable
$config['smpp_server'] = ''; // is a string. host of the smpp server 
$config['smpp_port'] = ''; // can be only a string. port of the smpp server 
$config['smpp_user'] = ''; // is a string. user of the smpp server 
$config['smpp_pass'] = '';  // is a string. password for user of the smpp server 
$config['smpp_src_number'] = ''; // can be only a string. the source number of the smpp server


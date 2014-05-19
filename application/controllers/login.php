<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->config->load('app_config', true);
		$this->load->library('adldap');
		$this->load->helper('form');
		$this->load->helper('url');
		
	}
	
	public function index ()
	{
		if ($_POST)
		{
			$authResult = $this->adldap->authenticate($_POST['login'], $_POST['password']);
			if ($authResult == TRUE)
			{
				$admin_group = $this->config->item('admin_group', 'adldap');
				$groupResult = $this->adldap->user_ingroup($_POST['login'], $admin_group);
                $user_session = array(
                       'user_logged'  =>  TRUE,
                       'admin'		  => $groupResult,
                       'login'		  => strtolower($_POST['login'])
                );
                $this->session->set_userdata($user_session);
                if ($groupResult == TRUE)
                {
					redirect(base_url('index.php/welcome'));
				}
                else
                {
					redirect(base_url('index.php/user'));
				}
			}
			else
			{
				$this->load->view('login/index');
			}
		}
		else
		{
			$this->load->view('login/index');
		}
	}
}
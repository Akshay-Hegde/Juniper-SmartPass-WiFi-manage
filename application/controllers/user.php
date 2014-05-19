<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller 
{
	private $conf;
	
	public function __construct()
	{
		parent::__construct();
		$this->config->load('app_config', TRUE);
		$this->conf = $this->config->item('app_config');
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->library('getpage');
		$this->load->library('smpp', $this->conf);
		if ($this->session->userdata('user_logged') != TRUE) redirect("login/?ReturnURL=".$_SERVER["REQUEST_URI"]);
	}
	
	public function index ()
	{
			$url = $this->conf['wifi_protocol'] . "://" . $this->conf['wifi_host'] . "/" . $this->conf['wifi_service_url'] . "/" . $this->conf['wifi_users_url'];
			$result = $this->getpage->get_web_page($url, $this->conf['wifi_user'], $this->conf['wifi_password']);
			$test = array();
			
			if (isset($result['content']))
			{
				$info = simplexml_load_string($result['content']);
				$i = 0;
				foreach($info->USER as $USER)
				{
					if ($USER->attributes()->state == 'Activated' or $USER->attributes()->state == 'Unauthenticated')
					{
						$test[$i] = (string) $USER->attributes()->name;
						$i++;
					}
				}
			}
						
			$data['wifilogin'] = $this->session->userdata('login');
			$data['wifipassword'] = $this->session->userdata('wifipassword');
			$data['enable'] = in_array($this->session->userdata('login'), $test);
			$this->load->view('user/index', $data);
	}
	
	public function disable ()
	{
		$username = '&username='.$this->session->userdata('login');
		$url = $this->conf['wifi_protocol'] . "://" . $this->conf['wifi_host'] . "/" . $this->conf['wifi_service_url'] . "/" . $this->conf['wifi_users_url'] . "?op=delete" . $username;
		$result = $this->getpage->get_web_page($url, $this->conf['wifi_user'], $this->conf['wifi_password']);
		if ($result['errno'] == '0')
		{
			$this->session->unset_userdata('wifipassword');
			redirect(base_url('index.php'));
		}
		else
		{
			print $result['errno'] . '<br/>' . $result['errmsg'];
		}	
	}
	
	public function enable ()
	{
		$username = '&username='.$this->session->userdata('login');
		$duration = '&user-type=8-Hours Duration';
		$url = $this->conf['wifi_protocol'] . "://" . $this->conf['wifi_host'] . "/" . $this->conf['wifi_service_url'] . "/" . $this->conf['wifi_users_url'] . "?op=add" . $username . $duration;
		$result = $this->getpage->get_web_page($url, $this->conf['wifi_user'], $this->conf['wifi_password']);
		if ($result['errno'] == '0')
		{
			$info = simplexml_load_string($result['content']);
			$p = (string) $info->USER->attributes()->password;
			$set = array('wifipassword' => $p);
			$this->session->set_userdata($set);
			redirect(base_url('index.php'));
		}
		else
		{
			print $result['errno'] . '<br/>' . $result['errmsg'];
		}	
	}
}
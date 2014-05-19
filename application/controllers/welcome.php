<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller 
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
		if ($this->session->userdata('admin') == FALSE) redirect("user");
	}

	public function index()
	{
		$view = isset($_GET['view']) ? $_GET['view'] : NULL;
		
		$url = $this->conf['wifi_protocol'] . "://" . $this->conf['wifi_host'] . "/" . $this->conf['wifi_service_url'] . "/" . $this->conf['wifi_users_url'];
		$result = $this->getpage->get_web_page($url, $this->conf['wifi_user'], $this->conf['wifi_password']);
		$data['result'] = array();
		
		if (isset($result['content']))
		{
			$info = simplexml_load_string($result['content']);
			$i = 0;
			foreach($info->USER as $USER)
			{
				if (is_null($view))
				{
					$data['result'][$i]['name'] = $USER->attributes()->name;
					$data['result'][$i]['type'] = $USER->attributes()->type;
					$data['result'][$i]['password'] = $USER->attributes()->password;
					$data['result'][$i]['mac-auth-method'] = $USER->attributes()->{'mac-auth-method'};
					$data['result'][$i]['email-address'] = $USER->attributes()->{'email-address'};
					$data['result'][$i]['phone-number'] = $USER->attributes()->{'phone-number'};
					$data['result'][$i]['start-date'] = $USER->attributes()->{'start-date'};
					$data['result'][$i]['end-date'] = $USER->attributes()->{'end-date'};
					$data['result'][$i]['last-login-time'] = $USER->attributes()->{'last-login-time'};
					$data['result'][$i]['state'] = $USER->attributes()->state;
				}
				elseif (!is_null($view) and $view == 'Activated' and $USER->attributes()->state == 'Activated')
				{
					$data['result'][$i]['name'] = $USER->attributes()->name;
					$data['result'][$i]['type'] = $USER->attributes()->type;
					$data['result'][$i]['password'] = $USER->attributes()->password;
					$data['result'][$i]['mac-auth-method'] = $USER->attributes()->{'mac-auth-method'};
					$data['result'][$i]['email-address'] = $USER->attributes()->{'email-address'};
					$data['result'][$i]['phone-number'] = $USER->attributes()->{'phone-number'};
					$data['result'][$i]['start-date'] = $USER->attributes()->{'start-date'};
					$data['result'][$i]['end-date'] = $USER->attributes()->{'end-date'};
					$data['result'][$i]['last-login-time'] = $USER->attributes()->{'last-login-time'};
					$data['result'][$i]['state'] = $USER->attributes()->state;
					
				}
				elseif (!is_null($view) and $view == 'Expired' and $USER->attributes()->state == 'Expired')
				{
					$data['result'][$i]['name'] = $USER->attributes()->name;
					$data['result'][$i]['type'] = $USER->attributes()->type;
					$data['result'][$i]['password'] = $USER->attributes()->password;
					$data['result'][$i]['mac-auth-method'] = $USER->attributes()->{'mac-auth-method'};
					$data['result'][$i]['email-address'] = $USER->attributes()->{'email-address'};
					$data['result'][$i]['phone-number'] = $USER->attributes()->{'phone-number'};
					$data['result'][$i]['start-date'] = $USER->attributes()->{'start-date'};
					$data['result'][$i]['end-date'] = $USER->attributes()->{'end-date'};
					$data['result'][$i]['last-login-time'] = $USER->attributes()->{'last-login-time'};
					$data['result'][$i]['state'] = $USER->attributes()->state;
				}
				$i++;
			}
		}
		
		$this->load->view('index', $data);
	}
	
	public function add ()
	{
		if ($_POST)
		{
			$username = empty($_POST['login']) ? '' : ('&username='.$_POST['login']);
			$pwd = empty($_POST['password']) ? '' : "&password=".$_POST['password'];
			$phone = empty($_POST['phone']) ? '' : ("&phone-number=".$_POST['phone']);
			$duration = empty($_POST['duration']) ? '' : ('&user-type=' . $_POST['duration']);
			$url = $this->conf['wifi_protocol'] . "://" . $this->conf['wifi_host'] . "/" . $this->conf['wifi_service_url'] . "/" . $this->conf['wifi_users_url'] . "?op=add" . $username . $pwd . $phone . $duration;
			
			$result = $this->getpage->get_web_page($url, $this->conf['wifi_user'], $this->conf['wifi_password']);
			if ($result['errno'] == '0')
			{
				$info = simplexml_load_string($result['content']);
				if (isset($_POST['phone']) and $this->conf['smpp_enable'] == 1)
				{
					$this->smpp->send_ru($_POST['phone'], "Hi. Access to WiFi network is granted. \nYou credentials: \nLogin: " . $info->USER->attributes()->name . " \nPassword: " . $info->USER->attributes()->password);
				}
				redirect(base_url('index.php'));
			}
			else
			{
				print $result['errno'] . '<br/>' . $result['errmsg'];
			}
		}
		else
		{
			$url = $this->conf['wifi_protocol'] . "://" . $this->conf['wifi_host'] . "/" . $this->conf['wifi_service_url'] . "/" . $this->conf['wifi_types_url'];
			$result = $this->getpage->get_web_page($url, $this->conf['wifi_user'], $this->conf['wifi_password']);
			$info = simplexml_load_string($result['content']);
			$data['result'] = array();
			
			if (isset($result['content']))
			{
				$info = simplexml_load_string($result['content']);
				$i = 0;
				foreach($info->{'USER-TYPE'} as $USER)
				{
					$data['result'][$i]['name'] = $USER->attributes()->name;
					$data['result'][$i]['duration'] = $USER->attributes()->duration;
					$i++;
				}
			}
			$this->load->view('add', $data);
		}
	}
	
	public function delete ($login = NULL) 
	{
		if (is_null($login))
		{
			redirect(base_url('index.php'));
		}
		else
		{
			$username = '&username='.$login;
			$url = $this->conf['wifi_protocol'] . "://" . $this->conf['wifi_host'] . "/" . $this->conf['wifi_service_url'] . "/" . $this->conf['wifi_users_url'] . "?op=delete" . $username;
			$result = $this->getpage->get_web_page($url, $this->conf['wifi_user'], $this->conf['wifi_password']);
			if ($result['errno'] == '0')
			{
				redirect(base_url('index.php'));
			}
			else
			{
				print $result['errno'] . '<br/>' . $result['errmsg'];
			}
		}
	}
}
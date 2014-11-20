$config = Array(
	'protocol' => 'smtp',
	'smtp_host' => 'ssl://smtp.googlemail.com',
	'smtp_port' => 465,
	'smtp_user' => 'freelection.voting.system@gmail.com',
	'smtp_pass' => 'teamfreelection',
	'mailtype' => 'html',
	'charset' => 'iso-8859-1'
	);

$this->load->library('email', $config);
$this->email->set_newline("\r\n");

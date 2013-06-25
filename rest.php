<?php
/*
 This was adapted from a sample rest client developed by urban airship at https://github.com/urbanairship/php-library
It requires that you have pecl extension HttpRequest class enabled in your php installation.  More at http://php.net/manual/en/class.httprequest.php
*/

interface Rest
{
	function create();
	
	function send();
	
	function get();
}

class RESTClient implements Rest{

	private $user_name = "";
	private $password = "";
	private $content_type = "";
	private $response = "";
	private $responseBody = "";
	private $responseCode = "";
	private $request = null;

	public function create($url, $method, $arr = null) {
		$this->request = new HttpRequest($url);

		try {
			if ($this->user_name != "" && $this->password != "") {

				$credentials = $this->user_name .':' .$this->password;
				$options = array('httpauth' => $credentials, 'httpauthtype' => HttpRequest::AUTH_BASIC);
				$this->request->setOptions($options);

			}
			if ($this->content_type != "") {

				$this->request->setContentType($this->content_type);
			}

			switch($method) {

				case "GET":
					$this->request->setMethod(HttpRequest::METH_GET);
					break;
				case "POST":
					$this->request->setMethod(HttpRequest::METH_POST);
					$this->request->setBody($arr);
					break;
				case "PUT":
					$this->request->setMethod(HttpRequest::METH_PUT);
					$this->request->setBody($arr);
					break;
				case "DELETE":
					$this->request->setMethod(HttpRequest::METH_DELETE);
					break;
			}

		} catch (Exception $e) {

			var_dump($e);

		}
	}

	public function send() {

		try {

			$this->response = $this->request->send();

		} catch (Exception $e) {

			var_dump($e);

		}

	}

	public function get() {

		try {

			$this->responseCode = $this->request->getResponseCode();
			$this->responseBody = $this->request->getResponseBody();
			return array($this->responseCode, $this->responseBody);

		} catch (Exception $e) {

			var_dump($e);

		}
	}

	public function __construct($user_name="", $password="", $content_type="") {
		$this->user_name = $user_name;
		$this->password = $password;
		$this->content_type = $content_type;
		return true;
	}

}

?>

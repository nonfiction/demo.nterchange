<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/../vendor/autoload.php';

header('Content-type: application/json');

class Contact {
  public $name;
  public $email;
  public $inquiry;
  private $mail_to = 'andy@nonfiction.ca';

  private $response = array('status'=>'', 'message'=>'unprocessed');

  public function __construct($from_json){
    try {
      $request = json_decode($from_json);
      if (!$request) throw new Exception("Request Error: could not decode request body", 1);
      if (!$request->name) throw new Exception("Request Error: (name)", 1);
      if (!$request->email) throw new Exception("Request Error: (email)", 1);
      if (!$request->inquiry) throw new Exception("Request Error: (inquiry)", 1);
      $this->name = $request->name;
      $this->email = $request->email;
      $this->inquiry = $request->inquiry;
    } catch (Exception $e) {
      $this->response = array('status'=>'error', 'message' => $e->getMessage());
    }
  }

  function notify(){
    $mailer = $this->mailer();
    if ($this->response['status'] == 'error') {
      // bail out
    } else if (!$mailer->send()) {
      $this->response = array('status'=>'error', 'message' => 'Mailer Error: ' . $mailer->ErrorInfo);
    } else {
      $this->response = array('status'=>'success', 'message'=>'Delivered');
    }
  }

  function response_json(){
    return json_encode($this->response);
  }

  function mailer(){
    $mail = new PHPMailer;
    $mail->From = 'no-reply@vineandhops.ca';
    $mail->FromName = 'Vine & Hops';
    $mail->addAddress($this->mail_to, '');
    $mail->WordWrap = 50;
    $mail->isHTML(true);
    $mail->Subject = 'New contact form submission';
    $mail->Body    = <<<EOF
<body>
  <h3>{$subject}</h3>
  <table>
    <tr><th>Name</th><td>{$this->name}</td></tr>
    <tr><th>Email</th><td>{$this->email}</td></tr>
    <tr><th>Inquiry</th><td>{$this->inquiry}</td></tr>
  </table>
</body>
EOF;
    return $mail;
  }
}

if (__FILE__ == $_SERVER["DOCUMENT_ROOT"].$_SERVER["SCRIPT_NAME"]) {
  $contact = new Contact(file_get_contents('php://input'));
  $contact->notify();
  echo $contact->response_json();
}

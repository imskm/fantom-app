<?php

namespace App\Support\Mail;

use App\Config;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/**
 * Mail Model class
 * A mail model: sends bulk html mail to receipients
 */
class Mail
{
	/**
	 * Server config and mail logins
	 */
	private $sender_name;
	private $sender;
	private $mail;

	private $receipients = []; 	// To mail id (receipients)
	private $subject = "";

	const ENABLE_EXCEPTION = true;

	private $use_template = "";
	private $variables;

	/**
	 * Mail Status Loggers
	 */
	private $failed = [];
	private $mailStatus = [];

	public function __construct($sender, $sender_name)
	{
		$this->sender = $sender;
		$this->sender_name = $sender_name;

		$this->mail = new PHPMailer(self::ENABLE_EXCEPTION);

	    $this->mail->isSMTP();                          // Set mailer to use SMTP
	    $this->mail->Host = Config::MAIL_HOST; 			// Specify main and backup SMTP servers
	    $this->mail->SMTPAuth = true;					// Enable SMTP authentication
	    $this->mail->Username = Config::MAIL_USERNAME; 	// SMTP username
	    $this->mail->Password = Config::MAIL_PASSWORD;	// SMTP password
	    $this->mail->SMTPSecure = Config::MAIL_ENCRYPTION;	// Enable TLS encryption, `ssl` also accepted
	    $this->mail->Port = Config::MAIL_PORT;             // TCP port to connect to
	    $this->mail->SMTPKeepAlive = true; 				// SMTP connection will not close after each email sent, reduces SMTP overhead

	    $this->mail->setFrom($this->sender, $this->sender_name);
	}

	public function setDebugOn()
	{
		//Server settings
	    $this->mail->SMTPDebug = 2;                     // Enable verbose debug output

		return $this;
	}

	/**
	 * Sets template to be used for body of the mail
	 *
	 * @var string $use_template  path to template file
	 * @var string $variables  variables that will be used by templates
	 */
	public function useTemplate($use_template, $variables = [])
	{
		$this->use_template = $use_template;
		$this->variables = $variables;

		return $this;
	}

	/**
	 * Sets the subject of the mail
	 *
	 * @var string $subject subject of the mail
	 */
	public function setSubject($subject)
	{
		$this->subject = $subject;

		return $this;
	}

	/**
	 * Set repy-to address
	 */
	public function setReplyTo($replyto, $name = "")
	{
		if ($name) {
			$this->mail->addReplyTo($replyto, $name);
		} else {
			$this->mail->addReplyTo($replyto);
		}

		return $this;
	}

	/**
	 * Sends the mail to recipients
	 *
	 * @var array $recipients  one or more recipients
	 */
	public function send(array $recipients)
	{
		if (!$this->subject) {
			throw new \Exception("send(): Subject is not set.");
		}

		$this->mail->Subject = $this->subject;
		$this->mail->isHTML(true);
		$this->mail->XMailer = ' ';

		/* Iterating over recipients and sending email one by one */
		foreach ($recipients as $recipient) {
			// Add address
			$this->mail->addAddress($recipient);

			// Mark the current mail is failed
			$this->mailStatus[$recipient] = false;

			// Add body of the mail
			if ($this->use_template) {
				$this->mail->Body = $this->renderTemplate($this->variables);
			} else {
				$this->mail->Body = "<Body of the mail is not set.>";
			}

			// Skip to next recipient if current recipient fails
			if (!$this->mail->send()) {
				$this->logFailedMail($recipient);
				continue;
			}

			// Override the previously assumed failed status
			$this->mailStatus[$recipient] = true;

			// Clear all address and attachment for next email
			$this->mail->clearAddresses();
			$this->mail->clearAttachments();
		}

		return $this->hasFailedAny();
	}

	protected function sendHtmlMail()
	{
		$this->mail->isHTML = true;
	}

	/**
	 * Renders template that is set by useTemplate() method
	 *
	 * @var array $variables  array of variables that will be used by the template
	 * @return string  String buffer of rendered html content
	 */
	protected function renderTemplate($variables)
	{
		if ($this->use_template) {
			if (!is_readable($this->use_template)) {
				throw new \Exception("Template $this->use_template is not found.");
			}
		}

		ob_start();
		$contents = "";
		try {
			
			extract($variables, EXTR_SKIP);
			include $this->use_template;
			$contents = ob_get_contents();

		} catch (\Exception $e) {
			throw new \Exception('Something went wrong.' . $e->getMessage());
		}
		ob_end_clean();

		return $contents;
	}

	/**
	 * Logs failed mails (just the email address)
	 */
	protected function logFailedMail($recipient)
	{
		$this->failed[] = $recipient;
	}

	public function hasFailedAny()
	{
		return (isset($this->failed[0])) ? true : false;
	}

	public function getFailedMails()
	{
		return $this->hasFailedAny() ? $this->failed : null;
	}

	public function getMailStatus()
	{
		return !empty($this->mailStatus) ? $this->mailStatus : [];
	}

}

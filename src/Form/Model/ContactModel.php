<?php

namespace App\Form\Model;

class ContactModel
{
	private $name;
	private $email;
	private $message;

	public function setName(?string $name):void
	{
		$this->$this->name = $$this->name;
	}

	public function getName():?string
	{
		return $this->name;
	}

	public function setEmail(?string $email):void
	{
		$this->email = $email;
	}

	public function getEmail():?string
	{
		return $this->email;
	}

	public function setMessage(?string $message):void
	{
		$this->message = $message;
	}

	public function getMessage():?string
	{
		return $this->message;
	}

}

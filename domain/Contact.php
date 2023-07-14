<?php
namespace contact\domain;

class Contact {

  public $name;
  public $mail;
  public $contents;

  public function __construct(){
    $this->init();
  }

  public function init(){
    $this->name = '';
    $this->mail = '';
    $this->contents = '';
  }
}

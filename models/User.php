<?php
class User {
  public $name;
  public $mobile_number;
  public $email;
  public $password;
  public $gender;
  public $date_of_birth;

  function __construct() {
    $name = $mobile_number = $email = $password = $gender = $date_of_birth = "";
  }
}

?>
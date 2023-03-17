<?php
session_start();
// require config và connect database
require 'config.php';
require 'connectDb.php';

// require model
require 'model/StudentRepository.php';
require 'model/Student.php';

require 'model/SubjectRepository.php';
require 'model/Subject.php';

require 'model/RegisterRepository.php';
require 'model/Register.php';

// Router
$c = $_GET['c'] ?? 'student';
$a = $_GET['a'] ?? 'index';

// ucfirst là upper ký tự đầu tiên 
$str = ucfirst($c) . 'Controller'; //StudentController
require "controller/$str.php";
$controller = new $str();
$controller->$a();
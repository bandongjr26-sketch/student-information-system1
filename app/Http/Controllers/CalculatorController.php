<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CalculatorController extends Controller
{
     public function add() {
     
      $a = 2;
      $b = 3;
      $sum = $a + $b;
      
      return "sum is: ".$sum;
    }

     public function subtract() {
     
      $a = 2;
      $b = 3;
      $sub = $a - $b;
      
      return "answer is: ".$sub;
    }

    public function divide() {
     
      $a = 2;
      $b = 3;
      $div = $a/$b;
      
      return "answer is: ".$div;
    }

    public function multi() {
     
      $a = 2;
      $b = 3;
      $mul = $a * $b;
      
      return "answer is: ".$mul;
    }

    public function modulo() {
     
      $a = 2;
      $b = 3;
      $mod = $a % $b;
      
      return "answer is: ".$mod;
    }
}

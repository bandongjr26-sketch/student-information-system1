<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PSUController extends Controller
{
     public function welcome() {
      
      return "WELCOME TO PSU!";
    }

     public function mission() {
      
      return "<h1> MISSION </h1><br>The Pangasinan State University shall provide a human-centric, resilient and sustainable <br>
       academic environment to produce dynamic, responsive and future ready individual capable <br>
       of meeting the requirements of the local and global communities and industries.
      ".date("y,m,d");
    }

     public function vision() {
      
      return "<h1> VISION </h1><br>To be a leading industry-driven State University in the ASEAN region by 2030
      ".date("y,m,d");
    }


     public function oems() {
      
      return "<h1> PSU EDUCATIONAL ORGANIZATION POLICY </h1><br> 
      The Pangasinan State University should be recognized as an ASEAN premier state university<br>
      that provides quality education and satisfactory service delivery through intruction, <br>
      research, extension and production<br>
      <br>

      We commit our expertise and resource to produce professionals who meet the expectation<br>
      of the industry and other interested parties in the national and international community<br>
      <br>
      we shall continuously improve our operation improve our operations through systems and <br>
      process innovation guided by ethical, intellectual property and technology transfer <br>
      standards in responseto the changing educational, scientific and technological developments<br>
      for social responsiveness and in support if the instituitions strategic direction 
      ".date("y,m,d");
    }

     public function students($name, $course) {
      return  "Student: ".$name. "<br>Course: ".$course;
      
     
    }

}

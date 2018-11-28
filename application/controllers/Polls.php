<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Polls extends CI_Controller {

    /** Loads the front page of the angular.js client application
    */
    public function index()	{
        $this->load->helper('html');
        $this->load->helper('url');
        $this->load->view('polls');
	}
}

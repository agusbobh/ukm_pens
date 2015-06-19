<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Blog extends Controller {

  function Blog() {
    parent::Controller();
    $this->load->model('agenda_model','', true);
  }

  function index()
  {
    $dat = $this->agenda_model->view_agenda();
    $data['dataagenda'] = $dat->_fetch_object();
    $this->load->view('blog_view', $data);
  }
}

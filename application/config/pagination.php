<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['page_query_string'] = true;
$config['reuse_query_string'] = true;

$config['attributes'] = array('class' => 'page-link');
$config['query_string_segment'] = 'mulai';

$config['full_tag_open'] = '<ul class="pagination m-0 ms-auto">';
$config['full_tag_close'] = '</ul>';

$config['first_link'] = '<i class="ti ti-chevrons-left icon" aria-hidden="true"></i>';
$config['first_tag_open'] = '<li class="page-item" data-bs-toggle="tooltip" data-placement="top" title="Pertama">';
$config['first_tag_close'] = '</li>';

$config['last_link'] = '<i class="ti ti-chevrons-right icon" aria-hidden="true"></i>';
$config['last_tag_open'] = '<li class="page-item" data-bs-toggle="tooltip" data-placement="top" title="Terakhir">';
$config['last_tag_close'] = '</li>';

$config['next_link'] = '<i class="ti ti-chevron-right icon"></i>';
$config['next_tag_open'] = '<li class="page-item" data-bs-toggle="tooltip" data-placement="top" title="Selanjutnya">';
$config['next_tag_close'] = '</li>';

$config['prev_link'] = '<i class="ti ti-chevron-left icon"></i>';
$config['prev_tag_open'] = '<li class="page-item" data-bs-toggle="tooltip" data-placement="top" title="Sebelumnya">';
$config['prev_tag_close'] = '</li>';

$config['cur_tag_open'] = '<li class="page-item active"><a class="page-link">';
$config['cur_tag_close'] = '</a></li>';

$config['num_tag_open'] = '<li class="page-item">';
$config['num_tag_close'] = '</li>';

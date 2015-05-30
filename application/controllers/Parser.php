<?php
/**
 * Title:
 * Author: Petr Supe
 * Email: cmdconfig@gmail.com 
 * Date: 30.05.2015
 * Time: 10:16 AM
 */

class Parser extends CI_Controller {

    public function collector(){

        if($this->config->load('parser.php')){
            $pageURL = $this->config->item('pageURL');
            $this->load->model('Parsermodel');
            Parsermodel::forge()->getPages($pageURL);
        }
    }
}
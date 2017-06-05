<?php

namespace Classes;

/*****************************************************************
* Name:       View.php
*
* Created:    June 4, 2017
* Edited:     
* Author:     Ben Yanke <ben@benyanke.com>
* Editors:
* Purpose:    Handles the main application display and simple templating
*****************************************************************/


class View {

    public $file;
    public $viewdata;
    public $baseDir;

    public function __construct($viewdata = null) {

        $this->viewdata = $viewdata;

        $this->baseDir = dirname($_SERVER['SCRIPT_FILENAME']);

    }

    /*
    * Set the view data
    *
    * RETURN : VOID
    */
    public function setViewData($viewdata) {
        $this->viewdata = $viewdata;

        // Get root url from server-provided domain and protocol
        $this->viewdata['root-url'] = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'];

        return;
    }

    /*
    * Set the view template
    *
    * RETURN : VOID
    */
    public function setTemplate($template) {
        $this->file = $this->baseDir . '/templates/' . $template . ".tpl.php";

        return;
    }


    /*
    * Output a standard page, with data passed through using $this->viewdata
    *
    * RETURN : VOID
    */
    public function displayPage(){
        
        // Handle custom header option
        if (isset($this->viewdata['custom-head'])) {
            include $this->baseDir . '/templates/' . $this->viewdata['custom-head'] . '.ypl.php';
        } else {
            include $this->baseDir . '/templates/' . 'head.tpl.php';
        }

        // Include the page template itself
        // Access data within templates with $this->viewdata
        include $this->file;

        // Handle custom footer option
        if (isset($this->viewdata['custom-foot'])) {
            include $this->baseDir . '/templates/' . $this->viewdata['custom-foot'] . '.tpl.php';
        } else {
            include $this->baseDir . '/templates/' . 'foot.tpl.php';

        }


    }

}
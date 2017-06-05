<?php

/*****************************************************************
* Name:       ViewProvider.php
*
* Created:    June 4, 2017
* Edited:     
* Author:     Ben Yanke <ben@benyanke.com>
* Editors:
* Purpose:    Service provider for the View class.
*****************************************************************/

namespace ProviderFiles;

use Silex\Application;
use Pimple;
use Classes;

class ViewProvider implements Pimple\ServiceProviderInterface {


    public function register(Pimple\Container $pimple) {
        $pimple['view'] = new Classes\View();
    }


}
<?php

/*****************************************************************
* Name:       AuthenticationProvider.php
*
* Created:    June 4, 2017
* Edited:     
* Author:     Ben Yanke <ben@benyanke.com>
* Editors:
* Purpose:    Service provider for the Authentication class.
*****************************************************************/

namespace ProviderFiles;

use Silex\Application;
use Pimple;
use Classes;

class AuthenticationProvider implements Pimple\ServiceProviderInterface {


    public function register(Pimple\Container $pimple) {

        $pimple['auth'] = new Classes\Authentication($pimple['db'], $pimple['auth.hashcost']);
        
    }


}
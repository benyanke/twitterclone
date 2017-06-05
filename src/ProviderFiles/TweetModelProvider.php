<?php

/*****************************************************************
* Name:       TweetModelProvider.php
*
* Created:    June 4, 2017
* Edited:     
* Author:     Ben Yanke <ben@benyanke.com>
* Editors:
* Purpose:    Service provider for the TweetModel class.
*****************************************************************/

namespace ProviderFiles;

use Silex\Application;
use Pimple;
use Classes;

class TweetModelProvider implements Pimple\ServiceProviderInterface {


    public function register(Pimple\Container $pimple) {
        $pimple['tweet.model'] = new Classes\TweetModel($pimple['tweet.lengthlimit'], $pimple['auth'], $pimple['db']);
    }


}
<?php

 /*
  * TwitterClone
  *
  * A simple single-user twitter clone, written in PHP7 + MariaDB/MySQL.
  *
  * @author     Ben Yanke <ben@benyanke.com>
  * @copyright  Ben Yanke
  * @license    https://www.gnu.org/licenses/gpl-3.0.md GPLv3
  * @link       https://github.com/benyanke/twitterclone
  * @since      Version 0.1
  *
  */


/*****************************************************************
* Name:       app.php
*
* Created:    June 4, 2017
* Edited:     
* Author:     Ben Yanke <ben@benyanke.com>
* Editors:
* Purpose:    Main Silex application file. Bootstraps silex, registers service 
              providers, and defines routes.
*****************************************************************/


/***********************
Bootstrap Silex
***********************/

require 'vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use ProviderFiles\AuthenticationProvider;
use ProviderFiles\TweetModelProvider;

$app = new Silex\Application();

// Config options
// $app['debug'] = true;
$app['auth.hashcost'] = 7;
$app['tweet.lengthlimit'] = 140;
$app['author.name'] = "Ben Yanke";

/***********************
Register Service Providers
***********************/

// Needed for URL Generation
$app->register(new Silex\Provider\RoutingServiceProvider());

// Database Connection
$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => array(
            'driver'    => 'pdo_mysql',
            'host'      => getenv('DB_HOST'),
            'dbname'    => getenv('DB_NAME'),
            'user'      => getenv('DB_USER'),
            'password'  => getenv('DB_PASS'),
            'charset'   => 'utf8mb4',
    ),
));

// Authentication Tools
$app->register(new ProviderFiles\AuthenticationProvider());

// TweetModel
$app->register(new ProviderFiles\TweetModelProvider());

// View and Templating
$app->register(new ProviderFiles\ViewProvider());

/***********************
Define Routes
***********************/

// Main Tweet Feed
$app->get('/', function() use ($app) {
   
    // If not logged in, redirect to login
    if(! $app['auth']->isLoggedIn() ) {
        return $app->redirect($app['url_generator']->generate('login'));
    }

    // Get all tweets from database
    $viewdata['tweets'] = $app['tweet.model']->getAllTweets();
    $viewdata['tweet-submit'] = $app['url_generator']->generate('tweet-submit');
    $viewdata['tweet-lengthlimit'] = $app['tweet.lengthlimit'];

    // Set template
    $app['view']->setTemplate('feed');
    $app['view']->setViewData($viewdata);        
    $app['view']->displayPage();

    return new Response('');
})->bind('feed');


// Called by ajax from "/" to submit tweets
$app->match('/tweetsubmission', function(Request $request) use ($app) {

    // If not logged in, redirect to login
    if(! $app['auth']->isLoggedIn() ) {
        return new Response('406: Forbidden', 403);
    }

    // Get all tweets from database
    $viewdata['tweets'] = $app['tweet.model']->getAllTweets();
    $viewdata['tweet-lengthlimit'] = $app['tweet.lengthlimit'];

    if(isset($_POST['tweetcontent'])) {
        $app['tweet.model']->storeNewTweet($_POST['tweetcontent']);  
        return new Response('Success.');
    }

    Return new Response('400: Bad Request: Please specify tweetcontent', 400);

})->bind('tweet-submit');

// Login page
$app->match('/login', function(Request $request) use ($app) {

    // If you're already logged in, redirect to the feed
    if($app['auth']->isLoggedIn() ) {
        return $app->redirect($app['url_generator']->generate('feed'));
    }

    // Pass data to the view
    $viewdata['login-submit'] = $app['url_generator']->generate('login-submit');
    $viewdata['page-title'] = "Login Page";
    $viewdata['page-description'] = "Login to view and post tweets!";
    $viewdata['page-author'] = $app['author.name'];
    $viewdata['tweet-lengthlimit'] = $app['tweet.lengthlimit'];
    $viewdata['login-error'] = $app['auth']->getSessionVar('loginerror');

    // Clear message so it doesn't display in the future
    $app['auth']->setSessionVar('loginerror', "");

    // Set template
    $app['view']->setTemplate('login');
    $app['view']->setViewData($viewdata);        
    $app['view']->displayPage();

    // Display is handled by the view
    return "";

})->bind('login');



// Login page submission handler
$app->post('/login-submit', function(Request $request) use ($app) {


    if(isset($_POST['username']) && isset($_POST['password'])) {
        $success = $app['auth']->sessionLogin($_POST['username'], $_POST['password']);
    } else {
        $success = false;
    }
    
    if($success) { 
        return $app->redirect($app['url_generator']->generate('feed'));
    } else {
        return $app->redirect($app['url_generator']->generate('login'));

    }


})->bind('login-submit');

// Logout
$app->get('/logout', function(Silex\Application $app) use ($app) {
    $app['auth']->logout();

    return $app->redirect($app['url_generator']->generate('feed'));
})->bind('logout');


// 404 catchall handler
$app->get('{url}', function($url) use ($app) {
    return new Response('404: "/' . $url . '" does not exist.', 404);
})->assert('url', '.+');


/***********************
Run the app
***********************/

$app->run();
   
<?php

namespace Classes;

/*****************************************************************
* Name:       TweetModel.php
*
* Created:    June 4, 2017
* Edited:     
* Author:     Ben Yanke <ben@benyanke.com>
* Editors:
* Purpose:    Handles the main application display and features.
*****************************************************************/

class TweetModel {

    private $lengthlimit;
    private $auth;
    private $db;

    public function __construct($limit, $auth, $db) {
        $this->lengthlimit = $limit;
        $this->auth = $auth;
        $this->db = $db;

    }

   /*
    * Start the current user's session with cookies. Return false if error.
    *
    * RETURN : BOOLEAN
    */
    public function storeNewTweet($tweetContent) {
        
        // Check tweet char length
        if(strlen($tweetContent) > $this->lengthlimit) {
            // Send error to error buffer for later display
            $this->auth->setSessionVar("tweeterr", "Tweet length was too long");
            return false;
        } else if(strlen($tweetContent) == 0) {
            // Send error to error buffer for later display
            $this->auth->setSessionVar("tweeterr", "Tweet was blank");
            return false;
        } else {
            // Clear error buffer
            $this->auth->setSessionVar("tweeterr", null);

            $this->db->insert('tweets', array(
                'author_id' => $this->auth->getSessionVar("user_id"),
                'timestamp' => time(),
                'content' => $tweetContent
            ));
            return true;
        }

    }

   /*
    * Get all current tweets.
    *
    * RETURN : BOOLEAN
    */
    public function getAllTweets() {

        $sql = 'SELECT * ';
        $sql.= 'FROM tweets, users ';
        $sql.= 'WHERE user_id = author_id ; ';

        $data = $this->db->fetchAll($sql);

        return $data;
    }


}
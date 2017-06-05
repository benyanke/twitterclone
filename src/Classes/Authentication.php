<?php

namespace Classes;

/*****************************************************************
* Name:       Authentication.php
*
* Created:    June 4, 2017
* Edited:     
* Author:     Ben Yanke <ben@benyanke.com>
* Editors:
* Purpose:    Handles user authentication and session cookies. Written as
              a Silex service provider.
*****************************************************************/

class Authentication {

    private $currentUserId;
    private $errorMessage;
    private $hashCost;
    private $db;

    public function __construct($db, $hashCost) {
        $this->startSession();

        $this->hashCost = $hashCost;
        $this->db = $db;
    }

    /*
    * Start the current user's session with cookies.
    *
    * RETURN : VOID
    */
    public function startSession() {
        session_start();
    }


    /*
    * Returns true if user is currently logged in
    *
    * RETURN : BOOLEAN 
    */
    public function isLoggedIn() {
        if ($this->getSessionVar('user_id') == null) { 
            return false;
        } else {
            return true;
        }
    }

    /*
    * End the current user's session, and destroy all associated information with it.
    *
    * RETURN : VOID
    */
    public function endSession() {
        session_destroy();
    }

    /*
    * Get a session token from the current user's
    * server-side browser session
    *
    * RETURN : STRING - session variable content
    */
    public function getSessionVar($key) {
        
        // Error handling: Null checking
        if (!isset($_SESSION[$key]) || $_SESSION[$key] == null || $_SESSION[$key] == '') {
            return null;
        } else {
            return $_SESSION[$key];
        }

    }

    /*
    * Sets a session token from the current user's
    * server-side browser session
    *
    * RETURN : BOOLEAN - success of setting value
    */
    public function setSessionVar($key, $val)  {

        // Error handling: Null checking
        if ($key == null && $val == null) {
            return false;
        } else if ($key == null) {
            return false;
        } else if ($val == null) {
            unset($_SESSION[$key]);
            return false;
        }

        // Set the value, and return the status of the set
        if ($_SESSION[$key] = $val) {
            return true;
        } else {
            return false;
        }
    }

    /*
    * Read the error message from the error buffer
    * and clear the error buffer.
    *
    * RETURN : STRING - error message
    */
    public function readErrorMsg() {
        $message = $this->errorMessage;
        $this->errorMessage = null;
        return $message;
    }

    /*
    * Attempts a login, and if successful, stores logged
    * in state in session cookies.
    *
    * RETURN: BOOLEAN
    *   See error buffer for user-readable details if failure
    */
    public function sessionLogin($usernameIn, $passwordInStr) {

        // sanitize inputs
        $usernameIn = trim(strtolower($usernameIn));
        $passwordInStr = trim($passwordInStr);
        
        if ($this->isValidCredentials($usernameIn, $passwordInStr)) {
            $this->setSessionVar('user_id', $this->getUserIdByUsername($usernameIn));
            return true;
        } else {
            $this->setSessionVar('loginerror', "Incorrect login");
            return false;
        }
    }



    /*
    * Checks if the credentials provided are valid.
    *
    * RETURN: BOOLEAN
    */
    public function isValidCredentials($username, $passwordInStr)
    {

        // Sanitize inputs
        $u = trim(strtolower($username));
        $pw = trim($passwordInStr);

        $sql = 'SELECT user_id, username, password ';
        $sql.= 'FROM users ';
        $sql.= 'WHERE username = ? ;';

        $data = $this->db->fetchAssoc($sql, array((string) $username));

        return $this->passwordVerify($passwordInStr, $data['password']);
    }

    /*
    * Checks a password to see if it matches a given hash.
    *
    * RETURN: BOOLEAN
    */
    private function passwordVerify($passwordStr, $passwordHash) {

        return password_verify($passwordStr, $passwordHash);

    }

    /*
    * Returns the ID of a user, given the username
    *
    * RETURN: INT - User's ID
    */
    private function getUserIdByUsername($username) {

        $sql = 'SELECT user_id, username, password ';
        $sql.= 'FROM users ';
        $sql.= 'WHERE username = ? ;';


        $data = $this->db->fetchAssoc($sql, array((string) $username));

        return $data['user_id'];
    }

    /*
    * Returns the hash of a password, at the cost provided in the object
    *
    * RETURN: STRING - Hashed password
    */
    public function hashPw($passwordStr) {
        
        $options['cost'] = $this->hashCost;

        return password_hash($passwordStr, PASSWORD_BCRYPT, $options);

    }


    /*
    * Logs out the user
    *
    * RETURN: VOID
    */
    public function logout() {
        
        $this->setSessionVar('user_id',  null);
        $this->setSessionVar('user_last_login',  null);

        $this->currentUserId = null;

        $this->endSession();
        $this->startSession();
    }


}
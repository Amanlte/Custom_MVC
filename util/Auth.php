<?php

class Auth {

    public static function handleLogin() {
        Session::init();
        $loggedIn = Session::get('logedIn');

        // get the current page 
        $currentURL = explode("/", $_SERVER["REQUEST_URI"]);

        // assign a session for all pages allowed for the current user role 
        foreach (Session::get('allPages') as $key2 => $pages) {
            Session::set($pages, true);
        }
        Session::set('flogin', true);

        if ($loggedIn == false) {
            Session::destroy();
            header('location:' . URL . 'login');
            exit;
        } else if (Session::get($currentURL[2]) == false) {
            header('location:' . URL . 'dashboard');
        } 
    }
    
    public static function handleLoginsOnSameBrowser() {
        Session::init();
        $loggedIn = Session::get('logedIn');
        if($loggedIn == true) {
            header('location:' . URL . 'dashboard');
            echo '<script>alert("Need to logout first.")</script>';
        }
    }

}

<?php

class CoreController {

    static public function sessionVariableToggle($first, $second = null, $third = null){

        if (empty($third)) {
           if (empty($second)) {
                 if(!isset($_SESSION[$first])) {
                    $_SESSION['APP'][$first] = true;
                }
                else {
                    $_SESSION['APP'][$first] = !$_SESSION[$first];
                }
            }
            else {
                if(!isset($_SESSION['APP'][$first][$second])) {
                    $_SESSION['APP'][$first][$second] = true;
                }
                else {
                    $_SESSION['APP'][$first][$second] = !$_SESSION['APP'][$first][$second];
                }
            }
        }
        else {
            if(!isset($_SESSION['APP'][$first][$second][$third])) {
                $_SESSION['APP'][$first][$second][$third] = true;
            }
            else {
                $_SESSION['APP'][$first][$second][$third] = !$_SESSION['APP'][$first][$second][$third];
            }
        }
    }

    static public function error() {
        App::render('other/error.twig', array(
            'error' => true
        ));
    }
}

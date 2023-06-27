<?php 
    // simple page redirect
    function redirect($page){ // page is the new location we 
        // want our previous page to direct to...

        header('location: ' . URLROOT . '/' . $page);
    }

    // when we try registratio it's going to the model, to register then redirect...
<?php
    session_start();

    // Flash message helper... 
    // EXAMPLE - flash('register_success', 'You are now registered', 'alert alert-danger);
    // danger when there is some issue...
    // DISPLAY IN VIEW - <?php echo flash('register_success');
    function flash($name='', $message='', $class='alert alert-success'){
        // $class is a bootstrap we added to show alert message...
        if(!empty($name)){

            // this is if there is a message but there is no session for it...
            if(!empty($message) && empty($_SESSION[$name])){
                if(!empty($_SESSION[$name])){
                    unset($_SESSION[$name]);
                }

                if(!empty($_SESSION[$name. '_class'])){
                    unset($_SESSION[$name . '_class']);
                }


                $_SESSION[$name] = $message;
                $_SESSION[$name. '_class'] = $class;
            }
            // there is no message but there is a session...
            elseif(empty($message) && !empty($_SESSION[$name])){
                // if class is !empty then we want to put it inside this class variable...
                $class = !empty($_SESSION[$name. '_class']) ? $_SESSION[$name . '_class'] : '';

                echo '<div class="'.$class.'" id="msg-flash">'.$_SESSION[$name].'</div>';
                unset($_SESSION[$name]);
                unset($_SESSION[$name . '_class']);
            }
        }
    }

    function isLoggedIn(){
        if(isset($_SESSION['user_id'])){
            return true;
        }else{
            return false;
        }
    }
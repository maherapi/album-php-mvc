<?php
    function isLoggedIn(){
        if(isset($_SESSION['user_id'])){
            return true;
        } else {
            return false;
        }
    }

    function isAdmin() {
        if($_SESSION['user_is_admin'] == 1) {
            return true;
        } else {
            return false;
        }
    }

    function userIsActivated() {
        if($_SESSION['user_is_activated'] == 1) {
            return true;
        } else {
            return false;
        }
    }

    function redirectNotActivatedUsers() {
        flash("not_activated", "the account is not activated yet", "alert alert-danger");
        redirect('users/login');
    }

    function redirectToProperPage() {
        if(isLoggedIn()) {
            if($_SESSION['user_is_admin'] == 1) {
                redirect('admins');
            } elseif($_SESSION['user_is_activated'] == 1) {
                redirect('albums');
            }
        }
    }
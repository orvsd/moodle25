<?php

class block_oauth extends block_base {
    function init() {
        $this->title = 'Login';
    }

    function applicable_formats() {
        return array('site' => true);
    }

    function get_content () {
        global $USER, $CFG, $SESSION;
        $wwwroot = '';
        $signup = '';

        if ($this->content !== NULL) {
            return $this->content;
        }

        if (empty($CFG->loginhttps)) {
            $wwwroot = $CFG->wwwroot;
        } else {
            // This actually is not so secure ;-), 'cause we're
            // in unencrypted connection...
            $wwwroot = str_replace("http://", "https://", $CFG->wwwroot);
        }

        if (!empty($CFG->registerauth)) {
            $authplugin = get_auth_plugin($CFG->registerauth);
            if ($authplugin->can_signup()) {
                $signup = $wwwroot . '/login/signup.php';
            }
        }
        // TODO: now that we have multiauth it is hard to find out if there is a way to change password
        $forgot = $wwwroot . '/login/forgot_password.php';

        if (!empty($CFG->loginpasswordautocomplete)) {
            $autocomplete = 'autocomplete="off"';
        } else {
            $autocomplete = '';
        }

        $username = get_moodle_cookie();

        $this->content = new stdClass();
        $this->content->footer = '';
        $this->content->text = '';

        if (!isloggedin() or isguestuser()) {   // Show the block

            require_once($CFG->dirroot . '/auth/googleoauth2/lib.php'); 
            echo '
                <script language="javascript">
                    linkElement = document.createElement("link");
                    linkElement.rel = "stylesheet";
                    linkElement.href = "' . $CFG->wwwroot . '/auth/googleoauth2/csssocialbuttons/css/zocial.css";
                    document.head.appendChild(linkElement);
                </script>
            ';
            $this->content->text .= "\n".'<form class="loginform" id="login" method="post" action="'.get_login_url().'" '.$autocomplete.'>';

            $displayprovider = ((empty($authprovider) || $authprovider == 'google' || $allauthproviders) && get_config('auth/googleoauth2', 'googleclientid'));
            $providerdisplaystyle = $displayprovider?'display:inline-block;padding:10px;':'display:none;';
            $this->content->text .= '<div class="c1 fld username"><label for="login_username">'.get_string('username').'</label>';

            $this->content->text .= '<input type="text" name="username" id="login_username" value="'.s($username).'" /></div>';

            $this->content->text .= '<div class="c1 fld password"><label for="login_password">'.get_string('password').'</label>';

            $this->content->text .= '<input type="password" name="password" id="login_password" value="" '.$autocomplete.' /></div>';
            if (isset($CFG->rememberusername) and $CFG->rememberusername == 2) {
                $checked = $username ? 'checked="checked"' : '';
                $this->content->text .= '<div class="c1 rememberusername"><input type="checkbox" name="rememberusername" id="rememberusername" value="1" '.$checked.'/>';
                $this->content->text .= ' <label for="rememberusername">'.get_string('rememberusername', 'admin').'</label></div>';
            }

            $this->content->text .= '<div class="c1 btn"><input type="submit" value="'.get_string('login').'" /></div>';

            $this->content->text .= "\n".'<a class="zocial googleplus" href="https://accounts.google.com/o/oauth2/auth?client_id='. get_config('auth/googleoauth2', 'googleclientid') .'&redirect_uri='.$CFG->wwwroot .'/auth/googleoauth2/google_redirect.php&scope=https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email&response_type=code">
                Sign-in with Google
            </a> ';

            $this->content->text .= "</form>\n";

            if (!empty($signup)) {
                $this->content->footer .= '<div><a href="'.$signup.'">'.get_string('startsignup').'</a></div>';
            }
        }

        return $this->content;
    }
}



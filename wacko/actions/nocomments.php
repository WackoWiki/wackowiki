<?php

/*
 No Comments Action

 Used with no arguments means that comments are hidden for ALL users.
 If allow_registered is set then registered users are allowed to see the comments.

 {{nocomments
 [allow_registered="true"]
 }}
 */
$this->config["hide_comments"] = !$allow_registered ? 1 : 2;

?>
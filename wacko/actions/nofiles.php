<?php
/*
 No Files Action

 Used with no arguments means that files are hidden for ALL users.
 If allow_registered is set then registered users are allowed to see the files.

 {{nocomments
 [allow_registered="true"]
 }}
 */
$this->config["hide_files"] = !$allow_registered ? 1 : 2;
?>
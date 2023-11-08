<?php

/** @global object $USER */

// Редиректим случайно попавших на страницу
if ((empty($_GET['USER_CHECKWORD']) && empty($_GET['USER_LOGIN'])) || $USER->IsAuthorized()) LocalRedirect('/');


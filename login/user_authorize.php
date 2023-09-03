<?php require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');

if ($_POST['user_check'] = 'y') {
    global $USER;
    echo json_encode(['userAuthorize' => $USER->IsAuthorized()]);
}
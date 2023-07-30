<?php

Bitrix\Main\Loader::registerAutoloadClasses(
    'webcompany.referal.system',
    array(
        'WebCompany\WReferralsTable' => 'lib/WReferralsTable.php',
        'WebCompany\WebcompanyReferralSystem' => 'classes/mysql/WebcompanyReferralSystem.php',
    )
);
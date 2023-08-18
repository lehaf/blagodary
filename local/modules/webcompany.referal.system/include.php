<?php

Bitrix\Main\Loader::registerAutoloadClasses(
    'webcompany.referal.system',
    array(
        'WebCompany\WReferralsTable' => 'lib/WReferralsTable.php',
        'WebCompany\ReferralSystem' => 'classes/mysql/ReferralSystem.php',
    )
);
<?php

Bitrix\Main\Loader::registerAutoloadClasses(
    'webco.settings',
    array(
        'WebCompany\WReferralsTable' => 'lib/WReferralsTable.php',
        'WebCompany\WUserSubscriptionTable' => 'lib/WUserSubscriptionTable.php',
        'WebCompany\ReferralSystem' => 'classes/mysql/ReferralSystem.php',
    )
);
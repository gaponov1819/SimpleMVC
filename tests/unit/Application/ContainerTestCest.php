<?php

use ItForFree\SimpleMVC\Application;

class ContainerTestCest
{
    public function _before(UnitTester $I)
    {
    }

    // tests
    public function tryToTest(UnitTester $I)
    {
        $config = require(codecept_data_dir() . '/container/user-session-config.php');
        $App = Application::get();
        $App->setConfiguration($config);
        $App->getConfigObject('core.user.class');
    }
}

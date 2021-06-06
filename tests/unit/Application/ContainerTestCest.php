<?php

use ItForFree\SimpleMVC\Application;

require __DIR__ . '/support/ExampleUser.php';

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
        $User = $App->getConfigObject('core.user.class');
	$a = '123';
    }
}

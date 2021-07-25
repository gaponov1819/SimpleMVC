<?php

use ItForFree\SimpleMVC\Application;

require __DIR__ . '/support/ExampleUser.php';
require __DIR__ . '/support/Session.php';
require __DIR__ . '/support/testCache/OneClassCache.php';

class ContainerTestCest extends \Codeception\Test\Unit
{
    private $expectedResult;
   
    
    public function checkUserSessionPropertyExistsTest(UnitTester $I)
    {
        $config = require(codecept_data_dir() . '/container/user-session-config.php');
        $App = Application::get();
        $App->setConfiguration($config);
        $User = $App->getConfigObject('core.user.class');
        $I->assertSame($App->getConfigObject('core.session.class'), $User->session);
    }
}
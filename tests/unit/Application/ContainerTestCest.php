<?php

use ItForFree\SimpleMVC\Application;
use application\models\ExampleUser;
use application\models\Session;

require __DIR__ . '/support/ExampleUser.php';
require __DIR__ . '/support/Session.php';
require __DIR__ . '/support/testCache/OneClassCache.php';

class ContainerTestCest extends \Codeception\Test\Unit
{
    private $expectedResult;
   
    
//    public function _before(UnitTester $I)
//    {	   
//    }

    // tests  
    public function createDependecyRecurcively(UnitTester $I)
    {
        $config = require(codecept_data_dir() . '/container/user-session-config.php');
        $App = Application::get();
        $App->setConfiguration($config);
        $User = $App->getConfigObject('core.user.class');
        $I->assertSame($App->getConfigObject('core.session.class'), $User->session);
    }
    
    public function cacheTest(UnitTester $I)
    {
        $config = require(codecept_data_dir() . '/container/test-cache-config.php');
        $App = Application::get();
        $App->setConfiguration($config);
        $ObjectOne = $App->getConfigObject('core.OneClassCache.class');
        $I->assertSame(1, $ObjectOne::$countCreateObject);
        $ObjectTwo = $App->getConfigObject('core.OneClassCache.class');
        $I->assertSame(1, $ObjectTwo::$countCreateObject);
        $ObjectThree = $App->getConfigObject('core.OneClassCache.class');
        $I->assertSame(1, $ObjectThree::$countCreateObject);
        $ObjectFour = $App->getConfigObject('core.OneClassCache.class');
        $I->assertSame(1, $ObjectFour::$countCreateObject);
        $a = 10;
    }
}
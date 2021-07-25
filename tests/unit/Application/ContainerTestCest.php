<?php

use ItForFree\SimpleMVC\Application;
use application\models\ExampleUser;
use application\models\Session;

require __DIR__ . '/support/ExampleUser.php';
require __DIR__ . '/support/Session.php';


class ContainerTestCest extends \Codeception\Test\Unit
{
    private $expectedResult;
    
    public static $countObjects = null;
    
//    public function _before(UnitTester $I)
//    {	   
//    }

    // tests
    
    public function tryToTest(UnitTester $I)
    {
        $I->assertSame(1, 1);
    }
    
    
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
        $config = require(codecept_data_dir() . '/container/user-session-config.php');
        $App = Application::get();
        $App->setConfiguration($config);
        $ObjectOne = $App->getConfigObject('core.user.class');
        $I->assertSame(1, Application::$countCreateObjects);
        $ObjectTwo = $App->getConfigObject('core.session.class');
        $I->assertSame(2, Application::$countCreateObjects);
        $ObjectThree = $App->getConfigObject('core.session.class');
        $I->assertSame(2, Application::$countCreateObjects);
        $ObjectFour = $App->getConfigObject('core.user.class');
        $I->assertSame(2, Application::$countCreateObjects);
        $a = 10;
    }
}
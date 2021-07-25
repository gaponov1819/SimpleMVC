<?php

use ItForFree\SimpleMVC\Application;

require __DIR__ . '/support/containerElementsCaching/OneClassCache.php';
require __DIR__ . '/support/containerDependecyRecurcivelyCreation/First.php';
require __DIR__ . '/support/containerDependecyRecurcivelyCreation/Second.php';

class ContainerTestCest extends \Codeception\Test\Unit
{

    
//    public function _before(UnitTester $I)
//    {	   
//    }

    
        // tests  
    public function createDependecyRecurcivelyTest(UnitTester $I)
    {
        $config = require(codecept_data_dir() . '/container/dependecy-recurcively-creation-config.php');
        $App = Application::get();
        $App->setConfiguration($config);
        $First = $App->getConfigObject('core.first.class');
        $I->assertSame($App->getConfigObject('core.second.class'), $First->second);
    }
    
    public function cachingTest(UnitTester $I)
    {
        $config = require(codecept_data_dir() . '/container/test-cache-config.php');
        $App = Application::get();
        $App->setConfiguration($config);
        $ObjectOne = $App->getConfigObject('core.first.class');
        $I->assertSame(1, $ObjectOne::$countCreateObject);
        $ObjectTwo = $App->getConfigObject('core.second.class');
        $I->assertSame(2, $ObjectTwo::$countCreateObject);
        $ObjectThree = $App->getConfigObject('core.first.class');
        $I->assertSame(2, $ObjectThree::$countCreateObject);
        $ObjectFour = $App->getConfigObject('core.second.class');
        $I->assertSame(2, $ObjectFour::$countCreateObject);
        $a = 10;
    }   
  
}
<?php

use ItForFree\SimpleMVC\Application;

require __DIR__ . '/support/containerElementsCaching/OneClassCache.php';
require __DIR__ . '/support/containerDependecyRecurcivelyCreation/First.php';
require __DIR__ . '/support/containerDependecyRecurcivelyCreation/Second.php';
require __DIR__ . '/support/containerDependecyRecurcivelyCreation/Third.php';


class ContainerTest extends \Codeception\Test\Unit
{
    protected $tester;
      
    public function testCreateDependecyRecurcivelyTest()
    {
	$I = $this->tester;
        $config = require(codecept_data_dir() . '/container/dependecy-recurcively-creation-config.php');
        $App = Application::get();
        $App->setConfiguration($config);
        $First = $App->getConfigObject('core.first.class');
        $I->assertSame($App->getConfigObject('core.third.class'), $First->third);
    }
    
    public function testCachingTest()
    {
	$I = $this->tester;
	
        $config = require(codecept_data_dir() . '/container/test-cache-config.php');
        $App = Application::get();
        $App->setConfiguration($config);
        $ObjectOne = $App->getConfigObject('core.firstCache.class');
        $I->assertSame(1, $ObjectOne::$countCreateObject);
        $ObjectTwo = $App->getConfigObject('core.secondCache.class');
        $I->assertSame(2, $ObjectTwo::$countCreateObject);
        $ObjectThree = $App->getConfigObject('core.firstCache.class');
        $I->assertSame(2, $ObjectThree::$countCreateObject);
        $ObjectFour = $App->getConfigObject('core.secondCache.class');
        $I->assertSame(2, $ObjectFour::$countCreateObject);
    }   
  
}
<?php

use ItForFree\SimpleMVC\Application;

require __DIR__ . '/support/ExampleUser.php';

class UserTest extends \Codeception\Test\Unit
{
    protected $tester;
    
    public function testUserSessionPropertyExistsTest()
    {
	$I = $this->tester;
	
        $config = require(codecept_data_dir() . 'user/user-session-config.php');
        $App = Application::get();
        $App->setConfiguration($config);
        $User = $App->getConfigObject('core.user.class');
        $I->assertSame($App->getConfigObject('core.session.class'), $User->Session);
        $I->assertSame($App->getConfigObject('core.router.class'), $User->router);
    }
}
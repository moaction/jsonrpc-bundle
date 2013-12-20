<?php

namespace Moaction\JsonrpcBundle\Tests\Controller;

use Moaction\Jsonrpc\Bundle\Controller\JsonrpcController;
use Moaction\Jsonrpc\Bundle\Tests\Controller\Resources\EmptyTestController;
use Moaction\Jsonrpc\Bundle\Tests\Controller\Resources\FullTestController;

class JsonrpcControllerTest extends \PHPUnit_Framework_TestCase {
	/**
	 * @param JsonrpcController $controller
	 * @param $expected
	 * @dataProvider providerTestGetMethods
	 * @covers \Moaction\JsonrpcBundle\Controller\JsonrpcController::getMethods
	 */
	public function testGetMethods(JsonrpcController $controller, $expected)
	{
		$reflection = new \ReflectionObject($controller);
		$method = $reflection->getMethod('getMethods');
		$method->setAccessible(true);
		$result = $method->invoke($controller);

		$this->assertEquals($expected, $result);
	}

	/**
	 * @return array
	 */
	public function providerTestGetMethods()
	{
		return array(
			'Empty controller' => array(new EmptyTestController(), array()),
			'Full controller'  => array(new FullTestController(), array(
				'getUser'     => 'getUserMethod',
				'getComments' => 'getCommentsMethod',
			)),
		);
	}
}
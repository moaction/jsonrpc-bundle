<?php

namespace Moaction\Jsonrpc\Bundle\Controller;

use Moaction\Jsonrpc\Server\BasicServer;
use Moaction\Jsonrpc\Server\ServerInterface;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class JsonrpcController extends ContainerAware {
	/**
	 * @param Request $request
	 * @return Response
	 */
	public function executeAction(Request $request)
	{
		$data = $request->getContent();

		$server = $this->getServer();
		foreach ($this->getMethods() as $name => $method) {
			$server->addMethod($name, array($this, $method));
		}
		$result = $server->run($data);

		return new Response($result);
	}

	/**
	 * @return array
	 */
	protected function getMethods()
	{
		$reflection = new \ReflectionObject($this);
		$methods = array();
		foreach ($reflection->getMethods(\ReflectionMethod::IS_PUBLIC) as $method) {
			$name = $method->getName();
			if (substr($name, -6) === 'Method') {
				$methods[substr($name, 0, -6)] = $name;
			}
		}

		return $methods;
	}

	/**
	 * @return ServerInterface
	 */
	protected function getServer()
	{
		return new BasicServer();
	}
}
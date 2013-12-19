Jsonrpc-bundle
==============

Symfony2 bundle with JSON-Rpc 2.0 protocol implementation

http://www.jsonrpc.org/specification

Usage
-----

1. Create a controller that extends \Moaction\JsonrpcBundle\Controller\JsonrpcController
2. Add routing for 'execute' method
3. Add some public methods with 'Method' postfix
4. Enjoy the magic!

Example
-------

### Controller
```php
class ApiController extends \Moaction\JsonrpcBundle\Controller\JsonrpcController {
  public function getUserMethod($id) {
    return 'User id is ' . $id;
  }

  public function getUserPostMethod($userId, $postId) {
    return array(
     'userId' => $userId,
     'postId' => $postId
    );
  }
}
```

### Routing
```yml
AcmeBundle_jsonrpc_api:
    pattern:  /api
    defaults: { _controller: AcmeBundle:Api:execute }
```

### Request example

```
--> {"jsonrpc": "2.0", "method": "getUser", "params": {"id": 23}, "id": 1}
<-- {"jsonrpc": "2.0", "id": 1, "result": "User id is 23"}
```

```
--> {"jsonrpc": "2.0", "method": "getUserPost", "params": {"userId": 23, "postId": 456}, "id": 2}
<-- {"jsonrpc": "2.0", "id": 2, "result": {"userId": 23, "postId": 456}}
```
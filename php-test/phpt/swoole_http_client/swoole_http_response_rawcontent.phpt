--TEST--
swoole_http_response: rawcontent

--SKIPIF--
<?php require __DIR__ . "/../inc/skipif.inc"; ?>
--INI--
assert.active=1
assert.warning=1
assert.bail=0
assert.quiet_eval=0

--FILE--
<?php
/**
 * Created by IntelliJ IDEA.
 * User: chuxiaofeng
 * Date: 17/6/7
 * Time: 下午3:04
 */

require_once __DIR__ . "/../inc/zan.inc";
require_once __DIR__ . "/../../apitest/swoole_http_client/simple_http_client.php";

$simple_http_server = __DIR__ . "/../../apitest/swoole_http_server/simple_http_server.php";
$closeServer = start_server($simple_http_server, HTTP_SERVER_HOST, $port = get_one_free_port());

$payload = RandStr::gen(1024 * 1024);
testRawcontent(HTTP_SERVER_HOST, $port, $payload, function(\swoole_http_client $cli) use($closeServer, $payload) {
    assert($cli->body === $payload);
    echo "SUCCESS";
    $closeServer();
});

suicide(1000, SIGTERM, $closeServer);
?>
--EXPECT--
SUCCESS
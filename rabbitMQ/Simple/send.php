<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 25/08/16
 * Time: 9:00
 */
require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$connection = new AMQPStreamConnection('172.17.0.2', 5672, 'guest', 'guest');
$channel = $connection->channel();

$channel->queue_declare('hello', false, false, false, false);

$count = 1;

while($count <= 5) {
    $msg = new AMQPMessage("Hello World! $count");
    $channel->basic_publish($msg, '', 'hello');
    echo " [x] Sent 'Hello World!' $count \n";
    $count++;
}

$channel->close();
$connection->close();
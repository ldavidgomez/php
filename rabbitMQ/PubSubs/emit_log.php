<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 25/08/16
 * Time: 12:41
 */
require_once '../vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$connection = new AMQPStreamConnection('172.17.0.2', 5672, 'guest', 'guest');

$channel = $connection->channel();
$channel->exchange_declare('logs', 'fanout', false, false, false);

$data = implode(' ', array_slice($argv, 1));
if(empty($data)) $data = "info: Hello World!";

$msg = new AMQPMessage($data);
$channel->basic_publish($msg, 'logs');

echo " [x] Sent ", $data, "\n";

$channel->close();
$connection->close();
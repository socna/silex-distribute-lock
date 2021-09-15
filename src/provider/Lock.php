<?php 

namespace com\chauhm\provider;

use RedisClient\ClientFactory;
use RedisLock\RedisLock;

class Lock {
    private $client;
    public function __construct($server = '127.0.0.1:6378') {
        $this->client = ClientFactory::create([
            'server' => 'tcp://' . $server
        ]) ;
    }

    public function getLock($key) {
        return new RedisLock(
            $this->client, // Instance of RedisClient,
            $key // Key in storage,
        ); 
    }
}
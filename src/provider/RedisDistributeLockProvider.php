<?php

namespace com\chauhm\provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

class RedisDistributeLockProvider implements ServiceProviderInterface {

    public function __construct($prefix = 'redlock')
    {
        if (empty($prefix)) {
            throw new \InvalidArgumentException('The specified prefix is not valid.');
        }

        $this->prefix = $prefix;
    }

    protected function getClient(Container $app, $prefix){
        return new Lock($app[$prefix.'.server']);
    }

    public function register(Container $app)
    {
        $prefix = $this->prefix;
        $app[$prefix.'.server'] = '';
        $app[$prefix] = $this->getClient($app, $prefix);
    }
}
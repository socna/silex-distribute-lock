<?php

namespace com\chauhm\provider;

use com\chauhm\distributelock\RedLock;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class RedLockServiceProvider implements ServiceProviderInterface {

    public function __construct($prefix = 'redlock')
    {
        if (empty($prefix)) {
            throw new \InvalidArgumentException('The specified prefix is not valid.');
        }

        $this->prefix = $prefix;
    }

    protected function getClient(Container $app, $prefix){
        return new RedLock($app[$prefix.'.config']['server'], $app[$prefix.'.config']['retryDelay'], $app[$prefix.'.config']['retryCount']);
    }



    public function register(Container $app)
    {
        $prefix = $this->prefix;
        $app[$prefix.'.config'] = [];
        $app[$prefix] = $this->getClient($app, $prefix);
    }
}
<?php

require_once 'vendor/autoload.php';

$hosts = [
    'https://localhost',        // SSL to localhost
];

$client = Elasticsearch\ClientBuilder::create()           // Instantiate a new ClientBuilder
                    ->setHosts($hosts)      // Set the hosts
                    ->build();              // Build the client object
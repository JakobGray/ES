<?php

require '../vendor/autoload.php';

use Elasticsearch\ClientBuilder;

$es = ClientBuilder::create()->build();

//$hosts = [
//    'https://localhost',        // SSL to localhost
//];

//$es = new Elasticsearch\Client([
//    'hosts' => ['127.0.0.1:9200']
//]);

//$client = Elasticsearch\ClientBuilder::create()           // Instantiate a new ClientBuilder
//                    ->setHosts($hosts)      // Set the hosts
//                    ->build();              // Build the client object
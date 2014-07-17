Guzzle Async plugin
=====

### Add to composer
    "ponteiro/guzzle": "1.*"
    
    "repositories" : [
            "type" : "vcs",
            "url"  : "https://github.com/jmeireles/async.git"
        }
    ]

###How to use

    use Guzzle\Http\Client;
    use Ponteiro\Guzzle\Plugin\AsyncPlugin;
    
    $client = new Client('http://www.example.com');
    $client->addSubscriber(new AsyncPlugin());
    $client->get()->send();

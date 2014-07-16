Guzzle Async plugin
=====


###How to use

    use Guzzle\Http\Client;
    use Ponteiro\Guzzle\Plugin\AsyncPlugin;
    
    $client = new Client('http://www.example.com');
    $client->addSubscriber(new AsyncPlugin());
    $client->get()->send();

<?php

namespace Ponteiro\Guzzle\Plugin;

use Guzzle\Common\Event;
use Guzzle\Http\Message\Response;
use Guzzle\Http\Exception\CurlException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 *
 *
 * @package    Ponteiro/Guzzle
 * @category   Plugin
 * @author     Jorge Meireles
 * @copyright  (c) 2014 Ponteiro Team
 */
class AsyncPlugin implements EventSubscriberInterface
{
    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            'request.before_send'    => 'onBeforeSend',
            'request.exception'      => 'onRequestTimeout',
            'request.sent'           => 'onRequestSent'
        );
    }

    /**
     * Add Curl timeout to 1 ms
     *
     * @param Event $event
     */
    public function onBeforeSend(Event $event)
    {
        $event['request']->getCurlOptions()->set(CURLOPT_TIMEOUT_MS, 1);
    }


    /**
     * Since we set Curl timeout to 1MS we know for sure that he will throw an exception
     * when he does we set a new response ( simulates that he finished )
     * @param Event $event
     */
    public function onRequestTimeout(Event $event)
    {
        if ($event['exception'] instanceof CurlException) {
            $event['request']->setResponse(new Response(200, array(
                'Ponteiro-AsyncRequest', 'Did not wait for the response.'
            )));
        }
    }

    /**
     * After it's done we edit the response so we know
     * @param Event $event
     */
    public function onRequestSent(Event $event)
    {
        // Let the caller know this was meant to be async
        $event['request']->getResponse()->setHeader('Ponteiro-AsyncRequest', 'Did not wait for the response.');
    }
}


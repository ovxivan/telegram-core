<?php

namespace Ovxivan\Telegram\System;

use Ovxivan\Telegram\System\Benchmark;
use Ovxivan\Telegram\Entities\All\Message;

class Bot
{
    private static self|null $instance;

    public static function make(string $key): self
    {
        self::$instance = new self;
        self::$instance->setKey($key);
        return self::$instance;
    }

    public static function get()
    {
        return self::$instance;
    }

    public function setKey($key): void
    {
        $this->key = $key;
    }

    public function send(
        Message $message
    )
    {
        $method = 'sendMessage';
        return $this->apiCall($method, $message->render());
    }

    public function sendPhoto(
        Message $message
    ):string
    {
        $method = 'sendPhoto';
        return $this->apiCall($method, $message->render());
    }

    public function answer(Message $message)
    {
        $method = 'answerCallbackQuery';
        return $this->apiCall($method, $message->render());
    }

    public function edit(Message $message)
    {
        $method = 'editMessageText';
        $message->edit();
        print_r($message->render());
        return $this->apiCall($method, $message->render());
    }

    public function editCaption(Message $message)
    {
        $method = 'editMessageCaption';
        $message->edit();
        return $this->apiCall($method, $message->render());
    }

    public function getUpdates($callback, $timeout = 500000)
    {
        $method = 'getUpdates';
        $offset = -1;
        $benchmark = new Benchmark();
        while (true) {
            $benchmark->setStart();
            print_r([
                'get_update_request' => true,
            ]);
            $response = $this->apiCall($method, ['offset' => $offset]);
            print_r([
                'get_update_response' => true,
                'time' => $benchmark->result(),
            ]);
            $response = json_decode($response, true);
            if (!empty($response['result'])) {
                foreach ($response['result'] as $item) {
                    $callback($item);
                    $offset = $item['update_id'] + 1;
                }
            }
            usleep($timeout);
        }
    }

    private function apiCall($method, $params)
    {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $this->getUrl($method),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $params,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_HTTPHEADER => [
                'Connection' => 'keep-alive',
                'Keep-Alive' => 'timeout=5, max=100',
            ]
        ]);

        $result = curl_exec($curl);
        curl_close($curl);
        return $result;
    }

    public function getUrl($method): string
    {
        return sprintf('https://api.telegram.org/bot%s/%s', $this->key, $method);
    }
}
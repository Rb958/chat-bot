<?php


namespace App\Utils\WitApi;


class Wit
{
//    private $apiUrl;
//    private $message;
    private $token;

    private static $wit;

    public static function create(string $token){
        if(self::$wit == null){
            return new Wit($token);
        }
        return self::$wit;
    }

    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Send text to NLP wit.ai
     * @param $text string
     * @return WitResponse
     */
    public function sendText(string $text): WitResponse {
        $wrb = new WItResponseBuilder();

        $httpClient = curl_init();
        curl_setopt_array($httpClient,array(
            CURLOPT_URL => 'https://api.wit.ai/message?v=20200827&q='. urlencode($text),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer '. $this->token
            ]
        ));

        $response = curl_exec($httpClient);

        curl_close($httpClient);

        $data = json_decode($response,true);

        if(is_array($data) and !empty($response) and is_string($response)){

            $wrb->setText(
                (isset($data['text'])) ? $data['text'] : ""
            );

            if(isset($data['intents']) and !empty($data['intents'])){
                $intents = [];
                foreach ($data['intents'] as $item){
                    $intent = new WitIntent();
                    $intent->setConfidence($item['confidence']);
                    $intent->setId($item['id']);
                    $intent->setName($item['name']);

                    $intents[] = $intent;
                }
                $wrb->setIntents($intents);
            }

            if (isset($data['entities']) and !empty($data['entities'])){
                $entities = [];

                foreach ($data['entities'] as $element){
                    foreach ($element as $item){
                        $entity = new WitEntity();
                        $entity->setId($item['id']);
                        $entity->setName($item['name']);
                        $entity->setRole($item['role']);
                        $entity->setStart($item['start']);
                        $entity->setEnd($item['end']);
                        $entity->setBody($item['body']);
                        $entity->setConfidence($item['confidence']);
                        $entity->setValue($item['value']);
                        $entity->setType($item['type']);
                        $entities[] = $entity;
                    }
                    $wrb->setEntities($entities);
                }

            }

            if (isset($data['traits'])){

                $traits = [];

                $wrb->setTraits($traits);
            }

        }


        return $wrb->build();
    }
}
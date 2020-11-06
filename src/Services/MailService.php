<?php

namespace App\Services;

use \Swift_Mailer;
use \Swift_Message;
use Twig\Environment;
use \Swift_Attachment;
use Symfony\Component\HttpFoundation\Session\Session;
//use App\Manager\ParamsManager;
//use App\Service\HttpService;


class MailService
{

    private $mailer;

    private $twig;

    private $params;

    private $http;


    public function __construct(Swift_Mailer $mailer, Environment $twig) // ParamsManager $params, HttpService $http
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
//        $this->params = $params;
//        $this->http = $http;
    }

    public function send(string $from, array $email, string $object, string $content = "")
    {
        $this->full($from, $email, $object, $content);
    }


    public function sms(string $sender, string $phone, string $message, $country = "CM")
    {
        $sms = array('sender' => $sender,
            'phone' => $phone,
            'message' => $message,
            'country' => $country
            );
        $response = $this->http->sendPost($this->params->get('messaging_sms'), $sms);
        return $response;
    }


    public function full(
        string $from,
        array $email,
        string $object,
        string $content = null,
        $data = null,
        array $attach = null,
        string $temp = "emails/agent_account.html.twig"
    ) {
        $message = (new Swift_Message($object))
//            ->setFrom(['contact@afrikpay.com' => $from])
            ->setFrom(['richiebayless@gmail.com' => $from])
            ->setTo($email)
            ->setBody(
                $this->twig->render(
                    // templates/emails/registration.html.twig
                    $temp,
                    ['data' => $data,
                     'content' => $content]
                ),
                'text/html'
            )

            // you can remove the following code if you don't define a text version for your emails
            ->addPart(
                $this->twig->render(
                    // templates/emails/registration.txt.twig
                    'emails/base.txt.twig',
                    ['content' => $content]
                ),
                'text/plain'
            )
        ;
        
        if ($attach != null) {
            foreach ($attach as $value) {
                // Code to be executed
                $message->attach(Swift_Attachment::fromPath($value));
            }
        }
        

        $this->mailer->send($message);
    }


    public function __toString(){
        return "Mailer loaded";
    }
}
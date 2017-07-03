<?php

namespace Webaccess\WineSupervisorLaravel\Services;

use DateTimeZone;
use GuzzleHttp\Client;

class CellierDomesticusAPI
{
    private $client;

    public function __construct()
    {
        $this->client = new Client(
            ['base_uri' => env('CD_API_URL')]
        );
    }

    private function generateWSSEToken()
    {
        $nonce = $this->generateNonce();
        $created = $this->generateCreated();
        $passwordDigest = $this->generatePasswordDigest($nonce, $created);

        return sprintf('Username="%s", PasswordDigest="%s", Nonce="%s", Created="%s"', env('CD_API_USERNAME'), $passwordDigest, $nonce, $created);
    }

    private function generateNonce()
    {
        return base64_encode(sha1(time(), true));
    }

    private function generateCreated()
    {
        return gmdate('Y-m-d\TH:i:s\Z');
    }

    private function generatePasswordDigest($nonce, $created)
    {
        return base64_encode(sha1(base64_decode($nonce).$created.env('CD_API_SECRET'), true));
    }

    public function create_user()
    {
        $res = $this->client->request('POST', '/api/users', [
            'debug' => true,
            'json' => [
                'username' => 'testusername4',
                'email' => 'test@testemail4.fr',
                'plainPassword' => '111aaa',
                'type' => 'user',
                'lastName' => 'test lastname',
                'firstName' => 'test firstname',
                'address' => '1, rue test',
                'zipcode' => '73000',
                'city' => 'CHAMBERY',
                'country' => 'FR',
                'phone' => '0611061106',
                'mobile' => '0611061106',
            ],
            'headers' => [
                'Authorization' => 'profile="UsernameToken"',
                'X-WSSE' => 'UsernameToken ' . $this->generateWSSEToken()
            ]
        ]);
        echo $res->getStatusCode();
        dd($res, $res->getBody());
    }

    public function activate_cellar()
    {
        $userID = 48;
        $key = '59565F1BD93A4';

        $res = $this->client->request('POST', sprintf('/api/users/%s/activate-cellar/%s', $userID, $key), [
            'debug' => true,
            'json' => [
                'name' => 'ma cave',
                'timezone' => DateTimeZone::EUROPE,
                'degreeType' => 'celcius',
            ],
            'headers' => [
                'Authorization' => 'profile="UsernameToken"',
                'X-WSSE' => 'UsernameToken ' . $this->generateWSSEToken()
            ]
        ]);
        echo $res->getStatusCode();
        dd($res, $res->getBody());
    }
}
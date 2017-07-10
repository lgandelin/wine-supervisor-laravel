<?php

namespace Webaccess\WineSupervisorLaravel\Services;

use DateTimeZone;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Webaccess\WineSupervisorLaravel\Models\Cellar;
use Webaccess\WineSupervisorLaravel\Models\Technician;
use Webaccess\WineSupervisorLaravel\Models\User;

class CellierDomesticusAPI
{
    private $client;

    public function __construct()
    {
        $this->client = new Client(
            ['base_uri' => env('CD_API_URL')]
        );
    }

    private function generateWSSEToken($userName = null, $userPassword = null)
    {
        if (!$userName) $userName = env('CD_API_USERNAME');
        if (!$userPassword) $userPassword = env('CD_API_PASSWORD');

        $nonce = $this->generateNonce();
        $created = $this->generateCreated();
        $passwordDigest = $this->generatePasswordDigest($nonce, $created, $userPassword);

        return sprintf('Username="%s", PasswordDigest="%s", Nonce="%s", Created="%s"', $userName, $passwordDigest, $nonce, $created);
    }

    private function generateNonce()
    {
        return base64_encode(sha1(time(), true));
    }

    private function generateCreated()
    {
        return gmdate('Y-m-d\TH:i:s\Z');
    }

    private function generatePasswordDigest($nonce, $created, $password)
    {
        return base64_encode(sha1(base64_decode($nonce).$created.$password, true));
    }

    public function create_user(User $user)
    {
        $requestData = [
            'json' => [
                'username' => 'testusername10',
                'email' => 'test@testemail10.fr',
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
        ];

        Log::info('API_CREATE_USER_REQUEST', $requestData);

        /*if ($response = $this->client->request('POST', '/api/users', $requestData)) {
            $result = $response->getBody()->getContents();
            $resultObject = json_decode($result);

            Log::info('API_CREATE_USER_RESPONSE', [
                'success' => $resultObject->status,
                'status_code' => $response->getStatusCode(),
                'body' => $result
            ]);

            //Store the CD userID and password
            $user->cd_user_id = $resultObject->data->id;
            $user->cd_password = $resultObject->data->password;
            $user->save();
        } else {
            Log::info('API_CREATE_USER_RESPONSE', [
                'success' => false,
            ]);

            //TODO : Re-launch the request
        }*/
    }

    public function create_technician(Technician $technician)
    {
        $requestData = [
            'json' => [
                'username' => 'testtechnician',
                'email' => 'test@testemail11.fr',
                'plainPassword' => '222bbb',
                'type' => 'technician',
                'lastName' => 'technician lastname',
                'firstName' => 'technician firstname',
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
        ];

        Log::info('API_CREATE_TECHNICIAN_REQUEST', $requestData);

        if ($response = $this->client->request('POST', '/api/users', $requestData)) {
            $result = $response->getBody()->getContents();
            $resultObject = json_decode($result);

            Log::info('API_CREATE_TECHNICIAN_RESPONSE', [
                'success' => $resultObject->status,
                'status_code' => $response->getStatusCode(),
                'body' => $result
            ]);

            //Store the CD userID and password
            $technician->cd_user_id = $resultObject->data->id;
            $technician->cd_password = $resultObject->data->password;
            $technician->save();
        } else {
            Log::info('API_CREATE_TECHNICIAN_RESPONSE', [
                'success' => false,
            ]);

            //TODO : Re-launch the request
        }
    }

    public function activate_cellar(Cellar $cellar)
    {
        $userID = 39;
        $key = '59565F1BD93A4';

        $requestData = [
            'json' => [
                'name' => 'ma cave',
                'timezone' => DateTimeZone::EUROPE,
                'degreeType' => 'celcius',
            ],
            'headers' => [
                'Authorization' => 'profile="UsernameToken"',
                'X-WSSE' => 'UsernameToken ' . $this->generateWSSEToken()
            ]
        ];

        Log::info('API_ACTIVATE_CELLAR_REQUEST', $requestData);

        if ($response = $this->client->request('POST', sprintf('/api/users/%s/activate-cellar/%s', $userID, $key), $requestData)) {
            $result = $response->getBody()->getContents();
            $resultObject = json_decode($result);

            Log::info('API_ACTIVATE_CELLAR_RESPONSE', [
                'success' => $resultObject->status,
                'status_code' => $response->getStatusCode(),
                'body' => $result
            ]);

            //Store the CD userID and password
            $cellar->cd_cellar_id = $resultObject->data->id;
            $cellar->save();
        } else {
            Log::info('API_ACTIVATE_CELLAR_RESPONSE', [
                'success' => false,
            ]);

            //TODO : Re-launch the request
        }
    }

    public function login_user(User $user)
    {
        $requestData = [
            'headers' => [
                'Authorization' => 'profile="UsernameToken"',
                'X-WSSE' => 'UsernameToken ' . $this->generateWSSEToken($user->login, $user->cd_password)
            ]
        ];

        Log::info('API_LOGIN_USER_REQUEST', $requestData);

        if ($response = $this->client->request('POST', '/api/login', $requestData)) {
            $result = $response->getBody()->getContents();
            $resultObject = json_decode($result);

            Log::info('API_LOGIN_USER_RESPONSE', [
                'success' => $resultObject->status,
                'status_code' => $response->getStatusCode(),
                'body' => $result
            ]);

            return $resultObject;
        } else {
            Log::info('API_LOGIN_USER_RESPONSE', [
                'success' => false,
            ]);

            //TODO : Re-launch the request
        }
    }
}
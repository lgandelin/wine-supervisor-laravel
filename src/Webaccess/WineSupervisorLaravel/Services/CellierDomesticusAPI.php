<?php

namespace Webaccess\WineSupervisorLaravel\Services;

use DateTimeZone;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Webaccess\WineSupervisorLaravel\Models\Cellar;
use Webaccess\WineSupervisorLaravel\Models\Technician;
use Webaccess\WineSupervisorLaravel\Models\User;
use Webaccess\WineSupervisorLaravel\Repositories\CellarRepository;

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
                'username' => $user->login,
                'email' => $user->email,
                'plainPassword' => $user->password,
                'type' => 'user',
                'lastName' => $user->last_name,
                'firstName' => $user->first_name,
                'address' => $user->address . ' ' . $user->address2,
                'zipcode' => $user->zipcode,
                'city' => $user->city,
                'country' => $user->country,
                'phone' => $user->phone,
            ],
            'headers' => [
                'Authorization' => 'profile="UsernameToken"',
                'X-WSSE' => 'UsernameToken ' . $this->generateWSSEToken()
            ]
        ];

        Log::info('API_CREATE_USER_REQUEST', $requestData);

        if ($response = $this->client->request('POST', '/api/users', $requestData)) {
            $result = $response->getBody()->getContents();
            $resultObject = json_decode($result);

            $data = json_decode($resultObject->data);

            Log::info('API_CREATE_USER_RESPONSE', [
                'success' => $resultObject->status,
                'status_code' => $response->getStatusCode(),
                'body' => $result
            ]);

            //Store the CD userID and password
            $user->cd_user_id = $data->id;
            $user->cd_password = $data->password;
            $user->save();

            return $user->cd_user_id;
        } else {
            Log::info('API_CREATE_USER_RESPONSE', [
                'success' => false,
            ]);
        }
    }

    public function create_technician(Technician $technician)
    {
        $requestData = [
            'json' => [
                'username' => $technician->login,
                'email' => $technician->email,
                'plainPassword' => $technician->password,
                'type' => 'technician',
                'lastName' => $technician->company,
                'address' => $technician->address . ' ' . $technician->address2,
                'zipcode' => $technician->zipcode,
                'city' => $technician->city,
                'country' => $technician->country,
                'phone' => $technician->phone,
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

            $data = json_decode($resultObject->data);

            Log::info('API_CREATE_TECHNICIAN_RESPONSE', [
                'success' => $resultObject->status,
                'status_code' => $response->getStatusCode(),
                'body' => $result
            ]);

            //Store the CD userID and password
            $technician->cd_user_id = $data->id;
            $technician->cd_password = $data->password;
            $technician->save();
        } else {
            Log::info('API_CREATE_TECHNICIAN_RESPONSE', [
                'success' => false,
            ]);
        }
    }

    public function activate_cellar($userID, $cellarID, $activationCode, $cellarName)
    {
        $requestData = [
            'json' => [
                'name' => $cellarName ? $cellarName : 'Ma cave',
                'timezone' => DateTimeZone::EUROPE,
                'degreeType' => 'celcius',
            ],
            'headers' => [
                'Authorization' => 'profile="UsernameToken"',
                'X-WSSE' => 'UsernameToken ' . $this->generateWSSEToken()
            ]
        ];

        Log::info('API_ACTIVATE_CELLAR_REQUEST', [
            'request' => $requestData,
            'user_id' => $userID,
            'cellar_id' => $cellarID,
            'activation_code' => $activationCode
        ]);

        if ($response = $this->client->request('POST', sprintf('/api/users/%s/activate-cellar/%s', $userID, $activationCode), $requestData)) {
            $result = $response->getBody()->getContents();
            $resultObject = json_decode($result);

            $data = json_decode($resultObject->data);

            Log::info('API_ACTIVATE_CELLAR_RESPONSE', [
                'success' => $resultObject->status,
                'status_code' => $response->getStatusCode(),
                'body' => $result
            ]);

            //Store the CD userID and password
            if ($cellar = CellarRepository::getByID($cellarID)) {
                $cellar->cd_cellar_id = $data->id;
                $cellar->save();
            }
        } else {
            Log::info('API_ACTIVATE_CELLAR_RESPONSE', [
                'success' => false,
            ]);
        }
    }

    public function login_user($user)
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
        }
    }

    public function update_user(User $user)
    {
        $requestData = [
            'json' => [
                'username' => $user->login,
                'email' => $user->email,
                'lastName' => $user->last_name,
                'firstName' => $user->first_name,
                'address' => $user->address . ' ' . $user->address2,
                'zipcode' => $user->zipcode,
                'city' => $user->city,
                'country' => $user->country,
                'phone' => $user->phone,
            ],
            'headers' => [
                'Authorization' => 'profile="UsernameToken"',
                'X-WSSE' => 'UsernameToken ' . $this->generateWSSEToken()
            ]
        ];

        Log::info('API_UPDATE_USER_REQUEST', $requestData);

        if ($response = $this->client->request('PUT', sprintf('/api/users/%s', $user->cd_user_id), $requestData)) {
            $result = $response->getBody()->getContents();
            $resultObject = json_decode($result);

            Log::info('API_UPDATE_USER_RESPONSE', [
                'success' => $resultObject->status,
                'status_code' => $response->getStatusCode(),
                'body' => $result
            ]);
        } else {
            Log::info('API_UPDATE_USER_RESPONSE', [
                'success' => false,
            ]);
        }
    }

    public function update_technician(Technician $technician)
    {
        $requestData = [
            'json' => [
                'username' => $technician->login,
                'email' => $technician->email,
                'lastName' => $technician->company,
                'address' => $technician->address . ' ' . $technician->address2,
                'zipcode' => $technician->zipcode,
                'city' => $technician->city,
                'country' => $technician->country,
                'phone' => $technician->phone,
            ],
            'headers' => [
                'Authorization' => 'profile="UsernameToken"',
                'X-WSSE' => 'UsernameToken ' . $this->generateWSSEToken()
            ]
        ];

        Log::info('API_UPDATE_TECHNICIAN_REQUEST', $requestData);

        if ($response = $this->client->request('PUT', sprintf('/api/users/%s', $technician->cd_user_id), $requestData)) {
            $result = $response->getBody()->getContents();
            $resultObject = json_decode($result);

            Log::info('API_UPDATE_TECHNICIAN_RESPONSE', [
                'success' => $resultObject->status,
                'status_code' => $response->getStatusCode(),
                'body' => $result
            ]);
        } else {
            Log::info('API_UPDATE_TECHNICIAN_RESPONSE', [
                'success' => false,
            ]);
        }
    }

    public function update_cellar(User $user, Cellar $cellar)
    {
        $requestData = [
            'json' => [
                'name' => $cellar->name ? $cellar->name : 'Ma cave',
                'address' => $cellar->address . ' ' . $cellar->address2,
                'zipcode' => $cellar->zipcode,
                'city' => $cellar->city,
                'country' => $cellar->country,
                'lat' => $cellar->latitude,
                'lng' => $cellar->longitude,
            ],
            'headers' => [
                'Authorization' => 'profile="UsernameToken"',
                'X-WSSE' => 'UsernameToken ' . $this->generateWSSEToken()
            ]
        ];

        Log::info('API_UPDATE_CELLAR_REQUEST', $requestData);

        if ($response = $this->client->request('PUT', sprintf('/api/cellars/%s', $cellar->cd_cellar_id), $requestData)) {
            $result = $response->getBody()->getContents();
            $resultObject = json_decode($result);

            Log::info('API_UPDATE_CELLAR_RESPONSE', [
                'success' => $resultObject->status,
                'status_code' => $response->getStatusCode(),
                'body' => $result
            ]);
        } else {
            Log::info('API_UPDATE_CELLAR_RESPONSE', [
                'success' => false,
            ]);
        }
    }

    public function affect_cellar(Cellar $cellar, Technician $technician)
    {
        $requestData = [
            'headers' => [
                'Authorization' => 'profile="UsernameToken"',
                'X-WSSE' => 'UsernameToken ' . $this->generateWSSEToken()
            ]
        ];

        Log::info('API_AFFECT_CELLAR_REQUEST', $requestData);

        if ($response = $this->client->request('POST', sprintf('/api/users/%s/affect-cellar/%s', $technician->cd_user_id, $cellar->cd_cellar_id), $requestData)) {
            $result = $response->getBody()->getContents();
            $resultObject = json_decode($result);

            Log::info('API_AFFECT_CELLAR_RESPONSE', [
                'success' => $resultObject->status,
                'status_code' => $response->getStatusCode(),
                'body' => $result
            ]);
        } else {
            Log::info('API_AFFECT_CELLAR_RESPONSE', [
                'success' => false,
            ]);
        }
    }

    public function unaffect_cellar(Cellar $cellar, Technician $technician)
    {
        $requestData = [
            'headers' => [
                'Authorization' => 'profile="UsernameToken"',
                'X-WSSE' => 'UsernameToken ' . $this->generateWSSEToken()
            ]
        ];

        Log::info('API_UNAFFECT_CELLAR_REQUEST', $requestData);

        if ($response = $this->client->request('POST', sprintf('/api/users/%s/unaffect-cellar/%s', $technician->cd_user_id, $cellar->cd_cellar_id), $requestData)) {
            $result = $response->getBody()->getContents();
            $resultObject = json_decode($result);

            Log::info('API_UNAFFECT_CELLAR_RESPONSE', [
                'success' => $resultObject->status,
                'status_code' => $response->getStatusCode(),
                'body' => $result
            ]);
        } else {
            Log::info('API_UNAFFECT_CELLAR_RESPONSE', [
                'success' => false,
            ]);
        }
    }
}
<?php

namespace Moathdev\Office365;

use Illuminate\Contracts\Container\Container;
use \League\OAuth2\Client\Provider\GenericProvider as GenericProvider;
use Microsoft\Graph\Graph;
use Microsoft\Graph\Model;


class Office365
{
    private $client;

    private $graph;

    public function __construct(Container $app)
    {
        $config = $app->make('config');


        $this->graph = new Graph();

        $this->client = new GenericProvider([
            'clientId'                => $config->get('Office365.appId'),
            'clientSecret'            => $config->get('Office365.secret'),
            'redirectUri'             => $config->get('Office365.redirect_url'),
            'urlAuthorize'            => $config->get('Office365.authority') . $config->get('Office365.authority_endpoint'),
            'urlAccessToken'          => $config->get('Office365.authority') . $config->get('Office365.authority_token'),
            'urlResourceOwnerDetails' => '',
            'scopes'                  => $config->get('Office365.scopes'),
        ]);


    }

    public function login()
    {
        return $this->client->getAuthorizationUrl();
    }

    public function getAccessToken($code)
    {
        $accessToken = $this->client->getAccessToken('authorization_code', [
            'code' => $code,
        ]);

        return [
            'token'        => $accessToken->getToken(),
            'RefreshToken' => $accessToken->getRefreshToken(),
            'expires'      => $accessToken->getExpires(),
        ];

    }

    public function getUserInfo($user_access_token)
    {
        $this->graph->setAccessToken($user_access_token);

        $user = $this->graph->createRequest('GET', '/me')
            ->execute();

        return $user->getBody();
    }

    public function getEmails($user_access_token, $limit = 10)
    {

        $this->graph->setAccessToken($user_access_token);

        $messageQueryParams = [
            "\$orderby" => "receivedDateTime DESC",
            "\$top"     => $limit,
        ];

        return $this->graph->createRequest('GET', '/me/mailfolders/inbox/messages?' . http_build_query($messageQueryParams))
            ->setReturnType(Model\Message::class)
            ->execute();
    }

}
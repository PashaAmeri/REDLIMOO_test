<?php

use Laravel\Passport\Client;
use Illuminate\Support\Facades\Hash;

//----------------- Constsnts

const CLIENT_SECRET = '99VSGAxp66Mkt6H05vzVWiF95FPWg8yNXfHyRMgj';

//----------------- functions

function checkClient(array $data): bool
{

    if (array_key_exists('client_id', $data) and array_key_exists('grant_type', $data) and array_key_exists('client_secret', $data)) {

        // get passport client data from db
        $client = Client::where('id', $data['client_id'])->where('password_client', $data['grant_type'] === 'password' ? 1 : 0)->first();

        if (is_null($client) or !Hash::check($data['client_secret'], $client->secret)) {

            return false;
        }
    }



    return true;
}

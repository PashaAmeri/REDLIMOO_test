<?php

use Laravel\Passport\Client;
use Illuminate\Support\Facades\Hash;

//----------------- functions

function checkClient(array $data): bool
{

    // get passport client data from db
    $client = Client::where('id', $data['client_id'])->where('password_client', $data['grant_type'] === 'password' ? 1 : 0)->first();

    if (is_null($client) or !Hash::check($data['client_secret'], $client->secret)) {

        return false;
    }

    return true;
}

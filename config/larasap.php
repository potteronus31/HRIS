<?php

return [

    'telegram' => [
        'api_token' => '',
        'bot_username' => '',
        'channel_username' => '', // Channel username to send message
        'channel_signature' => '', // This will be assigned in the footer of message
        'proxy' => false,   // True => Proxy is On | False => Proxy Off
    ],

    'twitter' => [
        'consurmer_key' => '',
        'consurmer_secret' => '',
        'access_token' => '',
        'access_token_secret' => ''
    ],

    'facebook' => [
        'app_id' => '685752988515590',
        'app_secret' => '79f1e87a4876ec31051b9ea86e8af476',
        'default_graph_version' => 'v8.0',
        'page_access_token' => 'EAAJvsE9IvQYBABzqGz6aOyhbZAZCavbdKZCr50IXMzNqTInRIpZCcrcEJs00JFyHute9zIcXriiupoHL5LkLk9y4XLzIXjc3aq4K9UuxZAxp5FLin1lEFMtnCNmdFjLsNxU5rTSMwxFWqLeV7JJopZB7lKEv8aTep6yZCtVIsYY8hi9My0GsOhP9rZAoyaemSGSbCLgNUOKR49LIgTBlhmZBNJr1ZBZACSdKvfujt7KhXLGYgZDZD'
    ],

    // Set Proxy for Servers that can not Access Social Networks due to Sanctions or ...
    'proxy' => [
        'type' => '',   // 7 for Socks5
        'hostname' => '', // localhost
        'port' => '' , // 9050
        'username' => '', // Optional
        'password' => '', // Optional
    ]
];
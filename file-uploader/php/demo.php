<?php
/**
 * @auther zibo
 * @date 2022/8/11
 */
require 'vendor/autoload.php';
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
$client = new Client();
$signature = getenv('AUTH_SIGNATURE');
$domain = getenv('GATEWAY_DOMAIN');
$headers = [
  'Authorization' => "Bearer $signature"
];

// Folder upload
$options = [
  'multipart' => [
    [
      'name' => 'file',
      'contents' => fopen('folder/file1.txt', 'r'),
      'filename' => 'folder%2Ffile1.txt',
    ],
    [
      'name' => 'file',
      'contents' => fopen('folder/file2.txt', 'r'),
      'filename' => 'folder%2Ffile2.txt',
    ]
]];
$request = new Request('POST', "$domain/api/v0/add?pin=true", $headers);
$res = $client->sendAsync($request, $options)->wait();
echo "Folder upload result: \n";
echo $res->getBody();

// File upload
$options = [
    'multipart' => [
      [
        'name' => 'file',
        'contents' => fopen('folder/file1.txt', 'r'),
        'filename' => 'file1.txt',
      ]
  ]];
  $request = new Request('POST', "$domain/api/v0/add?pin=true", $headers);
  $res = $client->sendAsync($request, $options)->wait();
  echo "File upload result: \n";
  echo $res->getBody();
?>

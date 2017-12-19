<?php

$j = "{type:0,image_url:'https://hanjiafushi.com/img.jpg'}";
$json=  $j;


$akId = "LTAIXc7M4NoVF67p";
$akSecret = "jYAQyQ4EyEfqMj9E3o7UdemgRprMT6";
//更新api信息
$url = "https://dtplus-cn-shanghai.data.aliyuncs.com/face/attribute";
$options = array(
    'http' => array(
        'header' => array(
            'accept' => "application/json",
            'content-type' => "application/json",
            'date' => gmdate("D, d M Y H:i:s \G\M\T"),
            'authorization' => ''
        ),
        'method' => "POST", //可以是 GET, POST, DELETE, PUT
        'content' => $json //如有数据，请用json_encode()进行编码
    )
);
$http = $options['http'];
$header = $http['header'];
$urlObj = parse_url($url);
if (empty($urlObj["query"]))
    $path = $urlObj["path"];
else
    $path = $urlObj["path"] . "?" . $urlObj["query"];
$body = $http['content'];
if (empty($body))
    $bodymd5 = $body;
else
    $bodymd5 = base64_encode(md5($body, true));
$stringToSign = $http['method'] . "\n" . $header['accept'] . "\n" . $bodymd5 . "\n" . $header['content-type'] . "\n" . $header['date'] . "\n" . $path;
$signature = base64_encode(
    hash_hmac(
        "sha1",
        $stringToSign,
        $akSecret, true));
$authHeader = "Dataplus " . "$akId" . ":" . "$signature";
$options['http']['header']['authorization'] = $authHeader;
$options['http']['header'] = implode(
    array_map(
        function ($key, $val) {
            return $key . ":" . $val . "\r\n";
        },
        array_keys($options['http']['header']),
        $options['http']['header']));
$context = stream_context_create($options);
$file = file_get_contents($url, false, $context);

echo($file);
?>

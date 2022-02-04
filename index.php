<?php
require 'vendor/autoload.php';

use App\database\DatabaseConnect;
use App\dto\NewsDTO;
use App\services\NewsDbService;
use GuzzleHttp\Client;
use PHPHtmlParser\Dom;


function searchByTag($findTag, $content): string
{
    $dom = new Dom;
    $dom->loadStr($content);
    $searchTag = $dom->find($findTag);

    return $searchTag;
}

function connectDb(): NewsDbService
{
    // db data
    $host = "localhost";
    $dbName = "test_parser";
    $user = "root";
    $pass = "root";


    $db = new DatabaseConnect($host, $dbName, $user, $pass);
    $service = new NewsDbService($db);

    return $service;
}


$url = "https://www.rbc.ru/";

$httpClient = new \GuzzleHttp\Client(['verify' => false]);
$response = $httpClient->get($url);
$htmlString = (string)$response->getBody();

$findTag = ".js-news-feed-list";
$feedBlock = searchByTag($findTag, $htmlString)[0];

$findTag = ".news-feed__item";
$searchTag = searchByTag($findTag, $feedBlock);


$service = connectDb();

foreach ($searchTag as $content) {
    $news = new NewsDTO();
    $news->title = $content->find('.news-feed__item__title')[0]->text;;
    $news->content = "333"; // Здесь идем по ссылке по второму кругу
    $news->excerpt = "333"; // Режем анонс по количеству символов/слов от Контента
    $news->link = $content->href;

    $service->addNews($news);
}



//




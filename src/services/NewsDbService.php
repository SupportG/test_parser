<?php

namespace App\services;

use App\database\DatabaseConnect;
use App\dto\NewsDTO;

class NewsDbService
{
    private $dbConnect;

    function __construct(DatabaseConnect $dbConnect)
    {
        $this->dbConnect = $dbConnect->pdoConnect();
    }

    function addNews(NewsDTO $news)
    {
        $sql = "INSERT INTO news (title, excerpt , content, link) VALUES (?,?,?,?)";
        $query = $this->dbConnect->prepare($sql);
        $query->execute([
            $news->title,
            $news->excerpt,
            $news->content,
            $news->link
        ]);
    }
}

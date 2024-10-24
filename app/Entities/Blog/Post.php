<?php

namespace App\Entities\Blog;

use Carbon\Carbon;

class Post
{
    public int $id;
    public string $title;
    public string $annotation;
    public string $content;
    public Carbon $createdAt;
    public Carbon $updatedAt;

    public function __construct(string $title = '', string $annotation = '')
    {
        $this->title = $title;
        $this->annotation = $annotation;
    }
}
<?php

namespace App\Entities\Blog;

use App\Interfaces\Arrayable;
use Carbon\Carbon;
use JsonSerializable;

class Post implements Arrayable
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

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'annotation' => $this->annotation,
            'content' => $this->content,
            'createdAt' => $this->createdAt->toDateTimeString(),
            'updatedAt' => $this->updatedAt->toDateTimeString(),
        ];
    }
}
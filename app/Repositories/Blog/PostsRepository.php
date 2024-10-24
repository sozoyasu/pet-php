<?php

namespace App\Repositories\Blog;

use App\Entities\Blog\Post;
use Carbon\Carbon;
use PDO;

class PostsRepository
{
    public const string TABLE_NAME = 'blog_posts';

    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function create(Post $post): Post
    {
        $post = clone $post;

        if (!isset($post->annotation)) {
            $post->annotation = '';
        }

        if (!isset($post->content)) {
            $post->content = '';
        }

        if (!isset($post->createdAt)) {
            $post->createdAt = Carbon::now();
        }

        if (!isset($post->updatedAt)) {
            $post->updatedAt = Carbon::now();
        }

        $stmt = $this->pdo->prepare('INSERT INTO '.$this::TABLE_NAME.' (title, annotation, content, created_at, updated_at) VALUES (:title, :annotation, :content, :created_at, :updated_at)');
        $stmt->bindValue(':title', $post->title);
        $stmt->bindValue(':annotation', $post->annotation);
        $stmt->bindValue(':content', $post->content);
        $stmt->bindValue(':created_at', $post->createdAt->toDateTimeString());
        $stmt->bindValue(':updated_at', $post->createdAt->toDateTimeString());
        $stmt->execute();

        $post->id = $this->pdo->lastInsertId();

        return $post;
    }
}
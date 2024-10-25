<?php /** @var App\Support\View\ViewRender $this */ ?>

<?php $this->extend('layouts/master') ?>

<?php $this->section('master_content') ?>
<h1 class="text-3xl font-bold underline">Это блог</h1>
<?= $this->content('article') ?>
<?php $this->endSection() ?>


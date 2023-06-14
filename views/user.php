<?php $this->layout('layouts::default', ['title' => $title]) ?>

<?= $this->insert('includes::user-banner', [
    'banner' => $user->banner,
    'photo' => $user->photo,
    'name' => "{$user->first_name} {$user->last_name}"
]) ?>

<section class="site_width container_info_user">
    <div class="box_description">
        <h3>Descrição:</h3>
        <p><?=text($user->description ?? '')?></p>
    </div>
    <div class="container_user_articles">
        <h3>Artigos publicados na plataforma</h3>
        <div class="container_user_published_articles">
            <?php if ($userArticles) : ?>
                <?php foreach ($userArticles as $article) : ?>
                    <?= $this->insert('includes::article-list', ['article' => $article]) ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <div class="container_paginator">
                    <nav class="paginator comments">
                        <?= $this->insert('includes::paginator', ['paginator' => $paginator, 'uri' => $paginatorUri]) ?>
                    </nav>
                </div>
    </div>
</section>
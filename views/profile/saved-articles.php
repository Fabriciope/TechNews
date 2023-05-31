<?php $this->layout('layouts::profile', ['title' => $title, 'userData' => $userData]) ?>

<div>
    <?php foreach ($savedArticles as $article) : ?>
        <?= $this->insert('includes::saved-article-list', ['article' => $article]) ?>
    <?php endforeach; ?>
</div>
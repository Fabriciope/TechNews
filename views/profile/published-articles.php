<?php $this->layout('layouts::profile', ['title' => $title]) ?>

<div class="container_published_articles">
    <?php for ($i = 0; $i < 6; $i++) : ?>
        <?= $this->insert('includes::published-article-list', []) ?>
    <?php endfor; ?>
</div>
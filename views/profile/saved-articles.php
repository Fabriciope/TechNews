<?php $this->layout('layouts::profile', ['title' => $title, 'userData' => $userData]) ?>

<div>
    <?php if (is_array($savedArticles)) : ?>
        <?php foreach ($savedArticles ?? [] as $article) : ?>
            <?= $this->insert('includes::saved-article-list', ['article' => $article]) ?>
        <?php endforeach; ?>
        <div class="container_paginator">
            <nav class="paginator">
                <?= $this->insert('includes::paginator', ['paginator' => $paginator]) ?>
            </nav>
        </div>
    <?php else : ?>
        <h3 class="empty">Você não possui nenhum artigo salvo. <a href="<?= url('/perfil/artigo/novo') ?>">Criar novo artigo?</a></h3>
    <?php endif; ?>
</div>
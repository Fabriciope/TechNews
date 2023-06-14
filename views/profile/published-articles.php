<?php $this->layout('layouts::profile', ['title' => $title, 'userData' => $userData]) ?>

<div class="container_published_articles">
    <?php if(is_array($publishedArticles)): ?>
        <?php foreach ($publishedArticles as $article): ?>
            <?= $this->insert('includes::published-article-list', ['article' => $article]) ?>
        <?php endforeach; ?>
    <?php else: ?>
        <h3 class="empty">Você não possui nenhum artigo publicado. <a href="<?=url('/perfil/artigo/novo')?>">Artigos salvos</a></h3>
    <?php endif; ?>
</div>
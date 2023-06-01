<?php $this->layout('layouts::profile', ['title' => $title, 'userData' => $userData]) ?>

<div>
    
    <?php if(is_array($savedArticles)): ?>
        <?php foreach ($savedArticles ?? [] as $article) : ?>
                <?= $this->insert('includes::saved-article-list', ['article' => $article]) ?>
        <?php endforeach; ?>
    <?php else: ?>
        <h3>Você não possui nenhum artigo salvo. Criar novo artigo?</h3>
    <?php endif; ?>
</div>
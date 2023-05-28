<?php $this->layout('layouts::profile', ['title' => $title, 'userData' => $userData]) ?>

<div>
    <?php for ($i = 0; $i < 4; $i++) : ?>
        <?= $this->insert('includes::saved-article-list', []) ?>
    <?php endfor; ?>
</div>
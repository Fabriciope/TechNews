<?php if($error->layout): ?>
    <?php $this->layout('layouts::default', ['title' => $title]) ?>
<?php endif; ?>

<section class="site_width" style="height: 100vh; display: flex; align-items: center;">
    <h3 class="empty"><?="{$error->code}: {$error->message}"?> <a href="<?=$error->link ?? ''?>?>"><?=$error->lintTitle ?? ''?></a></h3>
</section>
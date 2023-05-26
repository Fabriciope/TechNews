<?php $this->layout('layouts::default', ['title' => $title]) ?>

<section class="site_width section_optin">
    <article class="article_optin">
        <img src="<?= $data->image ?>" alt="<?= $data->title ?>">
        <h1><?= $data->title ?></h1>
        <p><?= $data->desc ?></p>
        <?php if (isset($data->link) && !empty($data->link)) : ?>
            <a class="gb_btn" href="<?= $data->link ?>"><?= $data->linkTitle ?></a>
        <?php endif; ?>
    </article>
</section>
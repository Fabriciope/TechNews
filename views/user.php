<?php $this->layout('layouts::default', ['title' => $title]) ?>

<?= $this->insert('includes::user-banner', []) ?>

<section class="site_width container_info_user">
    <div class="box_description">
        <h3>Descrição:</h3>
        <p>Além de mandar bem e gostar de tecnologia, o profissional atuante na área, deve se relacionar com clientes e resolver os problemas de pessoas e empresas de pequeno, médio e grande porte. Esse é um recente diferencial exigido pelo mercado de trabalho.</p>
    </div>
    <div class="container_user_articles">
        <h3>Artigos publicados na plataforma</h3>
        <div class="container_user_published_articles">
            <?php for($i = 0; $i <= 5; $i++): ?>
                <?= $this->insert('includes::article-list', []) ?>
            <?php endfor; ?>
        </div>
    </div>
</section>
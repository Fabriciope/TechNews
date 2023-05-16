<?php $this->layout("layouts::layout-default", ["title" => $title]) ?>

<!-- MELHORES ARTIGOS -->
<section class="site_width" style="margin-top: 2rem;">
    <h2 class="title_section">Artigos mais visualizados</h2>
    <div class="best">

        <!-- <img class="orange_circle_1" src="./images/orange-circle2.png" alt="">
    <img class="orange_circle_2" src="./images/orange-circle2.png" alt="">
    <img class="orange_circle_3" src="./images/orange-circle2.png" alt=""> -->

        <div class="container_best">
            <div class="container_article_left">
                <article class="article_left_best effect_article_best">
                    <img src="<?= theme("assets/images/articles/img-article.jpg") ?>" alt="">
                    <div class="title_article_best article_left">
                        <h4>YouTube Premium vai ganhar novos recursos no iOS</h4>
                    </div>
                </article>
            </div>
            <div class="container_articles_right">
                <article class="effect_article_best">
                    <img src="<?= theme("assets/images/articles/img-article.jpg") ?>" alt="">
                    <div class="title_article_best">
                        <h4>YouTube Premium vai ganhar novos recursos no iOS</h4>
                    </div>
                </article>
                <article class="effect_article_best">
                    <img src="<?= theme("assets/images/articles/img-article.jpg") ?>" alt="">
                    <div class="title_article_best">
                        <h4>YouTube Premium vai ganhar novos recursos no iOS</h4>
                    </div>
                </article>
                <article class="effect_article_best">
                    <img src="<?= theme("assets/images/articles/img-article.jpg") ?>" alt="">
                    <div class="title_article_best">
                        <h4>YouTube Premium vai ganhar novos recursos no iOS</h4>
                    </div>
                </article>
            </div>
        </div>
    </div>
</section>


<!-- CAIXA DE PESQUISA E ULTIMAS NOTÍCIAS -->
<section class="site_width latest_news">
    <h2 class="title_section">Veja os últimos artigos pulicados</h2>
    <form action="">
        <label id="search_article" class="box_search_article page_articles">
            <input type="text" id="search_article" placeholder="pesquise por algo ...">
            <button><i class="fa-solid fa-magnifying-glass"></i></button>
        </label>
    </form>
    <div class="container_article">

        <div class="container_article">
            <?php for ($i = 0; $i < 6; $i++) : ?>
                <?= $this->insert("includes::article-list", []) ?>
            <?php endfor; ?>
        </div>
    </div>
</section>
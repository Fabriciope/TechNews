<?php $this->layout("layouts::main", ["title" => $title]); ?>

<?php $this->push('styles') ?>
    <link rel="stylesheet" href="<?= css('site/home') ?>">
<?php $this->end('styles') ?>

<!-- BANNER -->
<section class="banner">
    <div class="site_width container_banner">
        <div class="container_left_banner">

            <div class="box_title_banner">
                <h2>Encontre os <span>melhores artigos</span> sobre tecnologia em um único lugar</h2>
                <p>Crie seus próprios artigos sobre tecnologia e compartilhe com todos em nossa comunidade.</p>
            </div>
            <div class="box_btn_banner">
                <a href="<?php //url('/cadastrar')?>">Criar meus próprios artigos</a>
            </div>

        </div>
        <div class="container_right_banner">
            <img src="<?= image("5.png") ?>" alt="">
        </div>
    </div>
</section>

<!-- TEXTOS DE SERVIÇOS E BENEFÍCIOS DA PLATAFORMA -->
<section class="site_width">
    <h2 class="title_section text_effect">Benefícios da plataforma</h2>

    <div class="services">
        <article>
            <div class="box_icon_services">
                <i class="fa-solid fa-users"></i>
            </div>
            <h3>Mantendo-se atualizado em tecnologia com uma plataforma colaborativa</h3>
            <p> Ao acompanhar os artigos publicados na plataforma, os usuários podem se manter atualizados sobre as últimas novidades em tecnologia, desde novas linguagens de programação até avanços em inteligência artificial. Além disso, os usuários podem ter acesso a insights valiosos e opiniões diversas sobre os temas abordados, o que pode ajudá-los a aprofundar sua compreensão e conhecimento sobre a tecnologia.</p>
        </article>
        <article class="hidden_article">
            <div class="box_icon_services">
                <i class="fa-regular fa-comments"></i>
            </div>
            <h3>Validação e Feedback Rápido</h3>
            <p>Artigos escritos por usuários permitem um ciclo rápido de feedback e validação de ideias. Outros membros da comunidade podem comentar, corrigir e acrescentar informações, melhorando a precisão e a relevância dos conteúdos publicados.</p>
        </article>
        <article>
            <div class="box_icon_services">
                <i class="fa-regular fa-newspaper"></i>
            </div>
            <h3>Conheça as últimas tendências em tecnologia</h3>
            <p> Com uma plataforma de artigos de tecnologia, os usuários podem aprender e compartilhar conhecimentos sobre os mais diversos assuntos relacionados à tecnologia. Essa plataforma é ideal para quem busca estar sempre atualizado sobre as últimas novidades em termos de tecnologia e também para aqueles que desejam compartilhar suas próprias experiências e conhecimentos com uma comunidade de pessoas interessadas.</p>
        </article>
        <!--
        <article>
            <div class="box_icon_services">
                <i class="fa-solid fa-file-pen"></i>
            </div>
            <h3>Aprenda e compartilhe conhecimentos sobre tecnologia</h3>
            <p> A publicação de artigos sobre tecnologia é uma forma de ficar por dentro das últimas tendências do mercado. Ao publicar um artigo, o autor pode compartilhar suas próprias experiências e opiniões sobre determinado assunto, além de aprender com os comentários e feedbacks de outros usuários.</p>
        </article>
        <article class="hidden_article">
            <div class="box_icon_services">
                <i class="fa-regular fa-comments"></i>
            </div>
            <h3>Validação e Feedback Rápido</h3>
            <p>Artigos escritos por usuários permitem um ciclo rápido de feedback e validação de ideias. Outros membros da comunidade podem comentar, corrigir e acrescentar informações, melhorando a precisão e a relevância dos conteúdos publicados.</p>
        </article>-->
    </div>
</section>

<!-- FORMULÁRIO PARA CADASTRO -->
<section class="site_width section_register_home">
    <h2 class="title_section">Comece ainda hoje</h2>
    <p>Publique sues próprios artigos sobre tecnologia e compartilhe co todos de forma simples e descomplicada.</p>
    <div class="container_register_home">
        <div class="box_left_register">
            <div class="box_img_register">
                <img src="<?= image("cadastrar-home.png") ?>" alt="">
            </div>
        </div>
        <div class="box_right_register">
            <form class="formAjax" action="<?php //url('/cadastrar') ?>" method="post">
                <h3>Cadastrar-se</h3>

                <div class="ajax_response">
                    <?php //flash() ?>
                </div>

                <?php //csrf_input() ?>

                <input type="text" name="first_name" class="input" placeholder="Primeiro nome:" />
                <input type="text" name="last_name" class="input" placeholder="Último nome:" />
                <input type="email" name="email" class="input" placeholder="Melhor e-mail:" />
                <input type="password" name="password" class="input" placeholder="Senha de acesso:" />
                <input type="password" name="passwordConfirmation" class="input" placeholder="Confirme sua senha de acesso:" />
                <button class="gb_btn" type="submit" >Criar minha conta</button>
            </form>
        </div>
    </div>
</section>

<!-- CAIXA DE PESQUISA E ULTIMAS NOTÍCIAS -->
<section class="site_width latest_news">
    <h2 class="title_section text_effect">Veja os últimos artigos pulicados</h2>
    <div class="container_article">
        <?php //foreach ($articles as $article) : ?>
            <?php //$this->insert("includes::article-list", ['article' => $article]) ?>
        <?php //endforeach; ?>
    </div>
</section>

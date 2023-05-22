<?php $this->layout('layouts::default', ['title' => $title]) ?>

<section class="site_width section_article_post">
    <article class="container_article_post">
        <header class="header_article_post">
            <h1>Criando relatórios em gráficos com PHP utilizando a biblioteca ChartJS e Banco de Dados</h1>
            <div class="box_info_article_post">
                <div class="box_info_left">
                    <img class="photo_author_article_post" src="<?= theme("assets/images/profile/img39 edit 2.1.jpg") ?>" alt="">
                    <p class="name_author_article">Por:<span>Fabrício Pereira Alves</span></p>
                </div>
                <p class="date_article">27/03/2023</p>
            </div>
        </header>

        <div class="container_article_content">
            <h2>Embora a biblioteca seja em javascript, conseguimos fazer a chamada de todas as propriedades com o PHP usando uma técnica para informar os dados via data-attributes</h2>

            <h3>Lib javascript</h3>

            <p>Realmente a biblioteca que baixamos é em javascript! Você até poderia ter um caminho mais curto para desenvolver essa estrutura, se você colocasse código PHP dentro da tag script.</p>

            <p>Não há uma lei que proiba isso, no entanto que é até possível... Mas é claro que não é uma boa prática essa situação, pois caso isso aconteça, você não consegue modularizar o seu código, vai ter problemas com reuso e não vai poder minificar o arquivo para publicar na internet.</p>

            <p> Então vamos trabalhar com uma outra técnica para que possamos informar todos os parâmetros via atributo do elemento, e posteriormente a gente pega esses dados com o javascript e adapta da forma que for necessário. Já vamos falar sobre essa técnica mais adiante!</p>

            <h3>Passagem de valores por data-attributes</h3>

            <p>Realmente a biblioteca que baixamos é em javascript! Você até poderia ter um caminho mais curto para desenvolver essa estrutura, se você colocasse código PHP dentro da tag script.</p>

            <p>Não há uma lei que proiba isso, no entanto que é até possível... Mas é claro que não é uma boa prática essa situação, pois caso isso aconteça, você não consegue modularizar o seu código, vai ter problemas com reuso e não vai poder minificar o arquivo para publicar na internet.</p>

            <p> Então vamos trabalhar com uma outra técnica para que possamos informar todos os parâmetros via atributo do elemento, e posteriormente a gente pega esses dados com o javascript e adapta da forma que for necessário. Já vamos falar sobre essa técnica mais adiante!</p>
        </div>

    </article>
</section>
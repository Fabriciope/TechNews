<?php $this->layout('layouts::default', ['title' => $title]) ?>

<section class="site_width section_auth">
    <article class="container_auth">
        <header class="header_auth">
            <h2>Recuperar senha</h2>
            <p>Informe seu e-mail para receber um link de verificação</p>
        </header>
    <form class="formAjax" action="<?=url('/recuperar-senha')?>" method="POST" >
            <div class="ajax_response">
                <?= flash() ?>
            </div>

            <?= csrf_input() ?>

            <div class="box_input_auth">
                <label for="" class="label_box_input forget_password">
                    <div>
                        <span><i class="fa-solid fa-envelope"></i></span>
                        Email de recuperação:
                    </div>
                    <a href="<?=url('/entrar')?>">Voltar e entrar!</a>
                </label>
                <input name="email" type="email" placeholder="Informe seu e-mail de login:">
            </div>
            <button class="gb_btn btn_submit" type="submit">Recuperar</button>
        </form>
    </article>
</section>
<?php $this->layout('layouts::default', ['title' => $title]) ?>

<section class="site_width section_auth">
    <article class="container_auth">
        <header class="header_auth">
            <h2>Redefinir senha</h2>
            <p>Informe sua nova senha para realizar a alteração</p>
        </header>
        <form class="formAjax" action="<?=url('/redefinir-senha')?>" method="POST">
            
            <div class="ajax_response">
                <?= flash() ?>
            </div>

            <?= csrf_input() ?>

            <input type="hidden" name="code" value="<?= $code ?>" >
            <div class="box_input_pass_auth">
                <label for="" class="label_box_input">
                    <span><i class="fa-solid fa-unlock"></i></span>
                    Nova senha:
                </label>
                <div class="box_password_auth">
                    <input type="password" name="password" type="email" placeholder="Informe sua nova senha:">
                    <span>
                        <i class="open_eye fa-solid fa-eye"></i>
                        <i class="closed_eye fa-solid fa-eye-slash"></i>
                    </span>
                </div>
            </div>

            <div class="box_input_pass_auth">
                <label for="" class="label_box_input">
                    <span><i class="fa-solid fa-lock"></i></span>
                    Confirme a senha:
                </label>
                <div class="box_password_auth">
                    <input type="password" name="passwordConfirmation" type="email" placeholder="Confirme sua nova senha:">
                    <span>
                        <i class="open_eye fa-solid fa-eye"></i>
                        <i class="closed_eye fa-solid fa-eye-slash"></i>
                    </span>
                </div>
            </div>

            <button class="gb_btn btn_submit" type="submit">Alterar</button>
        </form>
    </article>
</section>
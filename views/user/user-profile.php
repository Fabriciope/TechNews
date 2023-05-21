<?php $this->layout("layouts::profile", ["title" => $title]) ?>


<form action="#" class="form_content_profile">
    <div class="content_form_profile">
        <div class="box_content_profile_left">
            <div class="box_input">
                <label for="first_name">Primeiro nome:</label>
                <input type="text" class="input" placeholder="Digite seu primeiro nome...">
            </div>
            <div class="box_input">
                <label for="first_name">Sobrenome:</label>
                <input type="text" class="input" placeholder="Digite seu sobrenome...">
            </div>
            <div class="box_input">
                <label for="first_name">Bio:</label>
                <textarea name="" class="input" id="" rows="10" placeholder="Faça uma breve descrição sobre você..."></textarea>
            </div>
        </div>
        <div class="box_content_profile_right">
            <div class="box_profile_verify">
                <?php if (true) : ?>
                    <p class="email_verify">
                        Perfil verificado
                        <img src="<?= theme("assets/images/email-verify.png") ?>" alt="">
                    </p>
                <?php else : ?>
                    <div class="box_check_the_password">
                        <a href="">Verificar meu perfil</a>
                    </div>
                <?php endif; ?>
            </div>
            <div class="box_photo_profile">
                <img src="<?= theme("assets/images/profile/img39 edit 2.1.jpg") ?>" alt="">
                <div class="box_file">
                    <input type="file" id="photo_profile">
                    <label for="photo_profile" >
                        <span>Selecione uma imagem</span>
                        <span>Procurar</span>
                    </label>
                </div>
            </div>
            <div class="box_alter_password">
                <a href="#">Alterar Senha</a>
            </div>
        </div>
    </div>
    <div class="button_submit_form_profile">
        <button type="submit" class="btn_green">Salvar</button>
    </div>
</form>
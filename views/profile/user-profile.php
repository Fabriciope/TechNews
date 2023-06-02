<?php $this->layout("layouts::profile", ['title' => $title, 'userData' => $userData]) ?>

<form class="formAjax form_content_profile" action="<?= url('/perfil/atualizar') ?>" method="POST" enctype="multipart/form-data">

    <?= csrf_input() ?>

    <div class="content_form_profile">
        <div class="box_content_profile_left">
            <div class="box_input">
                <label for="first_name">Primeiro nome:</label>
                <input 
                    type="text" 
                    name="firstName" 
                    class="input" 
                    id="first_name" 
                    placeholder="Digite seu primeiro nome..."
                    value="<?=$userData->first_name?>">
            </div>
            <div class="box_input">
                <label for="last_name">Sobrenome:</label>
                <input 
                    type="text"
                    name="lastName" 
                    class="input" 
                    id="last_name"  
                    placeholder="Digite seu sobrenome..."
                    value="<?=$userData->last_name?>">
            </div>
            <div class="box_input">
                <label for="description">Descrição:</label>
                <textarea 
                name="description" 
                class="input" 
                id="description" 
                rows="10" 
                placeholder="Faça uma breve descrição sobre você..."
                ><?=$userData->description ?? ''?></textarea>
            </div>
            <div class="box_edit_banner">
                <h4>Alterar banner</h4>
                <div class="box_file">
                    <input class="input_file" type="file" name="userBanner" id="img_banner">
                    <label for="img_banner">
                        <span class="file_name">Selecione uma imagem</span>
                        <span>Procurar</span>
                    </label>
                </div>
            </div>
        </div>
        <div class="box_content_profile_right">
            <div class="box_profile_verify">
                <?php if ($userData->status == 'confirmed') : ?>
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
                <div class="box_img_photo">
                    <img src="<?=image($userData->photo)?>" alt="">
                </div>
                <div class="box_file">
                    <input class="input_file" type="file" name="userPhoto" id="photo_profile">
                    <label for="photo_profile">
                        <span class="file_name">Selecione uma imagem</span>
                        <span>Procurar</span>
                    </label>
                </div>
            </div>

            <div class="box_logout">
                <a href="<?= url('/sair') ?>">Sair</a>
            </div>
        </div>
    </div>
    <div class="button_submit_form_profile">
        <button type="submit" class="btn_green">Salvar</button>
    </div>
</form>
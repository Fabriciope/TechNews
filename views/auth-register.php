<?php  $this->layout('layouts::default', ['title' => $title]) ?>

<section class="site_width section_auth">
    <article class="container_auth">
        <header class="header_auth">   
            <h2>Cadastre-se</h2>
            <p>AJá tem uma conta? <a href="<?=url('/entrar')?>">Fazer login!!</a></p>
        </header>
        <form action="">
            <div class="ajax_response">
                <!-- <div class="message success">
                    insira seu email para entrar
                </div> -->
            </div>

            <div class="box_input_auth">
                <label for="" class="label_box_input"> 
                    <span><i class="fa-solid fa-user"></i></span> 
                    Nome:
                </label>
                <input type="text" type="email" placeholder="Primeiro nome:">
            </div>

            <div class="box_input_auth">
                <label for="" class="label_box_input"> 
                    <span><i class="fa-solid fa-user-plus"></i></span> 
                    Sobrenome:
                </label>
                <input type="text" type="email" placeholder="Segundo nome:">
            </div>

            <div class="box_input_auth">
                <label for="" class="label_box_input"> 
                    <span><i class="fa-solid fa-envelope"></i></span> 
                    Email:
                </label>
                <input type="text" type="email" placeholder="Informe seu e-mail:">
            </div>

            <div class="box_input_pass_auth">
                <label for="" class="label_box_input">
                    <span><i class="fa-solid fa-unlock"></i></span>
                    Senha:
                </label>
                <div class="box_password_auth">
                    <input type="password" type="email" placeholder="Informe sua senha:">
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
                    <input type="password" type="email" placeholder="Confirme sua senha:">
                    <span>
                        <i class="open_eye fa-solid fa-eye"></i>
                        <i class="closed_eye fa-solid fa-eye-slash"></i>
                    </span>
                </div>
            </div>

            <button class="gb_btn btn_submit" type="submit">Criar conta</button>
        </form>
    </article>
</section>
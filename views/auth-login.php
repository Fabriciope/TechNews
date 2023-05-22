<?php $this->layout('layouts::default', ['title' => $title]) ?>

<section class="site_width section_auth">
    <article class="container_auth">
        <header class="header_auth">   
            <h2>Fazer login</h2>
            <p>Ainda não tem conta? <a href="">Cadastre-se!</a></p>
        </header>
        <form action="">
            <div class="ajax_response">
                <div class="message warning">
                    insira seu email para entrar
                </div>
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
                <div class="box_forget_password">
                    <span><a href="">Esqueceu a senha?</a></span>
                </div>
            </div>

            <label for="remember_data" class="box_remember_data">
                <input id="remember_data" type="checkbox" name="save">
                <span>Lembrar dados?</span>
            </label>

            <button class="gb_btn btn_submit" type="submit">Entrar</button>
        </form>
    </article>
</section>
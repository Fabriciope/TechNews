<?php $this->layout('theme', ['title' => 'Ative sua conta na TechNews']) ?>

<!-- <img class="image" src="./../../images/confirm.png" alt=""> -->

<h2>Olá <?= $firstName ?>, você esqueceu sua senha?</h2>
<p>Clique no link abaixo para redefinir sua senha.</p>
<a href="<?= $forgetLink ?>">Clique aqui para confirmar</a>
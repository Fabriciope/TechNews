<?php $this->layout('layouts::main', ['title' => $title]) ?>

<h1 class="text-white text-[30px]">title: <?= $this->e($title) ?></h1>
<br>
<h1 class="text-red-700 text-[30px]">message: <?= $this->e($message) ?></h1>
<br>
<h1 class="text-white text-[30px]">code: <?= $this->e($code) ?></h1>

<?php

pest()
    ->extend(Tests\TestCase::class)
    ->use(Src\Framework\Support\Messages\FlashMessages::class)
    ->use(Src\Framework\Support\Messages\Messages::class)
    ->in('Unit/FlashMessagesTest.php');

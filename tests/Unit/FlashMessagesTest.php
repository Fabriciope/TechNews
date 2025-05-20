<?php

beforeAll(function () {
    (new \Src\Framework\Core\DotEnv(__DIR__ . "/../../"))->loadEnvironment();
});

afterAll(function () {
    session()->destroy();
});

test('if can get right html div', function () {
    $message = 'my custom message';

    $messageClass = $this->infoMessage($message);

    $expectedDiv = <<<DIV
            <div class="message  info">
                {$message}
            </div>
        DIV;

    $this->assertEquals(
        $expectedDiv,
        $messageClass->render(),
        'invalid html div'
    );
});

test('if can create a floating message', function () {
    $message = 'my custom message';

    $messageClass = $this->floatingErrorMessage($message);

    $expectedDiv = <<<DIV
            <div class="message fixed error">
                {$message}
            </div>
        DIV;

    $this->assertEquals(
        $expectedDiv,
        $messageClass->render(),
        'invalid html div'
    );
});

test('if can register a flash message', function () {
    $message = 'my custom message';

    $this->floatingSuccessFlashMessage($message);

    $flashMessage = session()->get('flash_message');
    $this->assertInstanceOf(
        Src\Framework\Support\Messages\Message::class,
        $flashMessage,
        'invalid received class or flash message was not registered'
    );

    $expectedDiv = <<<DIV
            <div class="message fixed success">
                {$message}
            </div>
        DIV;

    $this->assertEquals($expectedDiv, $flashMessage->render(), 'invalid html div');
});

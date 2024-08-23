<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Src\Framework\Support\Messages\FlashMessages;
use Src\Framework\Support\Messages\Message;
use Src\Framework\Support\Messages\Messages;

class FlashMessagesTest extends TestCase
{
    use FlashMessages;
    use Messages;

    private string $customMessageStr = 'my sutom message';

    public function test_if_can_get_right_html_div(): void
    {
        $messageClass = $this->infoMessage($this->customMessageStr);

        $expectedDiv = <<<DIV
            <div class="message  info">
                {$this->customMessageStr}
            </div>
        DIV;

        $this->assertEquals(
            $expectedDiv,
            $messageClass->render(),
            'invalid html div'
        );
    }

    public function test_if_can_create_a_floating_message(): void
    {
        $messageClass = $this->floatingErrorMessage($this->customMessageStr);

        $expectedDiv = <<<DIV
            <div class="message fixed error">
                {$this->customMessageStr}
            </div>
        DIV;

        $this->assertEquals(
            $expectedDiv,
            $messageClass->render(),
            'invalid html div'
        );
    }

    public function test_if_can_register_a_flash_message(): void
    {
        $this->floatingSuccessFlashMessage($this->customMessageStr);

        $flashMessage = session()->get('flash_message');
        $this->assertInstanceOf(
            Message::class,
            $flashMessage,
            'invalid received class or flash message was not registered'
        );

        $expectedDiv = <<<DIV
            <div class="message fixed success">
                {$this->customMessageStr}
            </div>
        DIV;

        $this->assertEquals($expectedDiv, $flashMessage->render(), 'invalid html div');

        session()->destroy();
    }
}

<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Src\Framework\Core\Session;

class SessionTest extends TestCase
{
    protected function setUp(): void
    {
        session()->destroy();
    }

    protected function tearDown(): void
    {
        session()->destroy();
    }

    public function test_session_is_a_singleton_class(): void
    {
        $this->assertEquals(
            Session::getInstance(),
            Session::getInstance()
        );
    }

    public function test_if_can_initialize_a_new_session(): void
    {
        Session::getInstance();

        $this->assertEquals(session_status(), PHP_SESSION_ACTIVE);
        $this->assertEquals(session_save_path(), session()->getSavePath());
    }

    public function test_if_can_save_data_at_session(): void
    {
        session()->set('key', 'value');

        $this->assertTrue(session()->has('key'));
        $this->assertEquals('value', session()->get('key'));
    }
}

<?php

namespace Tests\Unit;

use Src\Framework\Core\Session;

beforeAll(function () {
    (new \Src\Framework\Core\DotEnv(__DIR__ . "/../../"))->loadEnvironment();
});

beforeEach(function () {
    session()->destroy();
});

afterEach(function () {
    session()->destroy();
});

test('session is a singleton class', function () {
    $this->assertEquals(
        Session::getInstance(),
        Session::getInstance()
    );
});

test('if can initialize a new session', function () {
    Session::getInstance();

    $this->assertEquals(session_status(), PHP_SESSION_ACTIVE);
    $this->assertEquals(session_save_path(), session()->getSavePath());
});

test('if can save data at session', function () {
    session()->set('key', 'value');

    $this->assertTrue(session()->has('key'));
    $this->assertEquals('value', session()->get('key'));
});

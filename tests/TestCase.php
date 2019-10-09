<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Str;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected $sessionData;

    protected function setUp(): void
    {
        parent::setUp();

        $this->sessionData = [
            'sessionId' => 'ATU_id' . md5('test'),
            'phoneNumber' => '+254700000000'
        ];
    }

    public function ussdPost(string $data = '')
    {
        $this->post(route('display-ussd.index'), $this->sessionData + ['text' => $data]);

        return $this;
    }

}

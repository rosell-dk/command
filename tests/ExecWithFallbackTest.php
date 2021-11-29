<?php
namespace ExecWithFallback\Tests;

use PHPUnit\Framework\TestCase;

class ExecWithFallbackTest extends BaseTest
{
    public $className = 'ExecWithFallback';

    public function isAvailable()
    {
        return
            function_exists('exec') ||
            function_exists('open_proc') ||
            function_exists('passthru');
    }

}

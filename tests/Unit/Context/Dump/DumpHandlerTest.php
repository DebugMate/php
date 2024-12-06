<?php

namespace Debugmate\Tests\Unit\Context\Dump;

use Debugmate\Context\Dump\DumpHandler;
use Debugmate\Context\DumpContext;
use Debugmate\Tests\TestCase;

class DumpHandlerTest extends TestCase
{
    /** @test */
    public function it_should_be_execute_dump_handler_record_value_at_dump_context()
    {
        $value       = "Text dump";
        $dumpContext = new DumpContext();

        $this->assertCount(0, $dumpContext->getContext());

        $dumpHandler = new DumpHandler($dumpContext);
        $dumpHandler->dump($value);

        $response = $dumpContext->getContext()[0];
        $this->assertEquals(array_keys($response), ['html_dump', 'file', 'line_number', 'microtime']);
        $this->assertStringContainsString($value, $response['html_dump']);
    }
}

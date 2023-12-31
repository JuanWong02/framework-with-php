<?php

namespace Jc\Tests\View;

use Jc\View\JcEngine;
use PHPUnit\Framework\TestCase;

class JcEngineTest extends TestCase {
    public function test_renders_template_with_parameters() {
        $parameter1 = "Test 1";
        $parameter2 = 2;

        $expected = "
            <html>
                <body>
                    <h1>$parameter1</h1>
                    <h1>$parameter2</h1>
                </body>
            </html>
        ";

        $engine = new JcEngine(__DIR__ . "/views");

        $content = $engine->render("test", compact('parameter1', 'parameter2'), 'layout');
   
        $this->assertEquals(
           preg_replace("/\s*/", "", $expected),
           preg_replace("/\s*/", "", $content),
        );
            
    }

}
<?php

namespace Stripe;

class ApiRequestorTest extends TestCase
{
    public function testEncodeObjects()
    {
        $reflector = new \ReflectionClass('Stripe\\ApiRequestor');
        $method = $reflector->getMethod('_encodeObjects');
        $method->setAccessible(true);

        $a = ['customer' => new Customer('abcd')];
        $enc = $method->invoke(null, $a);
        $this->assertSame($enc, ['customer' => 'abcd']);

        // Preserves UTF-8
        $v = ['customer' => '☃'];
        $enc = $method->invoke(null, $v);
        $this->assertSame($enc, $v);

        // Encodes latin-1 -> UTF-8
        $v = ['customer' => "\xe9"];
        $enc = $method->invoke(null, $v);
        $this->assertSame($enc, ['customer' => "\xc3\xa9"]);
    }
}

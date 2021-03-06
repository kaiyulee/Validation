<?php
namespace Respect\Validation\Rules;

use DateTime;

class MinTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerForValidMin
     *
     */
    public function testValidMinShouldReturnTrue($minValue, $inclusive, $input)
    {
        $min = new Min($minValue, $inclusive);
        $this->assertTrue($min->__invoke($input));
        $this->assertTrue($min->check($input));
        $this->assertTrue($min->assert($input));
    }

    /**
     * @dataProvider providerForInvalidMin
     * @expectedException Respect\Validation\Exceptions\MinException
     */
    public function testInvalidMinShouldThrowMinException($minValue, $inclusive, $input)
    {
        $min = new Min($minValue, $inclusive);
        $this->assertFalse($min->__invoke($input));
        $this->assertFalse($min->assert($input));
    }

    public function providerForValidMin()
    {
        return array(
            array(100, true, ''),
            array(100, false, ''),
            array(100, false, 165.0),
            array(-100, false, 200),
            array(200, true, 200),
            array(200, false, 300),
            array('a', true, 'a'),
            array('a', true, 'c'),
            array('yesterday', true, 'now'),

            // Samples from issue #178
            array('13-05-2014 03:16', true, '20-05-2014 03:16'),
            array(new DateTime('13-05-2014 03:16'), true, new DateTime('20-05-2014 03:16')),
            array('13-05-2014 03:16', true, new DateTime('20-05-2014 03:16')),
            array(new DateTime('13-05-2014 03:16'), true, '20-05-2014 03:16'),
        );
    }

    public function providerForInvalidMin()
    {
        return array(
            array(500, false, 300),
            array(0, false, -250),
            array(0, false, -50),
            array(50, false, 50),
        );
    }
}


<?php
namespace ApplicationTest\Controller\Plugin;
use Application\Controller\Plugin\FetchExpenseDates;

/**
 * Class FetchExpenseDatesTest
 * @package ApplicationTest\Controller\Plugin
 */
class FetchExpenseDatesTest extends \PHPUnit_Framework_TestCase
{
    public function testExpenseDayResponseType()
    {
        $plugin = new FetchExpenseDates();

        $this->assertInternalType('array', $plugin('2015'));
    }
}

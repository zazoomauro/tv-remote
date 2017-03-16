<?php

namespace Tv\Tests\Service\Channel\Adapter;

use PHPUnit\Framework\TestCase;
use Tv\Service\Channel\Adapter\Apps4Two;

class Apps4TwoTest extends TestCase
{
    /**
     * @var Apps4Two
     */
    private $apps4Two;

    protected function setUp()
    {
        $this->apps4Two = new Apps4Two();
    }

    /**
     * @skip
     */
    public function testGetListOfChannelsShouldBeTypeArray()
    {
        // Arrange not needed.

        // Act.
        $actual = $this->apps4Two->getListOfChannels();

        // Assert.
        $this->assertInternalType('array', $actual);
    }

    public function testGetChannelUrlShouldReturnsAnArrayIfChannelExists()
    {
        // Arrange.
        $channelName = 'La Sexta';

        // Act.
        $actual = $this->apps4Two->getChannelUrl($channelName);

        // Assert.
        $this->assertInternalType('string', $actual);
    }

    /**
     * @expectedException \TypeError
     */
    public function testGetChannelUrlShouldThrowsAnExceptionIfChannelNotExists()
    {
        // Arrange.
        $channelName = 'foo';

        // Act.
        $this->apps4Two->getChannelUrl($channelName);

        // Assert in annotation.
    }
}

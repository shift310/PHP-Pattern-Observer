<?php
use Observer\ErrorHandler;
use Observer\Listeners\Mock;
use Observer\ErrorHandlerException;
use PHPUnit\Framework\TestCase;

class ErrorHandlerTest extends TestCase
{
    private $handler;

    public function setUp()
    {
        $this->handler = ErrorHandler::resetInstance(true);
    }

    public function assertPreConditions()
    {
        $this->assertCount(0, $this->handler);
        $this->assertFalse($this->handler->getError());
        $this->assertTrue($this->handler->getClearErrorAfterSending());
    }

    protected function _generateError()
    {
        $this->handler->start();
        trigger_error("Foo!", E_USER_WARNING);
        $this->handler->stop();
    }

    public function testErrorGetCaught()
    {
        $this->handler->setClearErrorAfterSending(false);
        $this->_generateError();
        $this->assertRegExp("|Foo!|", $this->handler->getError());
    }

    public function testSubjectNotifiesObservers()
    {
        $this->handler->attach($mock = new Mock);
        $this->_generateError();
        $this->assertRegExp("|Foo!|", $mock->message);
    }

    public function testAggregation()
    {
        $this->handler->attach($mock = new Mock);
        $this->assertContains($mock, $this->handler);
    }

    public function testCountAggregation()
    {
        $this->handler->attach(new Mock);
        $this->assertCount(1, $this->handler);
    }

    public function testClearErrorAfterSending()
    {
        $this->handler->setClearErrorAfterSending(true);
        $this->_generateError();
        $this->assertFalse($this->handler->getError());
        $this->handler->setClearErrorAfterSending(false);
        $this->_generateError();
        $this->assertInternalType('string', $this->handler->getError());
    }

    public function testErrorHandlerCatchesListenersExceptionWhileNotifying()
    {
        $this->handler->attach(new Mock(true));
        $this->handler->setCatchListenersException(false);
        $this->expectException(ErrorHandlerException::class);
        $this->_generateError();
    }
}

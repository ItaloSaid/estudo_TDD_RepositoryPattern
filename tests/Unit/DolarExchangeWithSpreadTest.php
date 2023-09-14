<?php


use app\CustomerNotFoundException;
use app\CustomerRepositoryJson;
use app\CustomerRepositoryMemory;
use app\DollarExchangeWithSpread;
use app\InputData;
use app\MyQuotationApiFake;
use PHPUnit\Framework\TestCase;

final class DolarExchangeWithSpreadTest extends TestCase
{
    public function testItShouldCalculateDollarExchangeWhenValidDateIsProvided()
    {
        //$inputData = ['customerId' => 1, 'amountUsd' => 30];
        $inputData = new InputData(1,30);


        $myQuotationApiFake = new MyQuotationApiFake();
        //$customerRepositoryMemory = new CustomerRepositoryMemory();
        $customerRepositoryJson = new CustomerRepositoryJson();
        $sut = new DollarExchangeWithSpread($myQuotationApiFake, $customerRepositoryJson);
        $output = $sut -> execute($inputData);

        $this->assertSame(1, $output['id']);
        $this->assertSame('João', $output['name']);
        $this->assertSame('joao@gmail.com', $output['email']);
        $this->assertEquals(5, $output['dollarQuotation']);
        $this->assertEquals(150, $output['amountWithoutSpread']);
        $this->assertEquals(155.25, $output['amountWithSpread']);
        $this->assertGreaterThan($output['amountWithoutSpread'], $output['amountWithSpread'] );
    }

    public function testItShouldThrowAnExceptionWhenCostumerIsNotExists()
    {
        $this->expectException(CustomerNotFoundException::class);
        $inputData = new InputData(99999,30);
        $myQuotationApiFake = new MyQuotationApiFake();
        $customerRepositoryMemory = new CustomerRepositoryMemory();
        $sut = new DollarExchangeWithSpread($myQuotationApiFake, $customerRepositoryMemory);
        $sut -> execute($inputData);


    }

    public function testItShouldReturnCorrectSpreadValueAccordingToTheAmountContributed()
    {
        $inputData = new InputData(1,30);

        $myQuotationApiFake = new MyQuotationApiFake();
        $customerRepositoryMemory = new CustomerRepositoryMemory();
        $sut = new DollarExchangeWithSpread($myQuotationApiFake, $customerRepositoryMemory);
        $output = $sut -> execute($inputData);

        $this->assertEquals(150, $output['amountWithoutSpread']);
        $this->assertEquals(155.25, $output['amountWithSpread']);


    }

}


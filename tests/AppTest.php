<?php

namespace tests;
use PHPUnit\Framework\TestCase;
use App\Utilities;

class TestCaseClass extends TestCase
{
    /*
     *  test is eu or not
     */
    public function testIsEu(){
        $util = new Utilities();
        $bin=false;
        try {
            $bin = $util->isEu(45717360);
        } catch (\Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
        $this->assertEquals(true,$bin);
    }

    /*
     *  test rate using currency
     */
    public function testRate(){
        $util = new Utilities();
        $rate = $util->getRate('GBP');
        $this->assertEquals(round($rate,1),round('0.9012',1));
    }
}

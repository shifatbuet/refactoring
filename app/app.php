<?php
namespace App;
require_once 'utilities.php';


class App
{
    /*
     * calculate commission using currency ,rate and bin
     */
    public function  calculateCommissions($argv){
        $util = new Utilities();
        foreach (explode("\n", file_get_contents($argv[1])) as $row) {
            if (empty($row)) break;
            $value = $util->getValues($row);
            try {
                $isEu = $util->isEu($value[0]);
            } catch (\Exception $e) {
                echo 'Caught exception: ',  $e->getMessage(), "\n";
            }

            $amountFixed = $util->getAmountFixed($value[2],$value[1]);
            echo round($amountFixed * ($isEu == true ? 0.01 : 0.02),2);
            print "\n";
        }
    }
}


$app = new App();
echo  $app->calculateCommissions($argv);





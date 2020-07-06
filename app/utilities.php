<?php

namespace App;

use Exception;

class Utilities
{

    public static $binUrl = 'https://lookup.binlist.net/';
    public static $rateUrl = 'https://api.exchangeratesapi.io/latest';
    public $countryAlpha2 = array(
        'AT',
        'BE',
        'BG',
        'CY',
        'CZ',
        'DE',
        'DK',
        'EE',
        'ES',
        'FI',
        'FR',
        'GR',
        'HR',
        'HU',
        'IE',
        'IT',
        'LT',
        'LU',
        'LV',
        'MT',
        'NL',
        'PO',
        'PT',
        'RO',
        'SE',
        'SI',
        'SK'
    );


    /*
     *
     * get values from input.txt
     *
     */
    public function getValues($row)
    {
        $p = json_decode($row, true);
        $value[0] = $p['bin'];
        $value[1] = $p['amount'];
        $value[2] = $p['currency'];
        return $value;
    }

    /*
     * check isEu from bin data from input text
     *
     */
    public function isEu($bin)
    {
        $binResults = file_get_contents(self::$binUrl . $bin);
        if (!$binResults) {
            throw new Exception("Bin results data not found !");
        }
        $r = json_decode($binResults);
        if (in_array($r->country->alpha2, $this->countryAlpha2)) {
            return true;
        } else {
            return false;
        }
    }

    /*
     *
     * get fixed amount using currency and amount of input
     *
     */
    public function getAmountFixed($currency, $amount)
    {
        $rate = $this->getRate($currency);
        if ($currency == 'EUR' or $rate == 0) {
            $amountFixed = $amount;
        }
        if ($currency !== 'EUR' or $rate > 0) {
            $amountFixed = $amount / $rate;
        }
        return $amountFixed;
    }

    /*
     *
     *  get rate via call of rate url
     *
     */
    public function getRate($currency)
    {
        $rate = @json_decode(file_get_contents(self::$rateUrl), true)['rates'][$currency];
        return $rate;
    }

}

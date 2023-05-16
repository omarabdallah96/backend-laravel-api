<?php

namespace App\Models;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

/**
 * Class Api
 * @package App
 */
class NewsApi extends Model
{

    public function FetchData($urlParams)
    {

        $Helper = new Helper();
        $response1 = $Helper->NewsOrgUrlApi($urlParams);


        $response2 = $Helper->CallNewsCatcher($urlParams);



        $response3 = $Helper->NewYorkTimesAPi($urlParams);


        $mergedData = array_merge($response1, $response2, $response3);

        return $mergedData;
    }
}

<?php
/**
 *
 * @author: 尹傲雄 yinaoxiong@gmail.com
 * @date 2018/9/1
 */

use NoahBuscher\Macaw\Macaw;

Macaw::get("/api/callback",'App\Controllers\CallBack@index');

Macaw::error(function (){
    echo "404 Not Found";
});

Macaw::dispatch();
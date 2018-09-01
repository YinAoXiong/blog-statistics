<?php
/**
 *
 * @author: 尹傲雄 yinaoxiong@gmail.com
 * @date 2018/8/31
 */

namespace App\Models\AbstractModel;


interface DBConnectivity
{
    /**
     *获取数据库连接对象
     * @return mixed
     * @author: 尹傲雄 yinaoxiong@gmail.com
     * Time: 2018/8/31
     */
    public function getConnectivity();
}
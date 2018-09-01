<?php
/**
 *
 * @author: 尹傲雄 yinaoxiong@gmail.com
 * @date 2018/8/30
 */

namespace App\Models\AbstractModel;


abstract class Pages
{
    /**
     * @var DBConnectivity $DBConnectivity 数据库连接对象
     */
    protected $DBConnectivity;

    /**
     *
     * @param int $Did
     * @param string $path
     * @return mixed
     * @author: 尹傲雄 yinaoxiong@gmail.com
     * Time: 2018/9/1
     */
    public abstract function getPageInfo(int $Did, string $path);

    /**
     *插入新的页面记录
     * @param int $Did
     * @param string $path 页面路径
     * @param int $pvTimes pv次数
     * @return bool
     * @author: 尹傲雄 yinaoxiong@gmail.com
     * Time: 2018/9/1
     */
    public abstract function insertPageInfo(int $Did, string $path, int $pvTimes): bool;

    /**
     *更新页面的pv次数
     * @param int $pvTimes
     * @param int $Did
     * @param string $path
     * @return bool
     * @author: 尹傲雄 yinaoxiong@gmail.com
     * Time: 2018/9/1
     */
    public abstract function updatePageInfo(int $pvTimes, int $Did, string $path): bool;

}
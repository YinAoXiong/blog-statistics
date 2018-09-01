<?php
declare(strict_types=1);
/**
 *
 * @author: 尹傲雄 yinaoxiong@gmail.com
 * @date 2018/8/30
 */

namespace App\Models\AbstractModel;


abstract class Hosts
{
    /**
     * @var DBConnectivity $DBConnectivity 数据库连接对象
     */
    protected $DBConnectivity;

    /**
     *根据域名返回对应的pv，uv，id命名数组
     * @param string $hostName 域名
     * @return mixed
     * @author: 尹傲雄 yinaoxiong@gmail.com
     * Time: 2018/9/1
     */
    public abstract function getInfo(string $hostName);

    /**
     *插入新的host记录，返回插入id，失败返回-1
     * @param string $hostName 域名
     * @param int $pvTimes 更新后的pv次数
     * @param int $uvTimes 更新后的uv次数
     * @return int
     * @author: 尹傲雄 yinaoxiong@gmail.com
     * Time: 2018/8/30
     */
    public abstract function insertInfo(string $hostName, int $pvTimes, int $uvTimes): int;

    /**
     *
     * @param int $pvTimes 更新后的pv次数
     * @param int $uvTimes 更新后的uv次数
     * @param int $id
     * @return bool
     * @author: 尹傲雄 yinaoxiong@gmail.com
     * Time: 2018/9/1
     */
    public abstract function updateInfo(int $pvTimes, int $uvTimes, int $id): bool;

}
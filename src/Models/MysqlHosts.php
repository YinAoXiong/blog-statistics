<?php
/**
 *
 * @author: 尹傲雄 yinaoxiong@gmail.com
 * @date 2018/8/31
 */

namespace App\Models;

use App\Models\AbstractModel\Hosts;

class MysqlHosts extends Hosts
{
    private $sqlSelectHost;
    private $sqlInsertHost;
    private $sqlUpdateHost;

    public function __construct()
    {
        $this->DBConnectivity = new MysqlConnectivity();
        $conn = $this->DBConnectivity->getConnectivity();
        //对sql进行预处理
        $this->sqlSelectHost = $conn->prepare("SELECT `pvTimes`,`uvTimes`,`id` FROM `hosts` WHERE `host` = ?");
        $this->sqlInsertHost = $conn->prepare("INSERT INTO `hosts` (`host`,`pvTimes`,`uvTimes`) VALUES (?,?,?)");
        $this->sqlUpdateHost = $conn->prepare("UPDATE `hosts` SET `pvTimes` = ?, `uvTimes` = ?  WHERE `id` = ?");
    }

    /**
     *根据域名返回对应的pv，uv，id命名数组
     * @param string $hostName
     * @return mixed
     * @author: 尹傲雄 yinaoxiong@gmail.com
     * Time: 2018/9/1
     */
    public function getInfo(string $hostName)
    {
        $this->sqlSelectHost->bind_param("s", $hostName);
        if ($this->sqlSelectHost->execute()) {
            $result = $this->sqlSelectHost->get_result();
            if($result->num_rows>0){
                $this->sqlSelectHost->close();
                return $result->fetch_object();
            }else{
                return false;
            }

        } else {
            return false;
        }

    }

    /**
     *插入新的host记录，返回插入id，失败返回-1
     * @param string $hostName 域名
     * @param int $pvTimes 更新后的pv次数
     * @param int $uvTimes 更新后的uv次数
     * @return int
     * @author: 尹傲雄 yinaoxiong@gmail.com
     * Time: 2018/8/30
     */
    public function insertInfo(string $hostName, int $pvTimes, int $uvTimes): int
    {
        $this->sqlInsertHost->bind_param("sii", $hostName, $pvTimes, $uvTimes);
        if ($this->sqlInsertHost->execute()) {
            return $this->sqlInsertHost->insert_id;

        } else {
            return -1;
        }
    }

    /**
     *
     * @param int $pvTimes 更新后的pv次数
     * @param int $uvTimes 更新后的uv次数
     * @param int $id
     * @return bool
     * @author: 尹傲雄 yinaoxiong@gmail.com
     * Time: 2018/9/1
     */
    public function updateInfo(int $pvTimes, int $uvTimes, int $id): bool
    {
        $this->sqlUpdateHost->bind_param("iii", $pvTimes, $uvTimes, $id);
        if ($this->sqlUpdateHost->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
<?php
/**
 *
 * @author: 尹傲雄 yinaoxiong@gmail.com
 * @date 2018/9/1
 */

namespace App\Models;


use App\Models\AbstractModel\Pages;

class MysqlPages extends Pages
{
    private $sqlSelectPage;
    private $sqlInsertPage;
    private $sqlUpdatePage;

    public function __construct()
    {
        $this->DBConnectivity=new MysqlConnectivity();
        $conn=$this->DBConnectivity->getConnectivity();
        $this->sqlSelectPage=$conn->prepare("SELECT `pvTimes` FROM `pages` WHERE `Did` = ? AND `path` = ?");
        $this->sqlInsertPage=$conn->prepare("INSERT INTO `pages` (`Did`,`path`,`pvTimes`) VALUES (?,?,?)");
        $this->sqlUpdatePage=$conn->prepare("UPDATE `pages`  SET `pvTimes` = ? WHERE `Did` = ? AND `path` = ?");
    }

    /**
     *返回对应页面的pv数
     * @param int $Did hostID
     * @param string $path　请求路径
     * @return int
     * @author: 尹傲雄 yinaoxiong@gmail.com
     * Time: 2018/9/1
     */
    public function getPageInfo(int $Did, string $path): int
    {
        $this->sqlSelectPage->bind_param("is",$Did,$path);
        if($this->sqlSelectPage->execute()){
            $result=$this->sqlSelectPage->get_result();
            if($result->num_rows>0){
                $this->sqlSelectPage->close();
                return $result->fetch_object()->pvTimes;
            }else{
                return false;
            }
        }else{
            return false;
        }

    }

    /**
     *插入新的页面记录
     * @param int $Did
     * @param string $path 页面路径
     * @param int $pvTimes pv次数
     * @return bool
     * @author: 尹傲雄 yinaoxiong@gmail.com
     * Time: 2018/9/1
     */
    public function insertPageInfo(int $Did, string $path, int $pvTimes): bool
    {
        $this->sqlInsertPage->bind_param("isi",$Did,$path,$pvTimes);
        if($this->sqlInsertPage->execute()){
            return true;
        }else{
            return false;
        }
    }

    /**
     *更新页面的pv次数
     * @param int $pvTimes
     * @param int $Did
     * @param string $path
     * @return bool
     * @author: 尹傲雄 yinaoxiong@gmail.com
     * Time: 2018/9/1
     */
    public function updatePageInfo(int $pvTimes, int $Did, string $path): bool
    {
        $this->sqlUpdatePage->bind_param("iis",$pvTimes,$Did,$path);
        if($this->sqlUpdatePage->execute()){
            return true;
        }else{
            return false;
        }
    }
}
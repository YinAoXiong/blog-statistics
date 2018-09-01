<?php
/**
 *
 * @author: 尹傲雄 yinaoxiong@gmail.com
 * @date 2018/8/31
 */

namespace App\Models;

use App\Models\AbstractModel\DBConnectivity;

class MysqlConnectivity implements DBConnectivity
{
    public $connect_error;
    private $conn;

    /**
     * MysqlConnectivity constructor.
     */
    public function __construct()
    {
        $this->conn=new \mysqli(getenv('DB_HOST'),getenv('DB_USERNAME'),getenv('DB_PASSWORD'),getenv('DB_DATABASE'));
        $this->connect_error=$this->conn->connect_error;
    }

    public function __destruct()
    {
        $this->conn->close();
    }

    /**
     *获取数据库连接对象
     * @return mixed
     * @author: 尹傲雄 yinaoxiong@gmail.com
     * Time: 2018/8/31
     */
    public function getConnectivity()
    {
        return $this->conn;
    }
}
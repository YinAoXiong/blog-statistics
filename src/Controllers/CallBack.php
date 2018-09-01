<?php
/**
 *
 * @author: 尹傲雄 yinaoxiong@gmail.com
 * @date 2018/8/30
 */

namespace App\Controllers;


use App\Models\AbstractModel\Hosts;
use App\Models\AbstractModel\Pages;
use App\Models\MysqlHosts;
use App\Models\MysqlPages;

class CallBack
{
    /**
     * @var Hosts
     */
    private $hosts;
    /**
     * @var Pages
     */
    private $pages;

    public function __construct()
    {
        $this->hosts=new MysqlHosts();
        $this->pages=new MysqlPages();
    }

    public function index(){
        $haveCookie=$_GET['haveCookie']?$_GET['haveCookie']:NULL;
        $pageId=$_GET['id']?$_GET['id']:NULL;
        $url=$_SERVER['HTTP_REFERER']?$_SERVER['HTTP_REFERER']:NULL;
        if($url){
            //路由解析
            $host=parse_url($url,PHP_URL_HOST);
            $port=parse_url($url,PHP_URL_PORT);
            $path=$pageId?$pageId:parse_url($url, PHP_URL_PATH);
            $host=$host.':'.$port;

            $pagePVTimes=0;
            $sitePVTimes=0;
            $siteUVTimes=0;
            //查看是否存在该host
            $hostSelect=$this->hosts->getInfo($host);
            if($hostSelect){
                $sitePVTimes=$hostSelect->pvTimes;
                $siteUVTimes=$hostSelect->uvTimes;
                $Did=$hostSelect->id;
                ++$sitePVTimes;
                if($haveCookie==0){
                    ++$siteUVTimes;
                }
                $this->hosts->updateInfo($sitePVTimes,$siteUVTimes,$Did);

                //查看是否存在该路径
                $pageSelect=$this->pages->getPageInfo($Did,$path);
                if($pageSelect){
                    $pagePVTimes=$pageSelect+1;
                    $this->pages->updatePageInfo($pagePVTimes,$Did,$path);
                }else{
                    $pagePVTimes=1;
                    $this->pages->insertPageInfo($Did,$path,$pagePVTimes);
                }
            }else{
                $pagePVTimes=1;
                $sitePVTimes=1;
                $siteUVTimes=1;

                $Did=$this->hosts->insertInfo($host,$sitePVTimes,$siteUVTimes);

                $this->pages->insertPageInfo($Did,$path,$pagePVTimes);
            }
            echo "statistics.statisticsCallBack($pagePVTimes,$sitePVTimes,$siteUVTimes)";


        }else{
            echo 'bad request';
        }
    }

    /**
     * @param Hosts $hosts
     * @return CallBack
     */
    public function setHosts(Hosts $hosts): CallBack
    {
        $this->hosts = $hosts;
        return $this;
    }

    /**
     * @param Pages $pages
     * @return CallBack
     */
    public function setPages(Pages $pages): CallBack
    {
        $this->pages = $pages;
        return $this;
    }

}
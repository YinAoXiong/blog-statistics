<?php
/**
 *
 * @author: 尹傲雄 yinaoxiong@gmail.com
 * @date 2018/8/31
 */

require_once(__DIR__.'/../vendor/autoload.php');

/*
 * 载入配置文件信息
 */

$dotenv=new \Dotenv\Dotenv(__DIR__.'/../');
$dotenv->load();

/*
 * 加载路由
 */

require_once(__DIR__.'/../routes/index.php');
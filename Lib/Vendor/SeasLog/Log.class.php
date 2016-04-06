<?php
/**
 * @author ciogao@gmail.com
 * Date: 14-1-27 下午4:47
 */
namespace Lib\Vendor\SeasLog;
class Log
{
    public function __construct()
    {
        #SeasLog init
        // self::setLogger($_SERVER['SERVER_NAME']);
    }

    public function __destruct()
    {
        #SeasLog distroy
    }
    static public function getIpUri(){
        return $_SERVER['REMOTE_ADDR'].' | '.$_SERVER['REQUEST_URI'].' | ';
    }

    /**
     * 设置basePath
     * @param $basePath
     * @return bool
     */
    static public function setBasePath($basePath)
    {
        // return TRUE;
        \SeasLog::setBasePath($basePath);
    }

    /**
     * 获取basePath
     * @return string
     */
    static public function getBasePath()
    {
        return \SeasLog::getBasePath();
    }

    /**
     * 设置模块目录
     * @param $module
     * @return bool
     */
    static public function setLogger($module)
    {
        \SeasLog::setLogger($module);
        // return TRUE;
    }

    /**
     * 获取最后一次设置的模块目录
     * @return string
     */
    static public function getLastLogger()
    {
        return \SeasLog::getLastLogger();;
    }

    /**
     * 统计所有类型（或单个类型）行数
     * @param string $level
     * @param string $log_path
     * @param null $key_word
     * @return array | long
     */
    static public function analyzerCount($level = 'all',$log_path = '*',$key_word = NULL)
    {
        return array();
    }

    /**
     * 以数组形式，快速取出某类型log的各行详情
     *
     * @param        $level
     * @param string $log_path
     * @param null   $key_word
     * @param int    $start
     * @param int    $limit
     * @param        $order
     *
     * @return array
     */
    static public function analyzerDetail($level = SEASLOG_INFO, $log_path = '*', $key_word = NULL, $start = 1, $limit = 20, $order = SEASLOG_DETIAL_ORDER_ASC)
    {
        return \SeasLog::analyzerDetail($level, $log_path = '*', $key_word = NULL, $start = 1, $limit = 20, $order = SEASLOG_DETIAL_ORDER_ASC);
    }

    /**
     * 获得当前日志buffer中的内容
     * @return array
     */
    static public function getBuffer()
    {
        return array();
    }

    /**
     * 将buffer中的日志立刻刷到硬盘
     *
     * @return bool
     */
    static public function flushBuffer()
    {
        return TRUE;
    }

    /**
     * 记录debug日志
     * @param $message
     * @param array $content
     * @param string $module
     */
    static public function debug($message,array $content = array(),$module = '')
    {
        #$level = SEASLOG_DEBUG
        $message = self::getIpUri().$message;
        if($module !== ''){
            $module = $_SERVER['SERVER_NAME'].'/'.$module;
        }
        \SeasLog::debug($message,$content,$module);
    }

    /**
     * 记录info日志
     * @param $message
     * @param array $content
     * @param string $module
     */
    static public function info($message,array $content = array(),$module = '')
    {
        #$level = SEASLOG_INFO
        $message = self::getIpUri().$message;
        if($module !== ''){
            $module = $_SERVER['SERVER_NAME'].'/'.$module;
        }
        \SeasLog::info($message,$content,$module);
    }

    /**
     * 记录notice日志
     * @param $message
     * @param array $content
     * @param string $module
     */
    static public function notice($message,array $content = array(),$module = '')
    {
        #$level = SEASLOG_NOTICE
        $message = self::getIpUri().$message;
        if($module !== ''){
            $module = $_SERVER['SERVER_NAME'].'/'.$module;
        }
        \SeasLog::notice($message,$content,$module);
    }

    /**
     * 记录warning日志
     * @param $message
     * @param array $content
     * @param string $module
     */
    static public function warning($message,array $content = array(),$module = '')
    {
        #$level = SEASLOG_WARNING
        $message = self::getIpUri().$message;
        if($module !== ''){
            $module = $_SERVER['SERVER_NAME'].'/'.$module;
        }
        \SeasLog::warning($message,$content,$module);
    }

    /**
     * 记录error日志
     * @param $message
     * @param array $content
     * @param string $module
     */
    static public function error($message,array $content = array(),$module = '')
    {
        #$level = SEASLOG_ERROR
        $message = self::getIpUri().$message;
        if($module !== ''){
            $module = $_SERVER['SERVER_NAME'].'/'.$module;
        }
        \SeasLog::error($message,$content,$module);
    }

    /**
     * 记录critical日志
     * @param $message
     * @param array $content
     * @param string $module
     */
    static public function critical($message,array $content = array(),$module = '')
    {
        #$level = SEASLOG_CRITICAL
        $message = self::getIpUri().$message;
        if($module !== ''){
            $module = $_SERVER['SERVER_NAME'].'/'.$module;
        }
        \SeasLog::critical($message,$content,$module);
    }

    /**
     * 记录alert日志
     * @param $message
     * @param array $content
     * @param string $module
     */
    static public function alert($message,array $content = array(),$module = '')
    {
        #$level = SEASLOG_ALERT
        $message = self::getIpUri().$message;
        if($module !== ''){
            $module = $_SERVER['SERVER_NAME'].'/'.$module;
        }
        \SeasLog::alert($message,$content,$module);
    }

    /**
     * 记录emergency日志
     * @param $message
     * @param array $content
     * @param string $module
     */
    static public function emergency($message,array $content = array(),$module = '')
    {
        #$level = SEASLOG_EMERGENCY
        $message = self::getIpUri().$message;
        if($module !== ''){
            $module = $_SERVER['SERVER_NAME'].'/'.$module;
        }
        \SeasLog::emergency($message,$content,$module);
    }

    /**
     * 通用日志方法
     * @param $level
     * @param $message
     * @param array $content
     * @param string $module
     */
    static public function log($level,$message,array $content = array(),$module = '')
    {
        $message = self::getIpUri().$message;
        if($module !== ''){
            $module = $_SERVER['SERVER_NAME'].'/'.$module;
        }
        \SeasLog::log($level,$message,$content,$module);
    }
}

<?php
/**
 * 乐视云计算
 */
namespace Home\Controller;

use Home\Controller\BaseController;

class LeCloudController extends BaseController
{
    public function index()
    {
        echo 'LeCloud';
    }

    public function leCloudApi()
    {
        $userid = 882860;
        $uri = '/data/bandwidth';
        $appkey = '07f82bfcc7eeda519241d8fe1d53c1e6';
        $method = 'GET';
        $md5Val = md5($userid . $method . $uri . $appkey);
        $base64Val = 'Basic ' . base64_encode($userid . ':' . $md5Val);
        $header = [
            "Authorization:{$base64Val}",
            'Lecloud-api-version:0.4'
        ];
        $url = "http://api.open.letvcloud.com/data/bandwidth?productline=CDN&domaintype=VOD&startday=20161228&endday=20161228";
        $res = curl_header_get_contents($url, $header);
        var_dump(json_decode($res, true)['data']['bandwidth']);
    }

    //直播时长查询
    public function liveDuration()
    {
        $userid = 882860;
        $uri = '/data/bandwidth';
        $appkey = '07f82bfcc7eeda519241d8fe1d53c1e6';
        $method = 'GET';
        $md5Val = md5($userid . $method . $uri . $appkey);
        $base64Val = 'Basic ' . base64_encode($userid . ':' . $md5Val);
        $header = [
            "Authorization:{$base64Val}",
            'Lecloud-api-version:0.4'
        ];
        $url = "http://api.open.letvcloud.com/data/duration?startday=20170103&endday=20170103&pushDomain=lepush.amaitech.com";
        $res = curl_header_get_contents($url, $header);
        var_dump(json_decode($res, true));
    }

    /**
     * 直播 CDNCDNCDN打点录制任务创建接口
     * Method：POST
     */
    public function recordFunction()
    {
        $method = 'lecloud.cdnlive.rec.createCdnRecTaskByStreamName';
        $ver = 3.1;
        $userid = 882860;
        $timestamp = time() . '000';
        $streamName = 789;
        $appName = 'test';
        $domain = 'leplay.amaitech.com';     #客户的访问域名
        $fileType = 'flv';                    #下载类型flv|mp4
        $startTime = date('YmdHis',time());         #直播开始时间，（早于开始时间几秒就可以例如20161227123025）
        $endTime = date('YmdHis',time())+10000;           #直播结束时间（晚于结束时间几秒就可以

        $seckey = '07f82bfcc7eeda519241d8fe1d53c1e6';
        $sign = "appName{$appName}domain{$domain}endTime{$endTime}fileType{$fileType}method{$method}startTime{$startTime}streamName{$streamName}timestamp{$timestamp}userid{$userid}ver{$ver}{$seckey}";
        $md5Sifn = md5($sign);
        $url = 'http://api.open.lecloud.com/live/execute';
        $arrData = [
            'appName' => $appName,
            'domain' => $domain,
            'endTime' => $endTime,
            'fileType' => $fileType,
            'method' => $method,
            'startTime' => $startTime,
            'streamName' => $streamName,
            'timestamp' => $timestamp,
            'userid' => $userid,
            'ver' => $ver,
            'sign' => $md5Sifn
        ];

        $res = http_post_data($url, $arrData);
        var_dump($res);
    }

    /**
     * 直播 CDNCDNCDN录制任务查询接口
     * Method : GET
     * 【1】控制可以录像
     * 【2】录像格式是否支持多种格式：
     * 【3】录像后的文件如何下载和播放？
     * 【4】录像的时间和文件个数是多少？
     * 【5】视频自己录制完后是否可以上传，是否可以切片
     * 【6】录像文件的码率是多少？原始流还是转码后的流
     * 【7】是否可以自定义域名打流（录像
     */
    public function recordSearchResult()
    {
        $method = 'lecloud.cdnlive.rec.searchResult';
        $taskId = '7324405';
        $timestamp = time() . '000';
        $ver = 3.1;
        $userid = 882860;
        $streamName = 789;
        $appName = 'test';
        $domain = 'leplay.amaitech.com';     #客户的访问域名
        $startTime = '20170103123025';         #直播开始时间，（早于开始时间几秒就可以例如20161227123025）
        $endTime = '20170103193025';           #直播结束时间（晚于结束时间几秒就可以

        $seckey = '07f82bfcc7eeda519241d8fe1d53c1e6';
        $sign = md5("appName{$appName}domain{$domain}method{$method}streamName{$streamName}timestamp{$timestamp}userid{$userid}ver{$ver}{$seckey}");
        $url = "http://api.open.letvcloud.com/live/execute?appName=$appName&domain=$domain&method=$method&streamName=$streamName&timestamp=$timestamp&userid=$userid&ver=$ver&sign=$sign";
        $res = json_decode(curl_get_contents($url),true);
        homePrint(count($res['rows']));
        homePrint($res['rows']);
    }


}
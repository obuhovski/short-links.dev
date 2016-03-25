<?php

namespace app\models;


use GuzzleHttp\Client;
use GuzzleHttp\Ring\Exception\ConnectException;
use Sinergi\BrowserDetector\Browser;
use Sinergi\BrowserDetector\Os;
use Yii;
use yii\base\Exception;
use yii\base\Object;
use yii\helpers\Json;

class VisitorFactory extends Object
{

    /**
     * @param string $userIp
     * @param Browser $browser
     * @param Os $os
     * @param Client $httpClient
     * @param Link $link
     * @return Visitor
     */
    public function createVisitor($userIp, Browser $browser, Os $os, Client $httpClient, Link $link)
    {
        $visitor = new Visitor();
        $visitor->ip = $userIp;
        $visitor->date = (new \DateTime())->format('Y-m-d H:i:s');
        $visitor->browser = $browser->getName().' '.$browser->getVersion();
        $visitor->os = $os->getName();
        $visitor->region = $this->getRegion($httpClient,$userIp);;
        $visitor->link_id = $link->id;

        return $visitor;
    }

    /**
     * @param Client $httpClient
     * @return string|null
     */
    private function getRegion(Client $httpClient,$ip)
    {
        try {
            $res = $httpClient->get('http://api.sypexgeo.net/json/'.$ip);
            $json = Json::decode($res->getBody());
            $region = isset($json['region']['name_ru']) ? $json['region']['name_ru'] : null;
        } catch (\Exception $e) {
            Yii::warning('Регион не получен');
            $region = null;
        }

        return  $region;
    }



}

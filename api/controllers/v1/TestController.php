<?php

namespace api\controllers\v1;

use api\controllers\ApiController;
use common\helpers\FileHelper;
use common\models\App;
use common\models\Application;
use common\models\Article;
use common\models\User;
use common\helpers\Auth0Helper;
use Sunra\PhpSimple\HtmlDomParser;


/**
 * @author Eugene Terentev <eugene@terentev.net>
 */
class TestController extends ApiController
{

    /**
     * Get User Info
     *
     * @param integer $id
     *
     */
    public function actionIndex(){
        $this->msg = 'test';

    }
    public function actionD1(){

        $html = 'https://tinhte.vn';

        $dom = HtmlDomParser::file_get_html( $html );
        foreach($dom->find('.recentNews') as $element){
            $item    = $element->find('a.newsTitle', 0)->plaintext;
            $item3   = $element->find('a.newsTitle', 0)->href;
            $item2   = $element->find('a.username', 0)->plaintext;
            $item1   = $element->find('img.LbImage', 0)->src;

            $item4   = $element->find('.postedBy a', -1)->plaintext;
            echo $item   . '<br>';
            echo $item2  . '<br>';
            echo $item4  . '<br>';
            echo $item3  . '<br>';
            echo $item1  . '<br>';
        }
        die;
    }
    public function actionD2()
    {
        $url = 'https://cdn.filestackcontent.com/RX2y0pkTHKYv7RIDVoyf';
        $a= file_put_contents("a.png", fopen($url, 'r'));

        d_dump($a);
        $file = UploadedFile::getInstanceByName('f');
        die;
    }
    public function actionD3(){

        //http://xem.vn/photos/more?page=1
        $html = 'http://xem.vn';
        //$html = 'http://xem.vn';
        $dom = HtmlDomParser::file_get_html($html);
        $datas = [];
        foreach($dom->find('.photoListItem') as $element){

            $is_data  =true;
            $item_data = array();
            try {
                $item = $element->find('div.info h2 a', 0);
                $item_data['title'] = $item->innertext;
                $item_data['url'] = $html. $item->href;
            } catch(\Exception $e) {
                $is_data = false;
            }

            try {
                $item1 = $element->find('img.thumbImg', 0);
                if(isset($item1->attr['src'])){
                    $item_data['image'] = $item1->attr['src'];
                }else{
                    $item_data['image']  = '';
                }

            } catch(\Exception $e) {
                $is_data = false;
            }

            if($is_data){
                $datas [] = $item_data;
            }

        }

        $this->data = $datas;
    }

    public function actionD4(){
        $url = 'http://static.yiiframework.com/files/logo/yii.png' ;

        $path = 'yii.png';

        $model = new Article();

        $file = UploadFromUrl::initWithUrlAndModel($url, $model, 'thumbnail');

        $a =  \Yii::$app->fileStorage->save($file, false, false, 'aaa');

        $model->save();



        ddump($model);



    }
}

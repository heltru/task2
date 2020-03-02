<?php
namespace app\modules\api\controllers;

use app\models\Product;
use yii\data\ActiveDataFilter;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;
use Yii;
use yii\web\Response;

class ProductController extends ActiveController
{
    public $modelClass = 'app\models\Product';



    public function actions()
    {
        $actions = parent::actions();
      //  unset($actions['create']);
      //  unset($actions['delete']);
     //   unset($actions['update']);

        $actions['index']['prepareDataProvider'] = [$this,'prepareDataProvider'];

        return $actions;

    }




    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['contentNegotiator'] =  [
            'class' => \yii\filters\ContentNegotiator::className(),
            'formats' => [
                'application/json' => \yii\web\Response::FORMAT_JSON,
            ],
        ];
/*
        $behaviors['access'] = [
            'class' => \yii\filters\AccessControl::className(),
            'only' => ['create', 'update', 'delete','index'],
            'rules' => [
                [
                    'actions' => ['create', 'update', 'delete','index'],
                    'allow' => true,
                    'roles' => ['?'],
                ],
            ],
        ];
*/
        return $behaviors;
    }



    public function prepareDataProvider()
    {

        $filter = new ActiveDataFilter([
            'searchModel' => 'app\models\ProductSearch'
        ]);

        $filterCondition = null;

        if ($filter->load(\Yii::$app->request->get() )) {
            $filterCondition = $filter->build();
            if ($filterCondition === false) {
                return $filter;
            }
        }

        $query = Product::find();
        if ($filterCondition !== null) {
            $query->andWhere($filterCondition);
        }

        $query->orderBy = ['date_cr'=>SORT_DESC];

        return new ActiveDataProvider([
            'query' => $query,
            'pagination'=>false
        ]);

    }


}
<?php
/**
 * Created by PhpStorm.
 * User: medve
 * Date: 04.08.2017
 * Time: 16:09
 */

namespace app\modules\admin\controllers;

use app\modules\admin\models\OrderItems;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

use app\modules\admin\models\Order;

class OrderSearch extends Order
{
    public $amount;
    public $totalSum;

    public function rules()
    {
        return [

        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Order::find();
        $subQuery = OrderItems::find()
            ->select('order_id, SUM(qty_item) as amount, SUM(price * qty_item) as price')
            ->groupBy('order_id');

        $query->leftJoin(['orderData' => $subQuery], 'orderData.order_id = id');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $dataProvider->setSort([
            'attributes'=>[
                'id',
                'created_at',
                'updated_at',
                'amount'=>[
                    'asc'=>['orderData.amount'=>SORT_ASC],
                    'desc'=>['orderData.amount'=>SORT_DESC],
                ],
                'totalSum'=>[
                    'asc'=>['orderData.price'=>SORT_ASC],
                    'desc'=>['orderData.price'=>SORT_DESC],
                ],
                'status',
                'name',
                'email',
                'phone',
                'address',
            ]
        ]);

        $query->andFilterWhere([
            'id' => $this->id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'orderData.amount'=>$this->amount,
            'orderData.price'=>$this->totalSum,
        ]);


        $query->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'address', $this->address]);

        return $dataProvider;
    }
}
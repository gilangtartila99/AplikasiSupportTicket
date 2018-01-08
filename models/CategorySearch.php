<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Category;

/**
 * CategorySearch represents the model behind the search form about `app\models\Category`.
 */
class CategorySearch extends Category
{
    public $nama_partner;
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_category', 'user_id'], 'integer'],
            [['nama_category', 'nama_partner'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Category::find()->joinWith(['users']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['nama_partner'] = [
            'asc' => ['users.nama_partner' => SORT_ASC],
            'desc' => ['users.nama_partner' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id_category' => $this->id_category,
            'user_id' => $this->user_id,
        ]);

        $query->andFilterWhere(['like', 'nama_category', $this->nama_category])
            ->andFilterWhere(['like', 'user.nama_partner', $this->nama_partner]);

        return $dataProvider;
    }
}

<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Ticket;

/**
 * TicketSearch represents the model behind the search form about `app\models\Ticket`.
 */
class TicketSearch extends Ticket
{
    public $nama_category;
    public $bulan;
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_ticket', 'user_id', 'category_id', 'support_id', 'jumlah'], 'integer'],
            [['prioritas', 'state', 'subject', 'description', 'attachment', 'nama_category', 'date'], 'safe'],
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
        $query = Ticket::find()->joinWith(['category'])->orderBy(['state' => SORT_DESC, new \yii\db\Expression('FIELD(prioritas, "Tinggi","Sedang","Rendah")')]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['nama_category'] = [
            'asc' => ['category.nama_category' => SORT_ASC],
            'desc' => ['category.nama_category' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id_ticket' => $this->id_ticket,
            'user_id' => $this->user_id,
            'jumlah' => $this->jumlah,
            'support_id' => $this->support_id,
            'category_id' => $this->category_id,
        ]);

        $query->andFilterWhere(['like', 'prioritas', $this->prioritas])
            ->andFilterWhere(['like', 'state', $this->state])
            ->andFilterWhere(['like', 'date', $this->date])
            ->andFilterWhere(['like', 'subject', $this->subject])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'category.nama_category', $this->nama_category])
            ->andFilterWhere(['like', 'attachment', $this->attachment]);

        return $dataProvider;
    }
}

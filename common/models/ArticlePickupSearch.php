<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ArticlePickup;

/**
 * ArticlePickupSearch represents the model behind the search form about `common\models\ArticlePickup`.
 */
class ArticlePickupSearch extends ArticlePickup {
	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [
			[ [ 'id', 'article_id', 'sort_number' ], 'integer' ],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function scenarios() {
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
	public function search( $params ) {
		$query = ArticlePickup::find()->orderBy('sort_number ASC');

		$dataProvider = new ActiveDataProvider( [
			'query' => $query,
		] );

		if ( ! ( $this->load( $params ) && $this->validate() ) ) {
			return $dataProvider;
		}

		$query->andFilterWhere( [
			'id'          => $this->id,
			'article_id'  => $this->article_id,
			'sort_number' => $this->sort_number,
		] );

		return $dataProvider;
	}
}

<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "domaines".
 *
 * @property int $id
 * @property string $label
 *
 * @property ArticlesHasDomaines[] $articlesHasDomaines
 * @property Articles[] $articles
 */
class Domaines extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'domaines';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['label'], 'required'],
            [['label'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'label' => 'Label',
        ];
    }

    /**
     * Gets query for [[ArticlesHasDomaines]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArticlesHasDomaines()
    {
        return $this->hasMany(ArticlesHasDomaines::className(), ['domaines_id' => 'id']);
    }

    /**
     * Gets query for [[Articles]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArticles()
    {
        return $this->hasMany(Articles::className(), ['id' => 'articles_id'])->viaTable('articles_has_domaines', ['domaines_id' => 'id']);
    }
}

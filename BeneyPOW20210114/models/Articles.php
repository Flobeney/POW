<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "articles".
 *
 * @property int $id
 * @property string $date_publication
 * @property string $titre
 * @property string $contenu
 * @property int $auteurs_id
 *
 * @property Auteurs $auteurs
 * @property ArticlesHasDomaines[] $articlesHasDomaines
 * @property Domaines[] $domaines
 */
class Articles extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'articles';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date_publication', 'titre', 'contenu', 'auteurs_id'], 'required'],
            [['date_publication'], 'safe'],
            [['contenu'], 'string'],
            [['auteurs_id'], 'integer'],
            [['titre'], 'string', 'max' => 255],
            [['auteurs_id'], 'exist', 'skipOnError' => true, 'targetClass' => Auteurs::className(), 'targetAttribute' => ['auteurs_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date_publication' => 'Date de publication',
            'titre' => 'Titre',
            'contenu' => 'Contenu',
            'auteurs_id' => 'Auteur',
        ];
    }

    /**
     * Gets query for [[Auteurs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuteurs()
    {
        return $this->hasOne(Auteurs::className(), ['id' => 'auteurs_id']);
    }

    /**
     * Gets query for [[ArticlesHasDomaines]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArticlesHasDomaines()
    {
        return $this->hasMany(ArticlesHasDomaines::className(), ['articles_id' => 'id']);
    }

    /**
     * Gets query for [[Domaines]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDomaines()
    {
        return $this->hasMany(Domaines::className(), ['id' => 'domaines_id'])->viaTable('articles_has_domaines', ['articles_id' => 'id']);
    }
}

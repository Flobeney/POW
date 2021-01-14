<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "auteurs".
 *
 * @property int $id
 * @property string $nom
 * @property string $prenom
 * @property int|null $types_id
 *
 * @property Articles[] $articles
 * @property Types $types
 */
class Auteurs extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'auteurs';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nom', 'prenom'], 'required'],
            [['types_id'], 'integer'],
            [['nom', 'prenom'], 'string', 'max' => 100],
            [['types_id'], 'exist', 'skipOnError' => true, 'targetClass' => Types::className(), 'targetAttribute' => ['types_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nom' => 'Nom',
            'prenom' => 'Prénom',
            'types_id' => 'Type',
        ];
    }

    /**
     * Gets query for [[Articles]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArticles()
    {
        return $this->hasMany(Articles::className(), ['auteurs_id' => 'id']);
    }

    /**
     * Gets query for [[Types]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTypes()
    {
        return $this->hasOne(Types::className(), ['id' => 'types_id']);
    }
}

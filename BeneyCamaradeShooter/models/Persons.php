<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "persons".
 *
 * @property int $id
 * @property string|null $nom
 * @property int|null $age
 * @property int|null $offices_id
 *
 * @property Offices $offices
 */
class Persons extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'persons';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['age', 'offices_id'], 'integer'],
            [['nom'], 'string', 'max' => 50],
            [['offices_id'], 'exist', 'skipOnError' => true, 'targetClass' => Offices::className(), 'targetAttribute' => ['offices_id' => 'id']],
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
            'age' => 'Age',
            'offices_id' => 'Bureau',
            'offices.label' => 'Bureau',
        ];
    }

    /**
     * Gets query for [[Offices]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOffices()
    {
        return $this->hasOne(Offices::className(), ['id' => 'offices_id']);
    }

    /**
     * Gets query for [[Competences]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCompetences()
    {
        //Liaison multiple
        return $this->hasMany(
            Competences::className(), 
            ['id' => 'competences_id']
        )->viaTable(
            //Table de liaison
            'person_has_competence',
            ['persons_id' => 'id']
        );
    }
}

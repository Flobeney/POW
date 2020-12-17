<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "competences".
 *
 * @property int $id
 * @property string|null $domaine
 *
 * @property PersonHasCompetence[] $personHasCompetences
 * @property Persons[] $persons
 */
class Competences extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'competences';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['domaine'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'domaine' => 'Domaine',
        ];
    }

    /**
     * Gets query for [[PersonHasCompetences]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPersonHasCompetences()
    {
        return $this->hasMany(PersonHasCompetence::className(), ['competences_id' => 'id']);
    }

    /**
     * Gets query for [[Persons]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPersons()
    {
        return $this->hasMany(Persons::className(), ['id' => 'persons_id'])->viaTable('person_has_competence', ['competences_id' => 'id']);
    }
}

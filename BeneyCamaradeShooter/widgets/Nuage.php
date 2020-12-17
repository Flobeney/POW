<?php
namespace app\widgets;

use Yii;
use yii\helpers\ArrayHelper;

class Nuage extends \yii\bootstrap\Widget
{
    //Constantes
    public $BASE_FONT_SIZE = 1;
    //Champs
    public $competences = array();
    public $cpt = array();
    public $max = 0;
    
    /**
     * {@inheritdoc}
     */
    public function run()
    {
        $res = '';
        //Récupérer les compétences
        $this->competences = (new \app\models\CompetencesSearch())->search(null)->getModels();

        //Pour chaque compétence
        foreach ($this->competences as $competence) {
            //Compter les personnes qui l'ont
            $this->cpt[$competence->domaine] = count($competence->persons);
        }

        //Max
        $this->max = max($this->cpt);

        //Pour chaque occurence
        foreach ($this->cpt as $domaine => $cpt) {
            $res .= '<span style="font-size: ' . (($cpt/$this->max) + $this->BASE_FONT_SIZE) . 'em">' . $domaine .' </span>';
        }

        return $res;
    }
}

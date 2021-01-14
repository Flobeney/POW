<?php
namespace app\widgets;

use Yii;
use yii\helpers\ArrayHelper;

class DisplayArticle extends \yii\bootstrap\Widget
{
    //Constantes
    public $BASE_FONT_SIZE = 1;
    //Champs
    public $article = array();
    public $competences = array();
    public $cpt = array();
    public $max = 0;
    public $prout = 'test';
    
    /**
     * {@inheritdoc}
     */
    public function run()
    {
		$domaines = '';

		foreach (ArrayHelper::getValue($this->article, 'domaines') as $value) {
			$domaines .= '<li>' . $value->label . '</li>';
		}

		$res = '
		<div style="border-style: solid; margin-bottom: 15px;>
			<div style="margin: 25px;">
				<div style="background-color: #b7b7b7;">
					<p>
					'. ArrayHelper::getValue($this->article, 'titre') . '
					</p>
					<p>
					par '. ArrayHelper::getValue($this->article, 'auteurs.nom') . ' ' . ArrayHelper::getValue($this->article, 'auteurs.prenom') . '
					</p>
				</div>
				<div>
					<p>
					publié le '. ArrayHelper::getValue($this->article, 'date_publication') . '
					</p>
					<p>
					'. substr(ArrayHelper::getValue($this->article, 'contenu'), 0, 500) . '...
					</p>
					<p>
					Domaines
					<ul>
					' . $domaines . '
					</ul>
					</p>
				</div>
			</div>
		</div>
		';
        
        return $res;
    }
}
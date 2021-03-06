<?php

namespace app\controllers;

use Yii;
use app\models\Persons;
use app\models\PersonsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PersonsController implements the CRUD actions for Persons model.
 */
class PersonsController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Persons models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PersonsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Persons model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Persons model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Persons();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //Sauver les compétences dans la table de liaison
            $this->createCompetences($model, Yii::$app->request->post()["Persons"]["competences"]);

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Persons model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //Enlever les compétences dans la table de liaison
            $this->deleteCompetences($model);

            //Sauver les compétences dans la table de liaison
            $this->createCompetences($model, Yii::$app->request->post()["Persons"]["competences"]);

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Persons model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        //Enlever les compétences dans la table de liaison
        $this->deleteCompetences($model);

        //Supprimer
        $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Persons model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Persons the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Persons::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    //Méthode pour ajouter les compétences
    private function createCompetences($model, $competences){
        foreach ($competences as $competences_id) {
            //Récupérer la compétence
            $competence = \app\models\Competences::findOne(['id' => $competences_id]);
            //Autre que null (non trouvé)
            if($competence){
                //Sauver la compétence
                $model->link('competences', $competence);
            }
        }
    }

    //Méthode pour supprimer les compétences
    private function deleteCompetences($model){
        $model->unlinkAll('competences', true);
    }
}

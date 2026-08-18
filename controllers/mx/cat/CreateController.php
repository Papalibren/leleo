<?php

namespace app\controllers\mx\cat;

use app\models\Announcements;
use app\models\Cat;
use app\models\FavoriteAnnouncements;
use app\models\User;
use yii\web\Controller;
use Yii;



class CreateController extends Controller
{


    public function actionSearchFather()
    {


        $q = Yii::$app->request -> get()['Cat']['father_id'];

        $gender = ['gender' => 'кот'];

        $view = 'father/search';


        if(is_numeric($q)){
            $cats = Cat::find()->where(['id' => $q])->andWhere($gender)
            ->orderBy('name ASC')->all();
        }else{
            $cats = Cat::find()->where(['like', 'name', "$q"])->andWhere($gender)
            ->orderBy('name ASC')->all();
        }

        return $this->renderPartial($view, compact('cats'));

    }

    public function actionSearchMother()
    {


        $q = Yii::$app->request -> get()['Cat']['mother_id'];

        $gender = ['gender' => 'кошка'];

        $view = 'mother/search';

        if(is_numeric($q)){
            $cats = Cat::find()->where(['id' => $q])->andWhere($gender)
            ->orderBy('name ASC')->all();
        }else{
            $cats = Cat::find()->where(['like', 'name', "$q"])->andWhere($gender)
            ->orderBy('name ASC')->all();
        }

        return $this->renderPartial($view, compact('cats'));

    }

    public function actionSearchOwner()
    {


        $q = Yii::$app->request -> get()['Cat']['owner_id'];


        $view = 'owner/search';

        if(is_numeric($q)){
            $users = User::find()->where(['id' => $q])->orderBy('last_name ASC')->all();
        }else{
            $users = User::find()->where(['like', 'last_name', "$q"])
            ->orderBy('last_name ASC')->all();
        }

        return $this->renderPartial($view, compact('users'));

    }


    public function actionSearchBreeder()
    {

        $q = Yii::$app->request -> get()['Cat']['breeder_id'];


        $view = 'breeder/search';

        if(is_numeric($q)){
            $users = User::find()->where(['id' => $q])->orderBy('last_name ASC')->all();
        }else{
            $users = User::find()->where(['like', 'last_name', "$q"])
            ->orderBy('last_name ASC')->all();
        }

        return $this->renderPartial($view, compact('users'));

    }


    public function actionSelectFather()
    {

        if(Yii::$app -> request ->get('father_id')){
            $id = Yii::$app -> request ->get('father_id');
            $cat = Cat::findOne($id);
            $placeholder = $cat -> name . " id: " . $cat->id . " pedigree :" . $cat->pedigree_number;
            $view = 'father/select';
        }elseif(Yii::$app -> request ->get('mother_id')){
            $id = Yii::$app -> request ->get('mother_id');
            $cat = Cat::findOne($id);
            $placeholder = $cat -> name . " id: " . $cat->id . " pedigree :" . $cat->pedigree_number;
            $view = 'mother/select';
        }


        return $this->renderPartial($view, compact('id', 'placeholder'));
    }

    public function actionSelectMother()
    {

        if(Yii::$app -> request ->get('father_id')){
            $id = Yii::$app -> request ->get('father_id');
            $cat = Cat::findOne($id);
            $placeholder = $cat -> name . " id: " . $cat->id . " pedigree :" . $cat->pedigree_number;
            $view = 'father/select';
        }elseif(Yii::$app -> request ->get('mother_id')){
            $id = Yii::$app -> request ->get('mother_id');
            $cat = Cat::findOne($id);
            $placeholder = $cat -> name . " id: " . $cat->id . " pedigree :" . $cat->pedigree_number;
            $view = 'mother/select';
        }


        return $this->renderPartial($view, compact('id', 'placeholder'));
    }

    public function actionSelectOwner()
    {

        if(Yii::$app -> request ->get('owner_id')){
            $id = Yii::$app -> request ->get('owner_id');
            $user = User::findOne($id);
            $placeholder = $user -> first_name . " " . $user -> last_name . " id: " . $user->id;
            $view = 'owner/select';
        }

        return $this->renderPartial($view, compact('id', 'placeholder'));
    }

    public function actionSelectBreeder()
    {

        if(Yii::$app -> request ->get('breeder_id')){
            $id = Yii::$app -> request ->get('breeder_id');
            $user = User::findOne($id);
            $placeholder = $user -> first_name . " " . $user -> last_name . " id: " . $user->id;
            $view = 'breeder/select';
        }

        return $this->renderPartial($view, compact('id', 'placeholder'));
    }

    public function actionCancelFather()
    {

        if(Yii::$app -> request ->get('father_id')){
            $view = 'father/cancel';
        }elseif(Yii::$app -> request ->get('mother_id')){
            $view = 'mother/cancel';
        }
        return $this->renderPartial($view);
    }


    public function actionCancelMother()
    {

        if(Yii::$app -> request ->get('father_id')){
            $view = 'father/cancel';
        }elseif(Yii::$app -> request ->get('mother_id')){
            $view = 'mother/cancel';
        }
        return $this->renderPartial($view);
    }

    public function actionCancelOwner()
    {

        $view = 'owner/cancel';

        return $this->renderPartial($view);
    }


    public function actionCancelBreeder()
    {

        $view = 'breeder/cancel';

        return $this->renderPartial($view);
    }

    public function actionAddOwner()
    {
        $request = Yii::$app->request;


        $user = new User();
        $user->scenario = User::SCENARIO_OTHER;
        $user -> last_name = $request->post('last_name');
        $user -> first_name = $request->post('first_name');
        $user -> country = $request->post('country');
        $user -> city = $request->post('city');

        if($user -> save()){
            $id = $user -> id;
            $placeholder = $user -> first_name . " " . $user -> last_name . " id: " . $user->id;
        }else{
            du($user -> getErrors());
        }

        $view = 'owner/add';

        return $this->renderPartial($view, compact('id', 'placeholder'));
    }


    public function actionAddBreeder()
    {
        $request = Yii::$app->request;


        $user = new User();
        $user->scenario = User::SCENARIO_OTHER;
        $user -> last_name = $request->post('last_name');
        $user -> first_name = $request->post('first_name');
        $user -> country = $request->post('country');
        $user -> city = $request->post('city');

        if($user -> save()){
            $id = $user -> id;
            $placeholder = $user -> first_name . " " . $user -> last_name . " id: " . $user->id;
        }else{
            du($user -> getErrors());
        }

        $view = 'breeder/add';

        return $this->renderPartial($view, compact('id', 'placeholder'));
    }

    public function actionAddFather()
    {
        $request = Yii::$app->request;


        $view = 'father/self';

        return $this->renderPartial($view);
    }

    public function actionAddMother()
    {
        $request = Yii::$app->request;


        $view = 'mother/self';

        return $this->renderPartial($view);
    }

}

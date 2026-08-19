<?php

namespace app\models;

use Yii;
use yii\helpers\Url;



class Dog extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'dog';
    }

    const SCENARIO_OTHER = 'other'; //Сценарий при добавлении другим пользователем
    const SCENARIO_UPDATE = 'update'; // Сценарий редактирования существующего животного (защита полей из документов)

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_OTHER] = ['name', 'translit', 'gender', 'color_id', 'pedigree_number'];
        // Поля, которые нельзя менять после создания (сверяются с документами при модерации)
        $scenarios[self::SCENARIO_UPDATE] = [
            'breed', 'gender', 'chip',
            'is_for_mating', 'mating_contacts',
            'is_for_sale', 'sale_contacts', 'price',
            'owner_id', 'breeder_id', 'father_id', 'mother_id',
            'titles', 'additional_info', 'height_cm', 'weight_kg',
        ];
        return $scenarios;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'translit', 'gender', 'color_id', 'pedigree_number'], 'required', 'on' => self::SCENARIO_OTHER],
            [['name', 'translit', 'gender', 'color_id', 'pedigree_number'], 'required'],
            [['breed', 'gender', 'mating_contacts', 'sale_contacts', 'titles', 'additional_info'], 'string'],
            [['birth_date', 'created_at', 'updated_at'], 'safe'],
            [['color_id', 'is_for_mating', 'is_for_sale', 'owner_id', 'breeder_id', 'father_id', 'mother_id', 'is_active', 'is_ad_active', 'user_added_id', 'user_updated_id'], 'integer'],
            [['price'], 'number'],
            [['height_cm', 'weight_kg'], 'double'],
            [['name', 'translit'], 'string', 'max' => 250],
            [['pedigree_number', 'chip'], 'string', 'max' => 100],
            [['pedigree_number'], 'unique'],
            [['color_id'], 'exist', 'skipOnError' => true, 'targetClass' => DogColor::class, 'targetAttribute' => ['color_id' => 'id']],
            [['owner_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['owner_id' => 'id']],
            [['breeder_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['breeder_id' => 'id']],
            [['father_id'], 'exist', 'skipOnError' => true, 'targetClass' => Dog::class, 'targetAttribute' => ['father_id' => 'id']],
            [['mother_id'], 'exist', 'skipOnError' => true, 'targetClass' => Dog::class, 'targetAttribute' => ['mother_id' => 'id']],
            [['user_added_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_added_id' => 'id']],
            [['user_updated_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_updated_id' => 'id']],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Кличка',
            'translit' => 'Транслит',
            'breed' => 'Порода',
            'birth_date' => 'Дата рождения',
            'gender' => 'Пол',
            'color_id' => 'Окрас',
            'pedigree_number' => 'Родословная',
            'chip' => 'Чип',
            'is_for_mating' => 'Для вязки',
            'mating_contacts' => 'Контакты для связи',
            'is_for_sale' => 'Для продажи',
            'sale_contacts' => 'Контакты для связи',
            'price' => 'Стоимость',
            'owner_id' => 'Владелец',
            'breeder_id' => 'Заводчик',
            'father_id' => 'Отец',
            'mother_id' => 'Мать',
            'titles' => 'Титулы',
            'additional_info' => 'Дополнительная информация',
            'created_at' => 'Добавлен',
            'updated_at' => 'Изменён',
            'is_active' => 'Статус',
            'is_ad_active' => 'Статус объявления',
            'height_cm' => 'Рост',
            'weight_kg' => 'Вес',
        ];
    }

    /**
     * Gets query for [[Breeder]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBreeder()
    {
        return $this->hasOne(User::class, ['id' => 'breeder_id']);
    }

    /**
     * Gets query for [[DogDocuments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDogDocuments()
    {
        return $this->hasMany(DogDocuments::class, ['dog_id' => 'id']);
    }

    /**
     * Gets query for [[DogPhotos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDogPhotos()
    {
        return $this->hasMany(DogPhotos::class, ['dog_id' => 'id']);
    }

    /**
     * Gets query for [[Dogs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDogs()
    {
        return $this->hasMany(Dog::class, ['father_id' => 'id']);
    }

    /**
     * Gets query for [[Dogs0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDogs0()
    {
        return $this->hasMany(Dog::class, ['mother_id' => 'id']);
    }

    /**
     * Gets query for [[Color]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getColor()
    {
        return $this->hasOne(DogColor::class, ['id' => 'color_id']);
    }

    /**
     * Gets query for [[Father]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFather()
    {
        return $this->hasOne(Dog::class, ['id' => 'father_id']);
    }

    /**
     * Gets query for [[Mother]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMother()
    {
        return $this->hasOne(Dog::class, ['id' => 'mother_id']);
    }

    /**
     * Gets query for [[Owner]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOwner()
    {
        return $this->hasOne(User::class, ['id' => 'owner_id']);
    }

    public function getUserAdded()
    {
        return $this->hasOne(User::class, ['id' => 'user_added_id']);
    }

    private function isPhotoExist()
    {
        return !empty(DogPhotos::find()->where(['dog_id' => $this->id])->asArray()->all());
    }

    public function getPhotos()
    {
        if ($this->isPhotoExist()) {
            return DogPhotos::find()->where(['dog_id' => $this->id])->all();
        } else {
            return DogColor::find()->where(['id' => $this->color_id])->all();
        }
    }

    public function getFirstPhoto()
    {
        if ($this->isPhotoExist()) {
            return DogPhotos::find()->where(['dog_id' => $this->id])
                ->orderBy('sort_order ASC')->one();
        } else {
            return DogColor::findOne($this->color_id);
        }
    }

    public function getMainPhotoPath()
    {
        return "/" . $this->getFirstPhoto()->image_path;
    }

    //***

    public function getAncestorsTree($generations = 5): array
    {
        $tree = [];

        $buildTree = function ($dog, $depth) use (&$buildTree, $generations) {
            if ($depth > $generations || $dog === null) {
                return null;
            }

            return [
                'dog' => $dog,
                'father' => $buildTree($dog->father, $depth + 1),
                'mother' => $buildTree($dog->mother, $depth + 1),
            ];
        };

        return $buildTree($this, 1);
    }

    public function getFlattenedAncestorsForJs($generations = 5): array
    {
        $result = [];
        $visited = [];

        $build = function ($node, $depth, $childId = null) use (&$build, &$result, &$visited, $generations) {
            if (!$node || !isset($node['dog']) || $depth > $generations) return;

            $dog = $node['dog'];
            if (isset($visited[$dog->id])) return;
            $visited[$dog->id] = true;
            $url = Url::to(['/dogs/view', 'id' => $dog->id, 'translit' => $dog->translit]);
            $hasParents = !empty($node['father']) || !empty($node['mother']);

            $item = [
                'id' => $dog->id,
                'name' => $dog->name,
                'title' => $dog->pedigree_number ?? '',
                'img' => $dog->mainPhotoPath ?: '/img/default-dog.webp',
                'tags' => [$depth === 1 ? 'Management' : ''],
                'link' => $url,
                'link_html' => '<a href="' . $url . '" target="_blank" style="color:green;text-decoration:none;">'
                    . $dog->name . '</a>',
                'edit' => $hasParents ? '' : '<a href="' . '/dogs/edit/?id=' . $dog->id . '" target="_blank" style="color:#039BE5;text-decoration:none;">'
                    . 'Добавить родителей' . '</a>'
            ];


            if ($childId) {
                $item['pid'] = $childId;
            }

            $result[] = $item;

            if (!empty($node['father'])) {
                $build($node['father'], $depth + 1, $dog->id);
            }
            if (!empty($node['mother'])) {
                $build($node['mother'], $depth + 1, $dog->id);
            }
        };

        $tree = $this->getAncestorsTree($generations);
        $build($tree, 1);

        //    du($result);

        return $result;
    }


    public function toggleStatusWithAncestors($newStatus = null)
    {
        if ($newStatus === null) {
            $this->is_active = !$this->is_active;
        } else {
            $this->is_active = $newStatus;
        }
        $this->save(false);

        if ($this->father) {
            $this->father->toggleStatusWithAncestors($this->is_active);
        }
        if ($this->mother) {
            $this->mother->toggleStatusWithAncestors($this->is_active);
        }
    }


    public function hasParents()
    {
        return (bool)$this->father && (bool)$this->getMother();
    }

    public function isAncestor()
    {
        return self::find()
            ->where(['mother_id' => $this->id])
            ->orWhere(['father_id' => $this->id])
            ->exists();
    }
}
<?php

namespace app\models;

use Yii;
use yii\helpers\Url;

class Cat extends \yii\db\ActiveRecord
{
    const SCENARIO_OTHER = 'other'; // Сценарий при добавлении другим пользователем

    public static function tableName()
    {
        return 'cat';
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_OTHER] = ['name', 'translit', 'gender', 'color_id', 'pedigree_number'];
        return $scenarios;
    }

    public function behaviors()
    {
        return [
            [
                'class' => \yii\behaviors\TimestampBehavior::class,
                'value' => new \yii\db\Expression('NOW()'),
            ],
            [
                'class' => \app\behaviors\CatHistoryBehavior::class,
            ],
        ];
    }

    public function rules()
    {
        return [
            [['name', 'translit', 'gender', 'color_id', 'pedigree_number'], 'required', 'on' => self::SCENARIO_OTHER],
            [['name', 'translit', 'gender', 'color_id', 'pedigree_number'], 'required'],
            [['breed', 'gender', 'mating_contacts', 'sale_contacts', 'titles', 'additional_info'], 'string'],
            [['birth_date', 'created_at', 'updated_at'], 'safe'],
            [['color_id', 'is_for_mating', 'is_for_sale', 'owner_id', 'breeder_id', 'father_id', 'mother_id', 'is_active', 'is_ad_active', 'user_added_id', 'user_updated_id'], 'integer'],
            [['price'], 'number'],
            [['name', 'translit'], 'string', 'max' => 250],
            [['pedigree_number', 'chip'], 'string', 'max' => 100],
            [['pedigree_number'], 'unique'],
            [['color_id'], 'exist', 'skipOnError' => true, 'targetClass' => CatColor::class, 'targetAttribute' => ['color_id' => 'id']],
            [['owner_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['owner_id' => 'id']],
            [['breeder_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['breeder_id' => 'id']],
            [['father_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cat::class, 'targetAttribute' => ['father_id' => 'id']],
            [['mother_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cat::class, 'targetAttribute' => ['mother_id' => 'id']],
            [['user_added_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_added_id' => 'id']],
            [['user_updated_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_updated_id' => 'id']],
        ];
    }

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
            'user_added_id' => 'Добавил пользователь',
            'user_updated_id' => 'Обновил пользователь',
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                // При создании устанавливаем пользователя
                if (Yii::$app->user->id && empty($this->user_added_id)) {
                    $this->user_added_id = Yii::$app->user->id;
                }
            } else {
                // При обновлении устанавливаем пользователя
                if (Yii::$app->user->id) {
                    $this->user_updated_id = Yii::$app->user->id;
                }
            }
            return true;
        }
        return false;
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
     * Gets query for [[CatDocuments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCatDocuments()
    {
        return $this->hasMany(CatDocuments::class, ['cat_id' => 'id']);
    }

    /**
     * Gets query for [[CatPhotos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCatPhotos()
    {
        return $this->hasMany(CatPhotos::class, ['cat_id' => 'id']);
    }

    /**
     * Gets query for [[Cats]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCats()
    {
        return $this->hasMany(Cat::class, ['father_id' => 'id']);
    }

    /**
     * Gets query for [[Cats0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCats0()
    {
        return $this->hasMany(Cat::class, ['mother_id' => 'id']);
    }

    /**
     * Gets query for [[Color]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getColor()
    {
        return $this->hasOne(CatColor::class, ['id' => 'color_id']);
    }

    /**
     * Gets query for [[Father]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFather()
    {
        return $this->hasOne(Cat::class, ['id' => 'father_id']);
    }

    /**
     * Gets query for [[Mother]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMother()
    {
        return $this->hasOne(Cat::class, ['id' => 'mother_id']);
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

    /**
     * Gets query for [[UserAdded]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserAdded()
    {
        return $this->hasOne(User::class, ['id' => 'user_added_id']);
    }

    /**
     * Gets query for [[UserUpdated]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserUpdated()
    {
        return $this->hasOne(User::class, ['id' => 'user_updated_id']);
    }

    /**
     * Gets query for [[History]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHistory()
    {
        return $this->hasMany(CatHistory::class, ['cat_id' => 'id'])->orderBy(['created_at' => SORT_DESC]);
    }

    /**
     * Gets query for [[PendingModeration]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPendingModeration()
    {
        return $this->hasOne(CatModeration::class, ['cat_id' => 'id'])
            ->andWhere(['status' => CatModeration::STATUS_PENDING]);
    }

    private function isPhotoExist()
    {
        return !empty(CatPhotos::find()->where(['cat_id' => $this->id])->asArray()->all());
    }

    public function getPhotos()
    {
        if ($this->isPhotoExist()) {
            return CatPhotos::find()->where(['cat_id' => $this->id])->all();
        } else {
            return CatColor::find()->where(['id' => $this->color_id])->all();
        }
    }

    public function getFirstPhoto()
    {
        if ($this->isPhotoExist()) {
            return CatPhotos::find()->where(['cat_id' => $this->id])
                ->orderBy('sort_order ASC')->one();
        } else {
            return CatColor::findOne($this->color_id);
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

        $buildTree = function ($cat, $depth) use (&$buildTree, $generations) {
            if ($depth > $generations || $cat === null) {
                return null;
            }

            return [
                'cat' => $cat,
                'father' => $buildTree($cat->father, $depth + 1),
                'mother' => $buildTree($cat->mother, $depth + 1),
            ];
        };

        return $buildTree($this, 1);
    }

    public function getFlattenedAncestorsForJs($generations = 5): array
    {
        $result = [];
        $visited = [];

        $build = function ($node, $depth, $childId = null) use (&$build, &$result, &$visited, $generations) {
            if (!$node || !isset($node['cat']) || $depth > $generations) return;

            $cat = $node['cat'];
            if (isset($visited[$cat->id])) return;
            $visited[$cat->id] = true;
            $url = Url::to(['/cats/view', 'id' => $cat->id, 'translit' => $cat->translit]);
            $hasParents = !empty($node['father']) || !empty($node['mother']);

            $item = [
                'id' => $cat->id,
                'name' => $cat->name,
                'title' => $cat->pedigree_number ?? '',
                'img' => $cat->mainPhotoPath ?: '/img/default-cat.webp',
                'tags' => [$depth === 1 ? 'Management' : ''],
                'link' => $url,
                'link_html' => '<a href="' . $url . '" target="_blank" style="color:green;text-decoration:none;">'
                    . $cat->name . '</a>',
                'edit' => $hasParents ? '' : '<a href="' . '/cats/edit/?id=' . $cat->id . '" target="_blank" style="color:#039BE5;text-decoration:none;">'
                    . 'Добавить родителей' . '</a>'
            ];

            if ($childId) {
                $item['pid'] = $childId;
            }

            $result[] = $item;

            if (!empty($node['father'])) {
                $build($node['father'], $depth + 1, $cat->id);
            }
            if (!empty($node['mother'])) {
                $build($node['mother'], $depth + 1, $cat->id);
            }
        };

        $tree = $this->getAncestorsTree($generations);
        $build($tree, 1);

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

    /**
     * Отправляет кошку на модерацию
     */
    public function sendToModeration()
    {
        $this->is_active = 0;
        return $this->save(false);
    }

    /**
     * Проверяет, находится ли кошка на модерации
     */
    public function isOnModeration()
    {
        return $this->is_active == 0 && $this->pendingModeration !== null;
    }

    /**
     * Возвращает последнюю запись модерации
     */
    public function getLastModeration()
    {
        return $this->hasOne(CatModeration::class, ['cat_id' => 'id'])
            ->orderBy(['created_at' => SORT_DESC]);
    }

    /**
     * Возвращает все записи модерации
     */
    public function getModerations()
    {
        return $this->hasMany(CatModeration::class, ['cat_id' => 'id'])
            ->orderBy(['created_at' => SORT_DESC]);
    }
}
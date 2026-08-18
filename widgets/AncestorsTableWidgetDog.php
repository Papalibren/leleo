<?php

namespace app\widgets;

use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;

class AncestorsTableWidgetDog extends Widget
{
    /** @var \app\models\Dog */
    public $model;

    /** @var int Поколений видно по умолчанию */
    public $defaultGenerations = 3;

    /** @var int Максимум колонок в таблице */
    public $maxGenerations = 6;

    public function run()
    {
        $tree = $this->model->getAncestorsTree($this->maxGenerations);

        $hasAncestors = !empty($tree['father']) || !empty($tree['mother']);
        if (!$hasAncestors) {
            return Html::tag('p', 'Родословная отсутствует: данные о родителях не указаны.', ['class' => 'text-muted']);
        }

        // Считаем строки для верхних веток (отец/мать текущей кошки)
        $rowsFather = !empty($tree['father']) ? $this->countLeaves($tree['father'], 1) : 0;
        $rowsMother = !empty($tree['mother']) ? $this->countLeaves($tree['mother'], 1) : 0;
        $totalRows  = max(1, $rowsFather + $rowsMother);

        // Решётка ячеек: $cells[row][col] = ['Dog'=>Dog,'rowspan'=>int,'hasFather'=>bool,'hasMother'=>bool]
        $cells = [];

        // Детёрминированное размещение узлов
        $currentRow = 1;
        if (!empty($tree['father'])) {
            $this->placeNode($cells, $tree['father'], 1, $currentRow);
            $currentRow += $rowsFather;
        }
        if (!empty($tree['mother'])) {
            $this->placeNode($cells, $tree['mother'], 1, $currentRow);
        }

        // --- Рендер ---
        ob_start();

        echo Html::tag('h3', 'Родословная', ['class' => 'mt-4']);

        // Панель управления поколениями
        echo <<<HTML
        <div class="mb-3">
            <label class="form-label">Количество поколений:</label>
HTML;
        for ($i = 3; $i <= $this->maxGenerations; $i++) {
            $checked = $i == $this->defaultGenerations ? 'checked' : '';
            echo <<<HTML
            <div class="form-check form-check-inline">
                <input class="form-check-input generations-radio" type="radio" name="generations" id="gen{$i}" value="{$i}" {$checked}>
                <label class="form-check-label" for="gen{$i}">{$i}</label>
            </div>
HTML;
        }
        echo <<<HTML
        </div>

        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" id="toggle-photos" checked>
            <label class="form-check-label" for="toggle-photos">
                Показать фото
            </label>
        </div>
HTML;

        echo Html::beginTag('div', ['class' => 'table-responsive']);
        echo Html::beginTag('table', ['class' => 'table table-bordered text-center align-middle ancestors-table']);
        echo Html::beginTag('thead', ['class' => 'table-light']);
        echo Html::beginTag('tr');
        for ($col = 1; $col <= $this->maxGenerations; $col++) {
            $classes = $col > $this->defaultGenerations ? 'd-none' : '';
            echo Html::tag('th', "{$col} поколение", ['data-generation' => $col, 'class' => $classes]);
        }
        echo Html::endTag('tr');
        echo Html::endTag('thead');

        echo Html::beginTag('tbody');
        for ($row = 1; $row <= $totalRows; $row++) {
            echo Html::beginTag('tr');
            for ($col = 1; $col <= $this->maxGenerations; $col++) {

                if (isset($cells[$row][$col])) {
                    $cell = $cells[$row][$col];
                    $Dog  = $cell['Dog'];

                    $photoUrl = $Dog->getFirstPhoto()
                        ? '/' . $Dog->getFirstPhoto()->image_path
                        : '/img/default-Dog.webp';

                    $nurseryLink = '';
                    if ($Dog->breeder && $Dog->breeder->nursery) {
                        $nursery = $Dog->breeder->nursery;
                        $nurseryLink = '<br><a href="' . Url::to(['/nursery/view', 'id' => $nursery->id]) . '" target="_blank" class="badge bg-success">'
                            . Html::encode($nursery->title) . '</a>';
                    }

                    echo Html::beginTag('td', [
                        'rowspan' => $cell['rowspan'],
                        'data-generation' => $col,
                        'class' => ($col > $this->defaultGenerations ? 'd-none' : '')
                    ]);

                    // Фото
                    echo Html::beginTag('div', ['class' => 'ancestor-photo mb-2']);
                    echo Html::a(
                        Html::img($photoUrl, ['style' => 'max-width: 80px; max-height: 80px;']),
                        ['/dogs/view', 'id' => $Dog->id, 'translit' => $Dog->translit],
                        ['target' => '_blank']
                    );
                    echo Html::endTag('div');

                    // Имя + родословная
                    echo Html::a(
                        Html::encode($Dog->name),
                        ['/dogs/view', 'id' => $Dog->id, 'translit' => $Dog->translit],
                        ['target' => '_blank']
                    );
                    echo '<br><small class="text-muted">' . Html::encode($Dog->pedigree_number) . '</small>';
                    echo $nurseryLink;

                    // Кнопки добавления родителей (в этой же ячейке)
                    echo Html::beginTag('div', ['class' => 'mt-2']);
                    if (empty($cell['hasFather'])) {
                        echo Html::a(
                            '<i class="bi bi-gender-male"></i>',
                            "/user/dog/create-parent?type=father&child_id={$Dog -> id}",
                            [
                                'class' => 'btn btn-danger btn-sm me-1',
                                'title' => 'Добавить отца',
                                'role'  => 'button',
                            ]
                        );
                    }
                    if (empty($cell['hasMother'])) {
                        echo Html::a(
                            '<i class="bi bi-gender-female"></i>',
                            "/user/dog/create-parent?type=mother&child_id={$Dog -> id}",
                            [
                                'class' => 'btn btn-warning btn-sm',
                                'title' => 'Добавить мать',
                                'role'  => 'button',
                            ]
                        );
                    }
                    echo Html::endTag('div');

                    echo Html::endTag('td');
                } else {
                    // Проверяем, «накрыта» ли эта колонка rowspan-ом сверху.
                    $covered = false;
                    for ($r0 = $row - 1; $r0 >= 1; $r0--) {
                        if (isset($cells[$r0][$col])) {
                            $start = $r0;
                            $span  = $cells[$r0][$col]['rowspan'];
                            if ($row < $start + $span) {
                                $covered = true;
                            }
                            break;
                        }
                    }

                    if (!$covered) {
                        echo Html::tag('td', '', [
                            'data-generation' => $col,
                            'class' => ($col > $this->defaultGenerations ? 'd-none' : '')
                        ]);
                    }
                }
            }
            echo Html::endTag('tr');
        }
        echo Html::endTag('tbody');
        echo Html::endTag('table');
        echo Html::endTag('div');

        $this->getView()->registerJs($this->registerJsCode());

        return ob_get_clean();
    }

    /**
     * «Высота» поддерева в строках (кол-во листьев или 1).
     * $depth — поколение текущего узла (1 — родители текущей кошки).
     */
    private function countLeaves($node, $depth)
    {
        if (!$node || !isset($node['dog'])) {
            return 1;
        }
        if ($depth >= $this->maxGenerations) {
            return 1;
        }

        $hasFather = !empty($node['father']);
        $hasMother = !empty($node['mother']);

        if (!$hasFather && !$hasMother) {
            return 1;
        }

        $left  = $hasFather ? $this->countLeaves($node['father'], $depth + 1) : 0;
        $right = $hasMother ? $this->countLeaves($node['mother'], $depth + 1) : 0;

        $sum = $left + $right;
        return $sum > 0 ? $sum : 1;
    }

    /**
     * Размещает узел и рекурсивно раскладывает родителей так,
     * чтобы отец и мать шли подряд в пределах rowspan ребёнка.
     *
     * @param array $cells
     * @param array $node ['Dog'=>Dog,'father'=>...,'mother'=>...]
     * @param int   $depth колонка (1..maxGenerations)
     * @param int   $rowStart строка начала
     * @return int  rowspan узла
     */
    private function placeNode(array &$cells, $node, int $depth, int $rowStart): int
    {
        $span = $this->countLeaves($node, $depth);
        $cells[$rowStart][$depth] = [
            'Dog'       => $node['dog'],
            'rowspan'   => $span,
            'hasFather' => !empty($node['father']),
            'hasMother' => !empty($node['mother']),
        ];

        if ($depth >= $this->maxGenerations) {
            return $span;
        }

        $fatherSpan = !empty($node['father']) ? $this->countLeaves($node['father'], $depth + 1) : 0;
        $motherSpan = !empty($node['mother']) ? $this->countLeaves($node['mother'], $depth + 1) : 0;

        // Отец — верх блока, мать — низ блока
        if ($fatherSpan > 0) {
            $this->placeNode($cells, $node['father'], $depth + 1, $rowStart);
        }
        if ($motherSpan > 0) {
            $this->placeNode($cells, $node['mother'], $depth + 1, $rowStart + $fatherSpan);
        }

        return $span;
    }

    private function registerJsCode()
    {
        return <<<JS
            $('.generations-radio').on('change', function() {
                var gens = $(this).val();
                for (var i = 1; i <= {$this->maxGenerations}; i++) {
                    if (i <= gens) {
                        $('[data-generation="' + i + '"]').removeClass('d-none');
                    } else {
                        $('[data-generation="' + i + '"]').addClass('d-none');
                    }
                }
            });

            $('#toggle-photos').on('change', function() {
                if ($(this).is(':checked')) {
                    $('.ancestor-photo').show();
                } else {
                    $('.ancestor-photo').hide();
                }
            });
        JS;
    }
}

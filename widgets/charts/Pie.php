<?php

namespace app\widgets\charts;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;

class Pie extends Widget
{

    public function init()
    {
        parent::init();
        $js = <<<js
        google.charts.load('current', {'packages':['corechart', 'table', 'sankey']});
        google.charts.setOnLoadCallback(drawChart);
        function drawChart() {
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Topping');
            data.addColumn('number', 'Slices');
            data.addRows([
            ['Mushrooms', 3],
            ['Onions', 1],
            ['Olives', 1],
            ['Zucchini', 1],
            ['Pepperoni', 2]
            ]);
            var options = {'title':'How Much Pizza I Ate Last Night',
                        'width':400,
                        'height':300};

            var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
            chart.draw(data, options);
        }
        js;
        $view = $this->getView();
        GoogleChartAsset::register($view);
        $view->registerJs($js);
    }

}
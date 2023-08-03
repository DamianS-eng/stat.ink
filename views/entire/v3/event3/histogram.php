<?php

declare(strict_types=1);

use MathPHP\Probability\Distribution\Continuous\Normal as NormalDistribution;
use app\assets\ChartJsAsset;
use app\assets\ColorSchemeAsset;
use app\assets\RatioAsset;
use app\models\Event3StatsPower;
use yii\helpers\Html;
use yii\web\JsExpression;
use yii\web\View;

/**
 * @var Event3StatsPower $abstract
 * @var View $this
 * @var array<int, int> $histogram
 */

ChartJsAsset::register($this);
ColorSchemeAsset::register($this);
RatioAsset::register($this);

$this->registerJs("
  jQuery('.event3-histogram').each(
    function () {
      function looseJsonParse (obj) {
        return Function('\"use strict\";return (' + obj + ')')();
      }

      const elem = this;
      const config = looseJsonParse(this.getAttribute('data-chart'));
      const canvas = elem.appendChild(document.createElement('canvas'));
      new window.Chart(canvas.getContext('2d'), config);
    }
  );
");

$datasetHistogram = [
  'backgroundColor' => [
    new JsExpression('window.colorScheme.graph2'),
  ],
  'barPercentage' => 1.0,
  'borderColor' => [
    new JsExpression('window.colorScheme.graph2'),
  ],
  'borderWidth' => 1,
  'categoryPercentage' => 1.0,
  'data' => array_values(
    array_map(
      fn (int $x, int $y): array => compact('x', 'y'),
      array_keys($histogram),
      array_values($histogram),
    ),
  ),
  'label' => Yii::t('app', 'Battles'),
  'type' => 'bar',
];

$datasetNormalDistrib = null;
if (
  $abstract->battles >= 20 &&
  $abstract->maximum > 0 &&
  $abstract->stddev > 0
) {
  $makeDistributionData = function (NormalDistribution $nd) use ($abstract): array {
    $results = [];
    $dataStep = (int)$abstract->histogram_width;
    $makeStep = 2;
    $chartMin = max(
      0,
      (int)(floor($abstract->average - 3 * $abstract->stddev) / $makeStep) * $makeStep,
    );
    $chartMax = (int)(ceil($abstract->average + 3 * $abstract->stddev) / $makeStep) * $makeStep;
    for ($x = $chartMin; $x <= $chartMax; $x += $makeStep) {
      $results[] = [
        'x' => $x,
        'y' => $nd->pdf($x) * $dataStep * $abstract->agg_battles,
      ];
    }
    return $results;
  };

  $datasetNormalDistrib = [
    'backgroundColor' => [ new JsExpression('window.colorScheme.graph1') ],
    'borderColor' => [ new JsExpression('window.colorScheme.graph1') ],
    'borderWidth' => 2,
    'data' => $makeDistributionData(
      new NormalDistribution($abstract->average, $abstract->stddev),
    ),
    'label' => Yii::t('app', 'Normal Distribution'),
    'pointRadius' => 0,
    'type' => 'line',
  ];
}

?>
<?= Html::tag('div', '', [
  'class' => 'event3-histogram ratio ratio-4x3 mb-1',
  'style' => [
    'max-width' => '480px',
  ],
  'data' => [
    'chart' => [
      'data' => [
        'datasets' => array_values(
          array_filter(
            [
              $datasetNormalDistrib,
              $datasetHistogram,
            ],
            fn ($v) => $v !== null,
          ),
        ),
      ],
      'options' => [
        'animation' => [
          'duration' => 0,
        ],
        'aspectRatio' => 4 / 3, // 16 / 10,
        'plugins' => [
          'legend' => [
            'display' => true,
            'reverse' => true,
          ],
          'tooltip' => [
            'enabled' => false,
          ],
        ],
        'scales' => [
          'x' => [
            'grid' => [
               'offset' => false,
            ],
            'offset' => true,
            'title' => [
              'display' => true,
              'text' => Yii::t('app', 'Challenge Power'),
            ],
            'type' => 'linear',
            'ticks' => [
              'precision' => 0,
              'stepSize' => 100,
            ],
          ],
          'y' => [
            'min' => 0,
            'title' => [
              'display' => true,
              'text' => Yii::t('app', 'Battles'),
            ],
            'type' => 'linear',
          ],
        ],
      ],
    ],
  ],
]) . "\n" ?>
<p class="small text-muted mb-3">
  <?= Html::encode(
    Yii::t(
      'app',
      'This data is based on {siteName} users and differs significantly from overall game statistics.',
      [
        'siteName' => Yii::$app->name,
      ],
    ),
  ) . "\n" ?>
</p>
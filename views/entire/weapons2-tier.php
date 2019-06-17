<?php
declare(strict_types=1);

use app\assets\Spl2WeaponAsset;
use app\components\widgets\AdWidget;
use app\components\widgets\FA;
use app\components\widgets\GameModeIcon;
use app\components\widgets\SnsWidget;
use app\models\StatWeapon2Tier;
use yii\bootstrap\Nav;
use yii\data\ArrayDataProvider;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;

$title = implode(' | ', [
  Yii::$app->name,
  Yii::t('app', 'Weapon'),
  Yii::t('app', 'Version {0}', [
    Yii::t('app-version2', $versionGroup->name),
  ]),
  $month,
  Yii::t('app-rule2', $rule->name),
]);
$this->title = $title;

$this->registerMetaTag(['name' => 'twitter:card', 'content' => 'summary']);
$this->registerMetaTag(['name' => 'twitter:title', 'content' => $title]);
$this->registerMetaTag(['name' => 'twitter:description', 'content' => $title]);
$this->registerMetaTag(['name' => 'twitter:site', 'content' => '@stat_ink']);
if ($prev) {
  $this->registerLinkTag(['rel' => 'prev', 'href' => $prev]);
}
if ($next) {
  $this->registerLinkTag(['rel' => 'next', 'href' => $next]);
}

$kdCell = function (StatWeapon2Tier $model, string $column): ?string {
  return implode('<br>', [
    vsprintf('%s=%s±%s', [
      Html::tag('span', Html::encode('μ'), [
        'title' => Yii::t('app', 'Average'),
        'class' => 'auto-tooltip',
      ]),
      Yii::$app->formatter->asDecimal($model->{"avg_{$column}"}, 2),
      Yii::$app->formatter->asDecimal($model->{"stderr_{$column}"} * 2, 2),
    ]),
    vsprintf('%s=%s', [
      Html::tag('span', Html::encode('Med'), [
        'title' => Yii::t('app', 'Median'),
        'class' => 'auto-tooltip',
      ]),
      Yii::$app->formatter->asDecimal($model->{"med_{$column}"}, 1),
    ]),
    vsprintf('%s=%s', [
      Html::tag('span', Html::encode('σ'), [
        'title' => Yii::t('app', 'Standard Deviation'),
        'class' => 'auto-tooltip',
      ]),
      Yii::$app->formatter->asDecimal($model->{"stddev_{$column}"}, 3),
    ]),
  ]);
};
?>
<div class="container">
  <h1><?= Html::encode(vsprintf('%s (%s, %s) - %s (alpha)', [
    Yii::t('app-rule2', $rule->name),
    $month,
    Yii::t('app', 'Version {0}', [
      Yii::t('app-version2', $versionGroup->name),
    ]),
    Yii::t('app', 'Weapon Tier'),
  ])) ?></h1>

  <?= AdWidget::widget() . "\n" ?>
  <?= SnsWidget::widget() . "\n" ?>

  <nav>
    <div class="row mb-3">
      <div class="col-xs-6 text-left"><?php
        if ($prev) {
          echo Html::a(
            implode(' ', [
              (string)FA::fas('angle-double-left')->fw(),
              Html::encode(Yii::t('app', 'Prev.')),
            ]),
            $prev,
            ['class' => 'btn btn-default']
          );
        }
      ?></div>
      <div class="col-xs-6 text-right"><?php
        if ($next) {
          echo Html::a(
            implode(' ', [
              Html::encode(Yii::t('app', 'Next')),
              (string)FA::fas('angle-double-right')->fw(),
            ]),
            $next,
            ['class' => 'btn btn-default']
          );

          if ($latest && $next !== $latest) {
            echo Html::a(
              implode(' ', [
                Html::encode(Yii::t('app', 'Latest')),
                (string)FA::fas('angle-double-right')->fw(),
              ]),
              $latest,
              ['class' => 'btn btn-default ml-2']
            );
          }
        }
      ?></div>
    </div>
  </nav>

  <ul class="mb-3">
    <li>
      Targets:
      <ul>
        <li>Ranked battles (not including League battles)</li>
        <li><?= Html::encode(vsprintf('Rank %s only', [
          version_compare($versionGroup->tag, '3.0', '>=') ? 'X' : 'S+',
        ])) ?></li>
        <li>Excluded the uploader (<?= Html::encode(Yii::$app->name) ?>'s user)</li>
        <li><?= Html::encode(vsprintf('Filtered: n%s%s', [
          (substr(Yii::$app->language, 0, 3) === 'ja-') ? '≧' : '≥',
          Yii::$app->formatter->asInteger(StatWeapon2Tier::PLAYERS_COUNT_THRESHOLD),
        ])) ?></li>
      </ul>
    </li>
    <li>
      Kills and deaths:
      <ul>
        <li>Normalized to 5 minutes (even KO or overtimed)</li>
      </ul>
    </li>
    <li>
      ±:
      <ul>
        <li>
          Perhaps "the real value" is somewhere in the range.
          Don't too believe the representative (average) value.
        </li>
        <li>
          2&times;<i><abbr class="auto-tooltip" title="Standard Error">SE</abbr></i>
          (∼95% CI)
        </li>
      </ul>
    </li>
  </ul>

<?php if ($data) { ?>
  <p class="mb-3 text-right">
    Last Updated:
    <?= Yii::$app->formatter->asHtmlDatetime($data[0]->updated_at) ?>
    (<?= Yii::$app->formatter->asHtmlRelative($data[0]->updated_at) ?>)
  </p>
<?php } ?>

  <nav class="mb-1"><?= Nav::widget([
    'options' => ['class' => 'nav-tabs'],
    'encodeLabels' => false,
    'items' => array_map(
      function (string $key, array $data) use ($versionGroup, $month, $rule): array {
        return [
          'label' => implode(' ', [
            GameModeIcon::spl2($key),
            Html::encode(Yii::t('app-rule2', $data['name'])),
          ]),
          'url' => ['entire/weapons2-tier',
            'version' => $versionGroup->tag,
            'month' => $month,
            'rule' => $key,
          ],
          'active' => $key === $rule->key,
          'options' => [
            'class' => array_filter([
              $data['enabled'] ? null : 'disabled',
            ]),
          ],
        ];
      },
      array_keys($rules),
      array_values($rules),
    ),
  ]) ?></nav>

  <div class="table-responsive"><?= GridView::widget([
    'dataProvider' => Yii::createObject([
      'class' => ArrayDataProvider::class,
      'allModels' => $data,
      'sort' => false,
      'pagination' => false,
    ]),
    'tableOptions' => ['class' => 'table'],
    'layout' => '{items}',
    'columns' => [
      [
        // smile icon {{{
        'label' => '',
        'contentOptions' => ['class' => 'text-center align-middle'],
        'headerOptions' => ['style' => ['width' => 'calc(3em + 16px)']],
        'format' => 'raw',
        'value' => function (StatWeapon2Tier $model): string {
          $rate = $model->getWinRates();
          if ($rate && $rate[0] !== null) {
            if ($rate[0] > 0.5) {
              return (string)FA::far('smile')->size('2x')->fw();
            } elseif ($rate[2] < 0.5) {
              return (string)FA::far('frown')->size('2x')->fw();
            }
          }
          return '';
        },
        // }}}
      ],
      [
        // Weapon {{{
        'label' => Html::tag('span', Html::encode(Yii::t('app', 'Weapon')), ['class' => 'sr-only']),
        'encodeLabel' => false,
        'contentOptions' => ['class' => 'text-center align-middle'],
        'headerOptions' => ['style' => ['width' => 'calc(40px + 16px)']],
        'format' => 'raw',
        'value' => function (StatWeapon2Tier $model): string {
          $weaponIcons = Spl2WeaponAsset::register($this);
          return vsprintf('<div>%s</div><div>%s%s</div>', [
            Html::img($weaponIcons->getIconUrl($model->weapon->key), [
              'title' => Yii::t('app-weapon2', $model->weapon->name),
              'class' => 'auto-tooltip',
              'style' => [
                'width' => '40px',
                'height' => '40px',
              ],
            ]),
            Html::img($weaponIcons->getIconUrl('sub/' . $model->weapon->subweapon->key), [
              'title' => Yii::t('app-subweapon2', $model->weapon->subweapon->name),
              'class' => 'auto-tooltip',
              'style' => [
                'width' => '18px',
                'height' => '18px',
              ],
            ]),
            Html::img($weaponIcons->getIconUrl('sp/' . $model->weapon->special->key), [
              'title' => Yii::t('app-special2', $model->weapon->special->name),
              'class' => 'auto-tooltip',
              'style' => [
                'width' => '18px',
                'height' => '18px',
                'margin-left' => '4px',
              ],
            ]),
          ]);
        },
        // }}}
      ],
      [
        'label' => Yii::t('app', 'Win %'), // {{{
        'contentOptions' => ['class' => 'align-middle'],
        'headerOptions' => ['style' => ['min-width' => '300px']],
        'format' => 'raw',
        'value' => function (StatWeapon2Tier $model): ?string {
          if (!$rate = $model->getWinRates()) {
            return null;
          }

          if ($rate[0] === null) {
            // when cannot calc error {{{
            return implode('', [
              Html::tag(
                'div',
                implode('', [
                  Html::tag(
                    'div',
                    '',
                    [
                      'class' => 'progress-bar progress-bar-primary',
                      'style' => [
                        'width' => sprintf('%f%%', $rate[1] * 100),
                      ],
                    ]
                  ),
                ]),
                ['class' => 'progress']
              ),
              vsprintf('%s±??%s??%%', [
                Yii::$app->formatter->asDecimal($rate[1] * 100, 2),
                Yii::$app->formatter->decimalSeparator ?: '.',
              ]),
            ]);
            // }}}
          }

          return implode('', [
            Html::tag(
              'div',
              implode('', [
                Html::tag(
                  'div',
                  '',
                  [
                    'class' => 'progress-bar progress-bar-primary text-left-important',
                    'style' => [
                      'width' => sprintf('%f%%', $rate[0] * 100),
                    ],
                  ]
                ),
                Html::tag(
                  'div',
                  '',
                  [
                    'class' => 'progress-bar progress-bar-primary',
                    'style' => [
                      'width' => sprintf('%f%%', ($rate[1] - $rate[0]) * 100),
                      'opacity' => '0.65',
                    ],
                  ]
                ),
                Html::tag(
                  'div',
                  '',
                  [
                    'class' => 'progress-bar progress-bar-primary',
                    'style' => [
                      'width' => sprintf('%f%%', ($rate[2] - $rate[1]) * 100),
                      'opacity' => '0.3',
                    ],
                  ]
                ),
              ]),
              ['class' => 'progress']
            ),
            vsprintf('%s±%s%%', [
              Yii::$app->formatter->asDecimal($rate[1] * 100, 2),
              Yii::$app->formatter->asDecimal(($rate[2] - $rate[0]) * 100 / 2, 2),
            ]),
          ]);
        },
        // }}}
      ],
      [
        'label' => Yii::t('app', 'Kills'), // {{{
        'contentOptions' => ['class' => 'align-middle'],
        'headerOptions' => ['style' => ['width' => 'calc(7em + 16px)']],
        'format' => 'raw',
        'value' => function (StatWeapon2Tier $model) use ($kdCell): ?string {
          return $kdCell($model, 'kill');
        },
        // }}}
      ],
      [
        'label' => Yii::t('app', 'Deaths'), // {{{
        'contentOptions' => ['class' => 'align-middle'],
        'headerOptions' => ['style' => ['width' => 'calc(7em + 16px)']],
        'format' => 'raw',
        'value' => function (StatWeapon2Tier $model) use ($kdCell): ?string {
          return $kdCell($model, 'death');
        },
        // }}}
      ],
      [
        'label' => Yii::t('app', 'KR'), // {{{
        'contentOptions' => ['class' => 'text-right align-middle'],
        'headerOptions' => [
          'class' => 'text-right',
          'style' => ['width' => 'calc(4em + 16px)'],
        ],
        'format' => ['decimal', 3],
        'value' => function (StatWeapon2Tier $model): ?float {
          return $model->avg_death > 0 ? ($model->avg_kill / $model->avg_death) : null;
        },
        // }}}
      ],
      [
        'label' => 'n', // {{{
        'contentOptions' => ['class' => 'text-right align-middle'],
        'headerOptions' => [
          'class' => 'text-right',
          'style' => ['width' => 'calc(4em + 16px)'],
        ],
        'format' => 'integer',
        'attribute' => 'players_count',
        // }}}
      ],
    ],
  ]) ?></div>
</div>

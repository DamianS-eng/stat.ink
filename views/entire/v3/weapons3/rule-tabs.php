<?php

declare(strict_types=1);

use app\components\widgets\Icon;
use app\models\Rule3;
use yii\helpers\Html;
use yii\web\View;

/**
 * @var Rule3 $rule
 * @var View $this
 * @var array<int, Rule3> $rules
 * @var callable(Rule3): string $ruleUrl
 */

?>
<nav class="mb-1">
  <?= Html::tag(
    'ul',
    implode(
      '',
      array_map(
        fn (Rule3 $item): string => Html::tag(
          'li',
          Html::tag(
            'a',
            trim(
              implode(' ', [
                match ($item->key) {
                  'area' => Icon::s3RuleArea(),
                  'asari' => Icon::s3RuleAsari(),
                  'hoko' => Icon::s3RuleHoko(),
                  'nawabari' => Icon::s3RuleNawabari(),
                  'yagura' => Icon::s3RuleYagura(),
                  default=> '',
                },
                Html::tag(
                  'span',
                  Html::encode(Yii::t('app-rule3', $item->name)),
                  ['class' => 'd-none d-sm-inline'],
                ),
              ]),
            ),
            $item->key !== $rule->key
              ? ['href' => $ruleUrl($item)]
              : [],
          ),
          [
            'role' => 'presentation',
            'class' => $item->key === $rule->key ? 'active': null,
          ],
        ),
        $rules,
      ),
    ),
    ['class' => 'nav nav-pills'],
  ) . "\n" ?>
</nav>

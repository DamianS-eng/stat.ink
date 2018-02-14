<?php
/**
 * @copyright Copyright (C) 2015-2018 AIZAWA Hina
 * @license https://github.com/fetus-hina/stat.ink/blob/master/LICENSE MIT
 * @author AIZAWA Hina <hina@bouhime.com>
 */

namespace app\components\helpers;

use Yii;
use yii\base\Component;

class WeaponShortener extends Component
{
    public $dictionary;

    public static function makeShorter(string $name) : string
    {
        $instance = Yii::createObject(['class' => static::class]);
        return $instance->get($name);
    }

    public function init()
    {
        parent::init();
        if (!$this->dictionary || !is_array($this->dictionary)) {
            $this->dictionary = $this->setupDictionary();
        }
    }

    public function get(string $localizedName) : string
    {
        return $this->dictionary[$localizedName] ?? $localizedName;
    }

    protected function setupDictionary() : array
    {
        //FIXME
        switch (strtolower(substr(\Yii::$app->language, 0, 2))) {
            case 'ja':
                return $this->setupDictionaryJa();

            default:
                return [];
        }
    }

    protected function setupDictionaryJa() : array
    {
        // {{{
        return [
            '.52ガロン' => '52',
            '.52ガロンデコ' => '52デコ',
            '.96ガロン' => '96',
            '.96ガロンデコ' => '96デコ',
            '14式竹筒銃・丙' => '竹丙',
            '14式竹筒銃・乙' => '竹乙',
            '14式竹筒銃・甲' => '竹甲',
            '3Kスコープ' => 'リッスコ',
            '3Kスコープカスタム' => 'リッカスコ',
            'H3リールガン' => 'H3',
            'H3リールガンD' => 'H3D',
            'H3リールガンチェリー' => 'チェリー',
            'L3リールガン' => 'L3',
            'L3リールガンD' => 'L3D',
            'N-ZAP83' => 'ファミZAP',
            'N-ZAP85' => '黒ZAP',
            'N-ZAP89' => '赤ZAP',
            'Rブラスターエリート' => 'ラピエリ',
            'Rブラスターエリートデコ' => 'エリデコ',
            'もみじシューター' => 'もみじ',
            'わかばシューター' => 'わかば',
            'オクタシューター レプリカ' => 'オクタ',
            'カーボンローラー' => 'カローラ',
            'カーボンローラーデコ' => 'カロデコ',
            'シャープマーカー' => 'シャプマ',
            'シャープマーカーネオ' => 'シャプネ',
            'ジェットスイーパー' => 'ジェット',
            'ジェットスイーパーカスタム' => 'ジェッカス',
            'スクイックリンα' => 'α',
            'スクイックリンβ' => 'β',
            'スクイックリンγ' => 'γ',
            'スクリュースロッシャー' => 'スクスロ',
            'スクリュースロッシャーネオ' => 'スネオ',
            'スプラシューター' => 'スプシュ',
            'スプラシューターコラボ' => 'スシコラ',
            'スプラシューターワサビ' => 'スシワサ',
            'スプラスコープ' => 'スプスコ',
            'スプラスコープベントー' => 'ベンスコ',
            'スプラスコープワカメ' => 'ワカスコ',
            'スプラスピナー' => 'スプスピ',
            'スプラスピナーコラボ' => 'スピコラ',
            'スプラスピナーリペア' => 'リペア',
            'スプラチャージャー' => 'スプチャ',
            'スプラチャージャーベントー' => 'ベントー',
            'スプラチャージャーワカメ' => 'ワカメ',
            'スプラローラー' => 'スプロラ',
            'スプラローラーコラボ' => 'ロラコラ',
            'スプラローラーコロコロ' => 'コロコロ',
            'ダイナモローラー' => '銀ナモ',
            'ダイナモローラーテスラ' => '金ナモ',
            'ダイナモローラーバーンド' => '焼ナモ',
            'デュアルスイーパー' => 'デュアル',
            'デュアルスイーパーカスタム' => 'デュアカス',
            'ノヴァブラスター' => 'ノヴァ',
            'ノヴァブラスターネオ' => 'ノヴァネオ',
            'ハイドラント' => 'ハイドラ',
            'ハイドラントカスタム' => 'ハイカス',
            'バケットスロッシャー' => 'バケスロ',
            'バケットスロッシャーソーダ' => 'ソーダ',
            'バケットスロッシャーデコ' => 'バケデコ',
            'バレルスピナー' => 'バレスピ',
            'バレルスピナーデコ' => 'バレデコ',
            'バレルスピナーリミックス' => 'バレミク',
            'パブロ' => 'パブロ',
            'パブロ・ヒュー' => 'パヒュー',
            'パーマネント・パブロ' => 'パパブロ',
            'ヒッセン' => 'ヒッセン',
            'ヒッセン・ヒュー' => 'ヒッヒュー',
            'ヒーローシューター レプリカ' => 'ヒロシ',
            'ヒーローチャージャー レプリカ' => 'ヒロチ',
            'ヒーローローラー レプリカ' => 'ヒロロ',
            'プライムシューター' => 'プライム',
            'プライムシューターコラボ' => 'プラコラ',
            'プライムシューターベリー' => 'ベリー',
            'プロモデラーMG' => '銀モデ',
            'プロモデラーPG' => '銅モデ',
            'プロモデラーRG' => '金モデ',
            'ホクサイ' => 'ホクサイ',
            'ホクサイ・ヒュー' => 'ホヒュー',
            'ホットブラスター' => 'ホッブラ',
            'ホットブラスターカスタム' => 'ホッカス',
            'ボールドマーカー' => 'ボールド',
            'ボールドマーカー7' => 'ボルシチ',
            'ボールドマーカーネオ' => 'ボルネオ',
            'ラピッドブラスター' => 'ラピブラ',
            'ラピッドブラスターデコ' => 'ラピデコ',
            'リッター3K' => 'リッター',
            'リッター3Kカスタム' => 'リッカス',
            'ロングブラスター' => 'ロンブラ',
            'ロングブラスターカスタム' => 'ロンカス',
            'ロングブラスターネクロ' => 'ネクロ',
        ];
        // }}}
    }
}

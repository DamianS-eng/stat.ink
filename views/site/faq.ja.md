## stat.inkはどのようなサービスですか

stat.inkはSplatoonシリーズの戦績を蓄積し、集計するウェブアプリケーション（ウェブサービス）です。

ユーザーは別の「データ収集アプリ」を利用して、stat.inkにデータを送信して利用します。

## stat.inkはイカリング2/3と関係がありますか

直接は関係ありません。

stat.inkは「データ収集アプリ」からデータを受け取り、表示します。
データ収集アプリがどのようにデータを収集するかは、stat.inkでは関知しません。

実質的には、Splatoon 2や3の戦績のほどんど全てはイカリング2/3のデータを変換して記録されていますが、それはユーザーがそのようなデータ収集アプリを利用しているからです。

（そもそも、stat.inkの出自は「IkaLogのデータ記録・可視化ツール」です。今も、イカリングの存在を前提にしていません）

## stat.inkは任天堂サポートから発表されている声明の影響を受けますか

上述の通り、stat.inkはイカリング2/3を「不正に」利用するアプリではありませんので、直接は影響を受けません。

ユーザーは「データ収集アプリ」を利用することで、イカリング2/3のデータをstat.inkに送信することができますが、データ収集アプリが声明の影響を受けるかどうかは、データ収集アプリ側の実装によります。

## stat.inkの統計情報は何を表していますか

わかりません。

キル・デスと勝率の関係などでは、例えば「4回死んでたら勝率が低い」「キルレシオが1を大きく下回ると勝率が低い」ようなことは数字として見えます。

しかし、これが「死ななければ勝てる」のか「死なない状況を作れれば勝てる」のか「死なない状況を作ってくれる味方に巡り合えれば勝てる」のかはわかりませんし分析もしていません。

言うまでもないですが、このページで「100%」となっているからといってそのK/Dにすれば勝てるというものでもありません。

## stat.inkの統計情報は偏っていますか

はい。

stat.inkでは、送信されてきたデータだけを基に集計情報を作成しています。
Splatoonシリーズのプレイヤーの大多数はこの送信されてきたデータには含まれませんから、当然偏ります。

具体的には、stat.inkのユーザーにはほとんど「超ライト層」は存在しませんし、「超ガチ勢」もほとんどいません。
そのため、超ライト層で多く使われているであろう「わかばシューター」は実数より少なく出るでしょうし、かなりの熟練を必要とするブキ、例えば「ジムワイパー」や「ボトルガイザー」の勝率は低めに出るでしょう。

なお、送信者によるバイアスを防ぐため、全体の統計のほとんどでは、stat.inkの投稿者のデータは除外され、残りの7人分のデータを集計します。
外部のコミュニティでは、しばしば「stat.inkの統計はstat.inkのユーザーの統計」と言及され、故に偏っているとされてることがありますが、それは誤りです。

ただし、特にSplatoon 3ではマッチングシステムの仕様上、stat.inkのユーザーが対戦相手に特定のブキを「呼び込む」ような動作を行うため、若干のバイアスかかっています。

## stat.inkの統計情報は信頼できますか

あなたの感覚より少しは。

あなたがどんなに頑張ってゲームをプレイしたとしても、あなたが対戦する相手はあなたの実力やブキの影響を受けて決まった、きわめて少数の集団です。

自分が対戦する相手にしか興味がないなら別ですが、もう少し広くデータを見るなら、stat.inkの統計情報はあなたの感覚よりは信頼できるでしょう。

## 「データ収集アプリ」にはどんなものがありますか

  - {icon:splatoon3} Splatoon 3
    - [s3s](https://github.com/frozenpandaman/s3s) - Windows, macOS, Linux
    - [s3si.ts](https://github.com/spacemeowx2/s3si.ts) - Windows, macOS, Linux

  - {icon:splatoon2} Splatoon 2
    - [splatnet2statink](https://github.com/frozenpandaman/splatnet2statink#splatnet2statink) - Windows, macOS, Linux
    - SquidTracks - Windows, macOS, Linux
    - IkaRec 2 - Android

  - {icon:splatoon1} Splatoon
    - [IkaLog](https://github.com/hasegaw/IkaLog/wiki/ja_WinIkaLog) - Windows, macOS, Linux
    - イカレコ / IkaRec - Android

## stat.inkのデータを基に自分で集計したい

[統計情報ダウンロード](https://stat.ink/downloads)からデータをダウンロードして解析できます。

ご自分のデータは、ログインして「プロフィールと設定」からダウンロードできます。

## 対応アプリを作りたい

APIがありますのでご自由にどうぞ。
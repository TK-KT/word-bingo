<?php

// ビンゴカードの判定クラス
class BingoCard
{
    // ビンゴカードの一辺の長さ
    private $s;
    // ビンゴカード(単語と座標の対応表)
    private $card;
    // 行に該当する単語に印が付いたとき、その座標値を行ごとに足しこむ配列
    private $line;
    // 列に該当する単語に印が付いたとき、その座標値を列ごとに足しこむ配列
    private $column;
    // 左下から右上斜め行に該当する単語に印が付いたとき、その座標値を足しこむ変数
    private $upperRight;
    // 左上から右下斜め行に該当する単語に印が付いたとき、その座標値を足しこむ変数
    private $lowerRight;

    // コンストラクタ
    public function __construct($s, $card)
    {
        $this->s = $s;
        $this->card = $card;
        $this->line = array_fill(0, $s, 0);
        $this->column = array_fill(0, $s, 0);
        $this->upperRight = 0;
        $this->lowerRight = 0;
    }

    // 与えられた単語がビンゴカード上に存在するかチェックする関数
    public function checkExistOnCard($word)
    {
        // 入力された値がビンゴカード上に存在している場合、座標値を対応する変数に格納する
        if (isset($this->card[$word])) {
            $this->countUpGridArray($this->card[$word]['x'], $this->card[$word]['y']);
        }
    }

    // 座標値を受け取り、対応する配列をカウントアップ関数
    public function countUpGridArray($x, $y)
    {
        // 対応する行配列に足しこむ
        $this->line[$x]++;
        // 対応する列配列に足しこむ
        $this->column[$y]++;
        // 存在した単語のx座標値とy座標値が等しい場合、右下斜めの変数に足しこむ
        if ($x == $y) {
            $this->lowerRight++;
        }
        // 存在した単語のx座標値とy座標値の和が、カードの一辺の長さ＋１と等しい場合、右上斜めの変数に足しこむ
        if (($x+$y) == ($this->s + 1)) {
            $this->upperRight++;
        }
    }

    // ビンゴが成立しているかどうか判定する関数
    public function judgement()
    {
        // 左下から右上斜め行に該当するカウントアップした和が、S(ビンゴカードの一辺の長さ)と等しい場合、ビンゴ成立
        if ($this->upperRight == $this->s) {
            print "yes";
            return;
        }

        // 左上から右下斜め行に該当するカウントアップした和が、S(ビンゴカードの一辺の長さ)と等しい場合、ビンゴ成立
        if ($this->lowerRight == $this->s) {
            print "yes";
            return;
        }

        // 行と列ごとに判定するループ
        for ($i=1; $i<=$this->s; $i++) {
            // 該当行に対応するカウントアップした和が、S(ビンゴカードの一辺の長さ)と等しい場合、ビンゴ成立
            if ($this->line[$i] == $this->s) {
                print "yes";
                return;
            }
            // 該当列に対応するカウントアップした和が、S(ビンゴカードの一辺の長さ)と等しい場合、ビンゴ成立
            if ($this->column[$i] == $this->s) {
                print "yes";
                return;
            }
        }

        // 全ての判定で成立しなかった場合
        print "no";
        return;
    }
}

// ビンゴカードの一辺の長さ(S)を受け取る
$s = trim(fgets(STDIN));

// 元となるカードの作成(単語と座標の対応表)
for ($y=0; $y<$s; $y++) {
    $wordArray = explode(' ', trim(fgets(STDIN)));
    foreach ($wordArray as $x => $word) {
        $card[$word] = ['x' => $x, 'y' => $y];
    }
}

// ビンゴカード判定クラスの作成
$bingoCard = new BingoCard($s, $card);

// 選ばれる単語の数 N
$n = trim(fgets(STDIN));

// N個分の入力を受けとる
for ($i=0; $i<$n; $i++) {
    // 標準入力で受け取った単語がビンゴカード上に存在するかどうか判定する
    $bingoCard->checkExistOnCard(trim(fgets(STDIN)));
}

// ビンゴが成立しているか判定する
$bingoCard->judgement();

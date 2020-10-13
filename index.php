<?php

// ビンゴカードの判定クラス
class BingoCard{
    private $s,             // ビンゴカードの一辺の長さ
            $line,          // 行に該当する単語に印が付いたとき、その座標値を行ごとに足しこむ配列
            $column,        // 列に該当する単語に印が付いたとき、その座標値を列ごとに足しこむ配列
            $upperRight,    // 左下から右上斜め行に該当する単語に印が付いたとき、その座標値を足しこむ変数
            $lowerRight;    // 左上から右下斜め行に該当する単語に印が付いたとき、その座標値を足しこむ変数

    // コンストラクタ
    public function __construct($s){
        $this->s = $s;
        $this->line = array_fill(1, $s+1, 0);
        $this->column = array_fill(1, $s+1, 0);
        $this->upperRight = 0;
        $this->lowerRight = 0;
    }

    // ビンゴカードの一辺の長さを取得する関数
    public function getS(){
        return $this->s;
    }

    // 座標値を受け取り、対応する配列に足しこむ関数
    public function sumUpGridArray($x, $y){
        // 存在した単語のx座標値を、対応する配列に足しこむ
        $this->line[$x] += $x;
        // 存在した単語のy座標値を、対応する配列に足しこむ
        $this->column[$y] += $y;
        // 存在した単語のx座標値とy座標値が等しい場合、右下斜めの変数に足しこむ
        if ($x == $y) {
            $this->lowerRight += $x;
        }
        // 存在した単語のx座標値とy座標値の和が、カードの一辺の長さ＋１と等しい場合、右上斜めの変数に足しこむ
        if (($x+$y) == ($this->s + 1)) {
            $this->upperRight += $x;
        }
    }

    // ビンゴが成立しているかどうか判定する関数
    public function judgement(){
        // 左下から右上斜め行に該当する座標値の和が、1からS(ビンゴカードの一辺の長さ)までの和と等しい場合、ビンゴ成立
        if ($this->upperRight == ($this->s * ($this->s + 1) / 2)) {
            print "yes";
            return;
        }

        // 左上から右下斜め行に該当する座標値の和が、1からS(ビンゴカードの一辺の長さ)までの和と等しい場合、ビンゴ成立
         if ($this->lowerRight == ($this->s * ($this->s + 1) / 2)) {
            print "yes";
            return;
        }

        // 行と列ごとに判定するループ
        for ($i=1; $i<=$this->s; $i++) {
            // 該当行に対応する座標値の和が、該当行の座標値とS(ビンゴカードの一辺の長さ)の積と等しい場合、ビンゴ成立
            if ($this->line[$i] == ($i * $this->s)) {
                print "yes";
                return;
            }
            // 該当列に対応する座標値の和が、該当列の座標値とS(ビンゴカードの一辺の長さ)の積と等しい場合、ビンゴ成立
            if ($this->column[$i] == ($i * $this->s)) {
                print "yes";
                return;
            }
        }

        // 全ての判定で成立しなかった場合
        print "no";
        return;
    }
}

// ビンゴカードの一辺の長さ(S)を受け取り、判定クラスの作成
$bingoCard = new BingoCard(trim(fgets(STDIN)));

// 元となるカードの作成(単語と座標の対応表)
for ($y=0; $y<$bingoCard->getS(); $y++) {
    $inputArray = explode(' ', trim(fgets(STDIN)));
    foreach($inputArray as $x => $value) {
        $card[$value] = ['x' => $x+1, 'y' => $y+1];
    }
}

// 選ばれる単語の数 N
$n = trim(fgets(STDIN));

// N個分の入力を受けとる
for ($i=0; $i<$n; $i++) {
    $inputValue = trim(fgets(STDIN));
    // 入力された値がビンゴカード上に存在している場合、座標値を対応する変数に格納する
    if (isset($card[$inputValue])) {
        $bingoCard->sumUpGridArray($card[$inputValue]['x'], $card[$inputValue]['y']);
    }
}

// ビンゴが成立しているか判定する
$bingoCard->judgement();

?>

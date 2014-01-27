<?php
require_once 'abstract.php';

/**
 * ユーザーテーブルへのデータ挿入
 */
class Main extends Abst {

	/**
	 * 対象テーブル名
	 * @var string
	 */
	public $table = 'user';

	/**
	 * ループ回数指定
	 * @var intenget
	 */
	public $roopCount = 1000;

	/**
	 * 対象カラム一覧
	 * @var array
	 */
	public $column = array(
		'name',
		'add',
		'tel',
		'mail',
		'pass'
	);


	/**
	 * @param strring $key カラム
	 * @param intenger $num 番号
	 * @return mixed $val カラムに設定する値
	 */
	function getNextVal($key, $num) {
		$val = '';
		switch ($key){
			case 'name':
				$val = 'テストユーザー_'.$num;
				break;
			case 'add':
				$val = '東京都港区六本木';
				$val .= rand(1, 7);
				$val .= '-';
				$val .= rand(1, 30);
				$val .= '-';
				$val .= rand(1, 45);
				break;
			case 'tel':
				$tel = str_pad($num, 8, "0", STR_PAD_LEFT);
				$val = '03-'. substr($tel, 0, 4) .'-' . substr($tel, 4);
				break;
			case 'mail':
				$val = 'test.data.'.$num.'@dummy.com';
				break;
			case 'pass':
				$val = $this->_getRandomStr();
				break;
		}
		return $val;
	}
}

new Main();

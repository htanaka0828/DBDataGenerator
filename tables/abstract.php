<?php
require_once '../util.php';
require_once '../db.php';

/**
 * 大量データ生成時親クラス
 * こいつを継承させて定義追加をする
 */
class Abst extends Util {

	/**
	 * DBハンドラ
	 */
	public $DB = null;

	/**
	 * 対象テーブル名
	 * @var string
	 */
	public $table = '';

	/**
	 * ループ回数指定
	 * @var intenger
	 */
	public $roopCount = 0;

	/**
	 * ループカウント用
	 * @var intenger
	 */
	public $nowCount = 0;

	/**
	 * 対象カラム一覧
	 * @var array
	 */
	public $column = array();

	/**
	 * コンストラクタ
	 * 対象テーブルの現在のカウントを取得
	 */
	function __construct() {
		$this->DB = new DB();
		$this->init();
		$this->nowCount = $this->DB->getCount($this->table);

		for($i = 0; $i < $this->roopCount; $i++) {
			$this->main($this->nowCount);
			$this->nowCount++;
		}
	}

	/**
	 * 初期化処理
	 * 必要な場合は子クラスに追加してやる
	 */
	function init(){}

	/**
	 * カラムの値取得用
	 * @param str $key カラム
	 * @prama int $num 番号
	 * @return val
	 */
	function getNextVal($col, $rowCount) {
		return null;
	}

	/**
	 * 保存ループ処理
	 */
	function main($rowCount) {
		$val = array();
		foreach($this->column as $col) {
			$val[] = $this->getNextVal($col, $rowCount);
		}
		$this->DB->save($this->table, $this->column, $val);
	}
}

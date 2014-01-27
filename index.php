<?php
require_once 'util.php';
require_once 'db.php';

class Main extends Util {

	public $DB = null;

	/**
	 * コンストラクタ
	 * 誤作動防止加工済
	 */
	function __construct() {
		$this->DB = new DB();
		$this->_log('********************************************');
		$this->_log('* DBデータ挿入をコマンドラインから入れたい *');
		$this->_log('* そんな奇特な人のために作られた           *');
		$this->_log('* 汎用ジェネレータです。                   *');
		if(parent::initCheck === false) {
		$this->_log('* DB.php の中の設定値を設定して            *');
		$this->_log('* util.phpの中の「initCheck」をtrueにして  *');
		$this->_log('* 利用を始めて下さい。                     *');
		}
		$this->_log('********************************************');
		if(parent::initCheck) $this->main();
	}

	/**
	 * メインの処理
	 */
	function main() {
		$this->_log('データを作成するテーブルを数字で選択して下さい');
		$tableNames = $this->DB->getTableNames();
		foreach($tableNames as $key => $val) {
			$this->_log($val, $key);
		}
		$this->_log('コマンド？');
		$param = $this->_inputWait();
		$table = $this->DB->getTableNames($param);
		if($table === false) {
			$this->_log('存在しないテーブルだよ？','ERROR');
			$this->main();
		} else {
			$this->makeValue($table);
		}
	}

	/**
	 * データ入力
	 * @param string $tableName
	 */
	function makeValue($tableName) {
		$this->_log('「'.$tableName.'」のデータを作るよ！');
		$columnNames = $this->DB->getColumnNames($tableName);
		$columnVal = array();
		foreach($columnNames as $key => $name) {
			$this->_log('「'.$name.'」の値');
			$columnVal[$key] = $this->_inputWait();
		}

		$this->_log('********************************************');
		$this->_log('入力された値');
		foreach($columnVal as $key => $val) {
			$this->_log($val, $columnNames[$key]);
		}
		$this->_log('********************************************');
		$this->_log('これで作る？y or n (y)');
		$result = $this->_inputWait();
		if($result === 'y' || $result === '') {
			$this->_log('データ作成なう');
			$this->DB->save($tableName, $columnNames, $columnVal);
			$this->main();
		} else {
			$this->_log('入力し直す？y or n (y)');
			if($result === 'y' || $result === '') {
				$this->makeValue($tableName);
			} else {
				$this->main();
			}
		}
	}
}

new Main();

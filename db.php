<?php

/**
 * データベース弄くりクラス
 */
class DB extends Util {


	// @todo 最初にこいつらを設定してあげてね！！
	const DB_HOST = 'localhost';
	const DB_USER = 'admin';
	const DB_PASS = 'admin';
	const DB_NAME = 'test';


	/**
	 * ドライバ保持用
	 */
	public $pdo = null;

	/**
	 * データ挿入時にデフォルト指定するものリスト
	 * @var array
	 */
	private $defList = array(
		'id',
		'created_at',
		'updated_at',
		'deleted_at'
	);

	/**
	 * コンストラクタ
	 */
	function __construct() {
		$this->_setPDO();
	}

	/**
	 * デフォルト指定リストに指定されているかどうかの判定
	 * @param string $key
	 * @return bool
	 */
	function isDefList($key) {
		return in_array($key, $this->defList);
	}

	/**
	 * PDOドライバセット
	 */
	private function _setPDO() {
		try {
			// 接続(DB選択・文字化け防止含む)
			$this->pdo = new PDO(
				'mysql:host='.self::DB_HOST.';dbname='.self::DB_NAME,
				self::DB_USER,
				self::DB_PASS,
				array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
			);
		} catch(PDOException $e){
			$this->_log($e->getMessage(),'ERROR');
			exit;
		}
	}

	/**
	 * @param integer $num テーブルの選択
	 * @return mixed テーブル名一覧 引数指定がある場合は特定のテーブル名
	 */
	public function getTableNames($num = null) {
		$query = 'SHOW TABLES FROM '. self::DB_NAME;
		$getData = $this->pdo->prepare($query);
		if(!$getData->execute()){
			$this->_log('ダメでしたｗ', 'ERROR');
			exit;
		}
		$datas = $getData->fetchAll(PDO::FETCH_ASSOC);
		$tableNames = array();
		$colmun = 'Tables_in_'.self::DB_NAME;
		foreach($datas as $data) {
			$tableNames[] = $data[$colmun];
		}
		if($num === null) {
			return $tableNames;
		}
		if(isset($tableNames[$num])) {
			return $tableNames[$num];
		} else {
			return false;
		}
	}

	/**
	 * カラム名配列取得
	 * @param string $tableName
	 */
	public function getColumnNames($tableName) {
		$pdoStatement = $this->pdo->query("SELECT * FROM $tableName LIMIT 0");
		for ($i = 0; $i < $pdoStatement->columnCount(); $i++) {
			$meta = $pdoStatement->getColumnMeta($i);
			if(!$this->isDefList($meta['name'])){
				$columns[] = $meta['name'];
			}
		}
		return $columns;
	}

	/**
	 * 対象テーブルのレコード数を取得
	 * @param string $tableName
	 * @return intenger カウント数
	 */
	public function getCount($tableName){
		$countQuery = $this->pdo->query('SELECT count(id) as c FROM '.$tableName);
		return $countQuery->fetchColumn();
	}

	/**
	 * データ保存実行
	 * @param string $table
	 * @param array $column
	 * @param array $value
	 */
	public function save($table, $column, $value) {
		$column[] = 'created_at';
		$column[] = 'updated_at';
		$now = $this->_getNow();
		$value[] = $now;
		$value[] = $now;

		$pre = rtrim(str_repeat('?,', count($value)), ',');
		$query = 'INSERT INTO '. $table .'(`'.implode('`,`', $column).'`) VALUES ('.$pre.')';
		$dh = $this->pdo->prepare($query);
		$this->pdo->beginTransaction();
		if(!$dh->execute($value)){
			$this->_log('保存失敗','ERROR');
			$this->_log($query,'ERROR');
			$this->_log($value,'ERROR');
			$err = $this->pdo->errorInfo();
			$this->_log($err,'ERROR');
			$this->pdo->rollBack();
		} else {
			$this->pdo->commit();
			$this->_log('保存成功','INFO');
		}
	}
}
<?php

/**
 * 汎用メソッド群
 */
class Util {

	// @todo 最初にこいつをtrueにしてあげてね
	const initCheck = false;

	// 暗号化時のsolt 任意で書き換えてあげて下さい
	const secretKey = 'abcdefghijklmnopqrstuvwxyz';

	/**
	 * 画面にメッセージを表示する
	 * @param mixed $msg
	 * @param string $params 表示の属性
	 */
	function _log($msg,$params = ""){
		if($params !== ""){
			echo $params.":";
		}
		if(is_array($msg) || is_object($msg)){
			var_dump($msg);
			// print_r($msg);
			echo PHP_EOL;
		}else{
			echo $msg.PHP_EOL;
		}
	}

	/**
	 * 画面入力を待って、入力された文字を返す
	 * @return string
	 */
	function _inputWait() {
		return trim(fgets(STDIN));
	}

	/**
	 * ランダム文字列取得
	 * @return string
	 */
	function _getRandomStr() {
		$strinit = "abcdefghkmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ012345679";
		$strarray = str_split($strinit);
		for ($i = 0, $str = ''; $i < 16; $i++) {
			$str .= $strarray[array_rand($strarray, 1)];
		}
		return $str;
	}

	/**
	 * 暗号化文字列取得
	 * @param string $target 加工対象文字列
	 * @param strring $key 暗号化キー
	 * @return strring
	 */
	function _getSecretHash($target, $key = '') {
		$str = crypt($target, self::secretKey);
		if($key !== '') {
			$str = crypt($str, $key);
		}
		return $str;
	}

	/**
	 * クエリで使う現在時刻を取得する
	 * @return string
	 */
	function _getNow() {
		return date('Y-m-d H:i:s');
	}
}

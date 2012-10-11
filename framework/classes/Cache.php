<?php

final class Cache {
	private static $_instance = null;
	public static function getInstance() {
		if (!self::$_instance) self::$_instance = new self();
		return self::$_instance;
	}

	private $_disabled = true;
	private $_reqDeps = array();
	private $_cacheFile = null;
	private $_content = false;
	private $_cacheId = "";

	private function __construct() {
		$this->_disabled = defined("_ADMIN_MODE") || !Configuration_CMS::$_cacheModules;
	}

	public function addDependency($key) {
		if (!in_array($key, $this->_reqDeps)) {
			$this->_reqDeps []= $key;
		}
	}

	public function start($moduleName = false) {
		$this->_content = false;
		if (count($this->_reqDeps) > 0 && !$this->_disabled) {
			$this->_cacheId = "";
			foreach ($this->_reqDeps as $reqDep) {
				$this->_cacheId .= $reqDep.Request::get($reqDep, "NONE");
			}
			$cacheHash = md5($this->_cacheId);

			/* Determine cache directory and check if it exists */
			if ($moduleName !== false) {
				$cacheDir = PATH_CACHE.DS."modules".DS.strtolower($moduleName);
			} else {
				$cacheDir = PATH_CACHE.DS."heap";
			}
			if (!is_dir($cacheDir)) {
				mkdir($cacheDir, 0777, true);
			}

			$cacheFilePath = $cacheDir.DS.$cacheHash.".cache";
			if (file_exists($cacheFilePath)) {
				$this->_content = file_get_contents($cacheFilePath);
				return false;
			} else {
				$this->_cacheFile = fopen($cacheFilePath, 'w');
				ob_start();
				return true;
			}
		} else {
			ob_start();
			return true;
		}
	}

	public function spew($render = true) {
		if ($this->_content === false) {
			$this->_content = ob_get_contents();
			ob_end_clean();
			if ($this->_cacheFile) {
				fwrite($this->_cacheFile, $this->_content);
				fclose($this->_cacheFile);
			}
		}

		if ($render) {
			echo $this->_content;
		}
		return $this->_content;
	}

	public static function clear($moduleName = false) {
		if ($moduleName !== false) {
			$cacheDir = PATH_CACHE.DS."modules".DS.strtolower($moduleName);
		} else {
			$cacheDir = PATH_CACHE.DS."heap";
		}
		array_map('unlink', glob($cacheDir.DS."*.cache"));
	}

	public function getId() {
		return $this->_cacheId;
	}
}

?>

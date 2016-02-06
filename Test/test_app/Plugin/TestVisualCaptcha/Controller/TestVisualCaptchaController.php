<?php
/**
 * TestVisualCaptcha Controller
 *
 * @author AllCreator <info@allcreator.net>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('VisualCaptchaAppController', 'VisualCaptcha.Controller');
App::uses('VisualCaptchaController', 'VisualCaptcha.Controller');

/**
 * TestVisualCaptcha Controller
 *
 * @author AllCreator <info@allcreator.net>
 * @package NetCommons\VisualCaptcha\Test\test_app\Plugin\VisualCaptcha\Controller
 */
class TestVisualCaptchaController extends VisualCaptchaController {

/**
 * use component
 *
 * @var array
 */
	public $components = array(
		'Security',
		'VisualCaptcha.VisualCaptcha' => array(
			'operationType' => 'redirect',
			'targetAction' => 'index',
		),
	);

/**
 * uses
 *
 * @var array
 */
	public $uses = array(
		'VisualCaptcha.VisualCaptcha',
	);

/**
 * beforeFilter
 *
 * @return void
 */
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('index', 'none_test', 'embed_test', 'get_url_test', 'check', 'check_ok', 'generate_ng_test');

		if ($this->action == 'none_test') {
			$this->VisualCaptcha->operationType = 'none';
		}
		if ($this->action == 'embed_test') {
			$this->VisualCaptcha->operationType = 'embedding';
		}
	}

/**
 * index method
 *
 * @return void
 */
	public function index() {
	}

/**
 * none_test method
 *
 * @return void
 */
	public function none_test() {
	}

/**
 * embed_test method
 *
 * @return void
 */
	public function embed_test() {
	}

/**
 * get_url_test method
 *
 * @return void
 */
	public function get_url_test() {
		$url = $this->VisualCaptcha->getReturnUrl();
		$this->set('url', $url);
	}

/**
 * check method
 *
 * @return void
 */
	public function check() {
		$this->VisualCaptcha->imageField = 'testImage';
		$this->VisualCaptcha->audioField = 'testAudio';
		$this->VisualCaptcha->check();
		$this->set('resultCode', 'NG');
		$this->view = 'check';
	}

/**
 * check method
 *
 * @return void
 */
	public function check_ok() {
		$this->set('resultCode', 'NG');
		$imageFieldName = $this->VisualCaptcha->imageField;
		$ret = $this->VisualCaptcha->generate();
		$retCls = json_decode($ret);
		$orgName = $this->name;
		$this->name = 'VisualCaptcha';
		foreach ($retCls->values as $val) {
			$this->request->data[$imageFieldName] = $val;
			if ($this->VisualCaptcha->check()) {
				$this->set('resultCode', 'OK');
				break;
			}
		}
		$this->name = $orgName;
		$this->view = 'check';
	}

/**
 * generate method
 *
 * @return void
 */
	public function generate_ng_test() {
		$this->autoRender = false;
		$this->VisualCaptcha->assetPath = '/';
		$this->VisualCaptcha->generate();
	}
}

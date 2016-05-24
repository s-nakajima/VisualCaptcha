<?php
/**
 * VisualCaptchaController Test Case
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author AllCreator <info@allcreator.net>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');

/**
 * VisualCaptchaController Test Case
 *
 * @author AllCreator <info@allcreator.net>
 * @package NetCommons\VisualCaptcha\Test\Case\Controller
 * @SuppressWarnings(PHPMD.LongVariable)
 */
class VisualCaptchaMockTest extends NetCommonsControllerTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
	);

/**
 * Plugin name
 *
 * @var array
 */
	public $plugin = 'test_visual_captcha';

/**
 * Controller name
 *
 * @var string
 */
	protected $_controller = 'test_visual_captcha';

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		NetCommonsControllerTestCase::loadTestPlugin($this, 'VisualCaptcha', 'TestVisualCaptcha');
		parent::setUp();
	}

/**
 * アクションのGETテスト
 * index へアクセスしてリダイレクトされるパターン
 *
 * @return void
 */
	public function testIndexGet() {
		//テスト実施
		$url = array(
			'plugin' => $this->plugin,
			'controller' => $this->_controller,
			'action' => 'index',
		);
		$this->testAction($url, array('method' => 'get'));
		$result = $this->headers['Location'];
		$expected = Router::url(array(
			'plugin' => 'visual_captcha',
			'controller' => 'visual_captcha',
			'action' => 'view',
		), false);
		// 認証キー画面にリダイレクトされたことを確認
		$this->assertTextContains($expected, $result);
	}

/**
 * アクションのGETテスト
 * index へアクセスしてリダイレクトされないパターン
 *
 * @return void
 */
	public function testIndexNoRedirectGet() {
		$this->controller->Session->expects($this->any())
			->method('check')
			->will(
				$this->returnValueMap([
					['VisualCaptcha.judgement', 'OK'],
				]));
		//テスト実施
		$url = array(
			'plugin' => $this->plugin,
			'controller' => $this->_controller,
			'action' => 'index',
		);
		$result = $this->testAction($url, array('method' => 'get', 'return' => 'view'));
		// 認証キー画面にリダイレクトされたことを確認
		$this->assertTextContains('index_test_ctp', $result);
	}

/**
 * アクションのGETテスト
 * operationTypeがnoneで何も起こらないタイプのパターン
 *
 * @return void
 */
	public function testNoneGet() {
		//テスト実施
		$url = array(
			'plugin' => $this->plugin,
			'controller' => $this->_controller,
			'action' => 'none_test',
		);
		$result = $this->testAction($url, array('method' => 'get', 'return' => 'view'));
		// 画面遷移なし
		$this->assertTextContains('none_test_ctp', $result);
	}

/**
 * アクションのGETテスト
 * 埋め込みタイプのパターン
 *
 * @return void
 */
	public function testEmbedGet() {
		$this->controller->Session->expects($this->any())
			->method('read')
			->will(
				$this->returnValueMap([
					['visualcaptcha.frontendData.imageFieldName', 'imageFieldName'],
					['visualcaptcha.frontendData.audioFieldName', 'audioFieldName'],
				]));
		//テスト実施
		$url = array(
			'plugin' => $this->plugin,
			'controller' => $this->_controller,
			'action' => 'embed_test',
		);
		$result = $this->testAction($url, array('method' => 'get', 'return' => 'view'));
		// 画面遷移なし
		$this->assertTextContains('embed_test_ctp', $result);
	}

/**
 * getReturnUrlテスト
 *
 * @return void
 */
	public function testGetReturnUrl() {
		$this->controller->Session->expects($this->any())
			->method('read')
			->will(
				$this->returnValueMap([
					['VisualCaptcha.returnUrl', 'http://netcommons.org'],
				]));
		//テスト実施
		$url = array(
			'plugin' => $this->plugin,
			'controller' => $this->_controller,
			'action' => 'get_url_test',
		);
		$result = $this->testAction($url, array('method' => 'get', 'return' => 'view'));
		// 画面遷移なし
		$this->assertTextContains('netcommons', $result);
	}

/**
 * checkテスト
 *
 * @return void
 */
	public function testGetCheckOK() {
		//テスト実施
		$url = array(
			'plugin' => $this->plugin,
			'controller' => $this->_controller,
			'action' => 'check_ok',
		);
		$data['testImage'] = 'testImage';
		$result = $this->testAction($url, array('data' => $data, 'method' => 'post', 'return' => 'view'));
		$this->assertTextContains('OK', $result);
	}

/**
 * checkテスト
 *
 * @return void
 */
	public function testGetCheck1() {
		//テスト実施
		$url = array(
			'plugin' => $this->plugin,
			'controller' => $this->_controller,
			'action' => 'check',
		);
		$result = $this->testAction($url, array('method' => 'post', 'return' => 'view'));
		$this->assertTextContains('NG', $result);
	}

/**
 * checkテスト
 *
 * @return void
 */
	public function testGetCheck2() {
		//テスト実施
		$url = array(
			'plugin' => $this->plugin,
			'controller' => $this->_controller,
			'action' => 'check',
		);
		$data['testImage'] = 'testImage';
		$result = $this->testAction($url, array('data' => $data, 'method' => 'post', 'return' => 'view'));
		$this->assertTextContains('NG', $result);
	}

/**
 * checkテスト
 *
 * @return void
 */
	public function testGetCheck3() {
		//テスト実施
		$url = array(
			'plugin' => $this->plugin,
			'controller' => $this->_controller,
			'action' => 'check',
		);
		$data['testAudio'] = 'testAudio';
		$result = $this->testAction($url, array('data' => $data, 'method' => 'post', 'return' => 'view'));
		$this->assertTextContains('NG', $result);
	}

/**
 * generateテスト
 *
 * @return void
 */
	public function testGenerateNG() {
		//テスト実施
		$url = array(
			'plugin' => $this->plugin,
			'controller' => $this->_controller,
			'action' => 'generate_ng_test',
		);
		ob_start();
		$this->testAction($url, array('method' => 'post', 'return' => 'view'));
		$result = ob_get_clean();
		$this->assertEmpty($result);
	}

}

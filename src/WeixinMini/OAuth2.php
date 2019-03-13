<?php
namespace by\component\third_login\WeixinMini;

use by\component\third_login\ApiException;
use by\component\third_login\Base;

class OAuth2 extends Base
{
	/**
	 * api接口域名
	 */
	const API_DOMAIN = 'https://api.weixin.qq.com/';

	/**
	 * 开放平台域名
	 */
	const OPEN_DOMAIN = 'https://open.weixin.qq.com/';

	/**
	 * 语言，默认为zh_CN
	 * @var string
	 */
	public $lang = 'zh_CN';

	/**
	 * openid从哪个字段取，默认为openid
	 * @var int
	 */
	public $openidMode = OpenidMode::OPEN_ID;

	public function getAccessToken($storeState = '', $code = null, $state = null)
    {
        $this->result = $this->http->get($this->getUrl('cgi-bin/token', array(
            'appid'			=>	$this->appid,
            'secret'		=>	$this->appSecret,
            'grant_type'	=>	'client_credential',
        )))->json(true);
        if(isset($this->result['errcode']) && 0 != $this->result['errcode'])
        {
            throw new ApiException($this->result['errmsg'], $this->result['errcode']);
        }
        else
        {
            return [
                'access_token' => $this->result['access_token'],
                'expires_in'=> $this->result['expires_in'],
            ];
        }
    }

	/**
	 * 获取url地址
	 * @param string $name 跟在域名后的文本
	 * @param array $params GET参数
	 * @return string
	 */
	public function getUrl($name, $params = array())
	{
		if('http' === substr($name, 0, 4))
		{
			$domain = $name;
		}
		else
		{
			$domain = static::API_DOMAIN . $name;
		}
		return $domain . (empty($params) ? '' : ('?' . $this->http_build_query($params)));
	}

    /**
     * 小程序调用 wx.login 后的code
     * @param null $code
     * @return mixed
     * @throws ApiException
     */
    public function code2Session($code = null)
    {
        $this->result = $this->http->get($this->getUrl('sns/jscode2session', array(
            'appid'			=>	$this->appid,
            'secret'		=>	$this->appSecret,
            'js_code'			=>	$code,
            'grant_type'	=>	'authorization_code',
        )))->json(true);
        if(isset($this->result['errcode']) && 0 != $this->result['errcode'])
        {
            throw new ApiException($this->result['errmsg'], $this->result['errcode']);
        }
        else
        {
            return [
                'open_id' => $this->result['openid'],
                'union_id' => array_key_exists('openid', $this->result) ? $this->result['openid'] : '',
                'session_key'=> $this->result['session_key'],
            ];
        }
    }

	/**
	 * 第一步:获取PC页登录所需的url，一般用于生成二维码
	 * @param string $callbackUrl 登录回调地址
	 * @param string $state 状态值，不传则自动生成，随后可以通过->state获取。用于第三方应用防止CSRF攻击，成功授权后回调时会原样带回。一般为每个用户登录时随机生成state存在session中，登录回调中判断state是否和session中相同
	 * @param array $scope 请求用户授权时向用户显示的可进行授权的列表。可空，默认snsapi_login
	 * @return string
	 */
	public function getAuthUrl($callbackUrl = null, $state = null, $scope = null)
	{

	}

	/**
	 * 第一步:获取在微信中登录授权的url
	 * @param string $callbackUrl 登录回调地址
	 * @param string $state 状态值，不传则自动生成，随后可以通过->state获取。用于第三方应用防止CSRF攻击，成功授权后回调时会原样带回。一般为每个用户登录时随机生成state存在session中，登录回调中判断state是否和session中相同
	 * @param array $scope 请求用户授权时向用户显示的可进行授权的列表。可空，默认snsapi_userinfo
	 * @return string
	 */
	public function getWeixinAuthUrl($callbackUrl = null, $state = null, $scope = null)
	{
	}

    /**
     * 获取用户资料
     * @param string $accessToken
     * @return array
     * @throws ApiException
     */
	public function getUserInfo($accessToken = null)
	{

	}

	/**
	 * 刷新AccessToken续期
	 * @param string $refreshToken
	 * @return bool
	 */
	public function refreshToken($refreshToken)
	{
		$this->result = $this->http->get($this->getUrl('sns/oauth2/refresh_token', array(
			'appid'			=>	$this->appid,
			'grant_type'	=>	'refresh_token',
			'refresh_token'	=>	$refreshToken,
		)))->json(true);
		return isset($this->result['errcode']) && 0 == $this->result['errcode'];
	}
	
	/**
	 * 检验授权凭证AccessToken是否有效
	 * @param string $accessToken
	 * @return bool
	 */
	public function validateAccessToken($accessToken = null)
	{
		$this->result = $this->http->get($this->getUrl('sns/auth', array(
			'access_token'	=>	null === $accessToken ? $this->accessToken : $accessToken,
			'openid'		=>	$this->openid,
		)))->json(true);
		return isset($this->result['errcode']) && 0 == $this->result['errcode'];
	}

    /**
     * 第二步:处理回调并获取access_token。与getAccessToken不同的是会验证state值是否匹配，防止csrf攻击。
     * @param string $storeState 存储的正确的state
     * @param string $code 第一步里$redirectUri地址中传过来的code，为null则通过get参数获取
     * @param string $state 回调接收到的state，为null则通过get参数获取
     * @return string
     * @throws ApiException
     */
	protected function __getAccessToken($storeState, $code = null, $state = null)
	{

	}

}
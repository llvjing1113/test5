<?php
class WeChat{
	private $_appid;
	private $_appdsecret;
	private $_token;
	public function __construct($_appid,$_appsecret,$_token){
			$this->_appid=$_appid;
			$this->_appsecret=$_appsecret;
			$this->_token=$_token;
	}
	
	public function _request($curl,$https=true,$method='GET',$data=null){
			$ch =curl_init();
			curl_setopt($ch,CURLOPT_URL,$curl);
			curl_setopt($ch,CURLOPT_HEADER,false);
			curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
			if($https){
				curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
				curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,true);
			}
			if($method == 'POST'){
				curl_setopt($ch,CURLOPT_POST,true);
				curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
			}
			$content=curl_exec($ch);
			curl_close($ch);
			return $content;
	}
}
$wechat=new WeChat('wx7bacd3a1711ae62a','056def9f4d39def9a403210d7b282003','');
echo $wechat->_request('https://www.baidu.com');
?>
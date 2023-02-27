<?php
namespace app\index\controller;
use think\Db;
use think\User;
use think\Validate;
use think\Request;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
class Index extends \think\Controller
{
	//注册开始
	public function register(){
		// return "数据";
		// $data=Db::name("user")->select();
		// return json($data);
		if($this->request->isPost()){
			//先判断账号是否存在,如果存在添加的话，会报错
			$data=Db::name("user")->select(input("post.username"));
			// $data=Db::name("user")->select($this->request->post());上面和这一个都可以
			if($data){
				return 2;//已经存在
				
			}else{
				//不存在账号添加
				$rusert=Db::name("user")->insert($this->request->post());
				if($rusert){
					return 1;//注册成功
				}else{
					return 0;//注册失败
				}
				
			}
			// $id=input("post.username");获取发送来的账号
			// return $id;
		}
	}
	//注册结束
	//登录开始
	public function login(){
		if($this->request->isPost()){
			//该账号是否存在
			$username=Db::name('user')->where('username',input('post.username'))->select();
			if($username){
				//再判断账号密码是否正确
				$data=Db::name('user')->where('username',input("post.username"))->where('password',input("post.password"))->column('password');
				if($data){
					return 1;//登录成功
					
				}else{
					return 0;//密码或者账号错误
					
				}
			}else{
				return 2;//不存在
			}
			
			// return json($data);
			// $id=input("post.username");获取发送来的账号
			// return $id;
		}
	}
	
	//登录结束
	//测试
	public function ceshi(){
		if($this->request->isPost()){
			//先判断账号是否存在,如果存在添加的话，会报错
			// $data=Db::name("user")->select(input("post.username"));
			// // $data=Db::name("user")->select($this->request->post());上面和这一个都可以
			// if($data){
			// 	return 2;//已经存在
				
			// }else{
			// 	//不存在账号添加
			// 	$rusert=Db::name("user")->insert($this->request->post());
			// 	if($rusert){
			// 		return 1;//注册成功
			// 	}else{
			// 		return 0;//注册失败
			// 	}
				
			// }
			// 获取发送来的账号
			// $id=input("post.token");
			// return $id;
			$token=input("post.token");
			     try{
						$key='123abc';
			         // $Result = JWT::decode($token,'123abc','HS256');
						// $Result=json(JWT::decode($token,new Key($key,'HS256')));
			//          $auth=json($Result,true);
						$test=JWT::decode($token,new Key($key,'HS256'));
						// halt($test);
						return $test;
			     }
			     catch (\Exception $e)
			     {
			         echo $e->getMessage();
			         exit();
			     }
		}
	// 	// echo "测试";
		// return "sldkf";
	}  
	public function yuyin(){
		$per=null;
		if (isset($_GET['per'])) {
		  $per = $_GET['per'];
		  if ($per > 0 && $per < 7) {
		    $per = $per;
		  }
		} else {
		  $per = 4;
		}
		if (isset($_GET['txt'])) {
		  $txt = $_GET['txt'];
		  header("Content-Type: audio/mpeg");
		  $voice = file_get_contents('https://api.vvhan.com/api/song.php?txt=' . $txt . ' &per=' . $per);
		  exit($voice);
		} else {
		  header(' Content-type:application/json;charset=UTF-8');
		  exit('{"code":-1,"msg":"参数不完整"}');
		}
	}
	//创建token
    public function crate_token(){
		//该账号是否存在
		$username=Db::name('user')->where('username',input('post.username'))->select();
		if($username){
			//再判断账号密码是否正确
			$data=Db::name('user')->where('username',input("post.username"))->where('password',input("post.password"))->column('password');
			if($data){
				$userData=Db::name("user")->select($this->request->post());
				// return $userData;
				// return 1;//登录成功
				$secret = "123abc"; //密匙
				$uid=666;
				$payload = [
					$userData,
				    'iss'=>'pyg',                //签发人(官方字段:非必需)
				    'exp'=>time()+30,     //过期时间(官方字段:非必需)
				    'aud'=>'admin',              //受众(官方字段:非必需)
				    'nbf'=>time(),               //生效时间(官方字段:非必需)
				    'iat'=>time(),               //签发时间(官方字段:非必需)
				    'admin_id'=>$uid,        //自定义字段
				    'admin'=>true                //自定义字段
				];
				$keyId = "keyId";
				$token = JWT::encode($payload,$secret,'HS256',$keyId);
				return $token;
			}else{
				return 0;//密码或者账号错误
				
			}
		}else{
			return 2;//不存在
		}
    }
//验证token
    public function verify_token()
    {
		if($this->request->isPost()){
			$token=input("post.token");
			try{
				$key='123abc';
				$test=JWT::decode($token,new Key($key,'HS256'));
				return $test;
		     }
			catch (\Firebase\JWT\SignatureInvalidException $e) {  //签名不正确
		        echo $e->getMessage();
		        exit();
		    } catch (\Firebase\JWT\BeforeValidException $e) {  // 签名在某个时间点之后才能用
		        echo $e->getMessage();
		        exit();
		    } catch (\Firebase\JWT\ExpiredException $e) {  // token过期
		        // echo $e->getMessage();
				return 0;
		        exit();
		    } catch (\Exception $e) {  //其他错误
		        echo $e->getMessage();
		        exit();
		    }
		}
    }
}

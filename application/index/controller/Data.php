<?php
namespace app\index\controller;
use think\Db;
use think\User;
use think\Validate;
use think\Controller;
class Data extends Controller
{
    public function index()
    {
		//访问路径：http://a/index.php/index/data/index
		//设置路由访问路径：http://a/index.php/data
        // 查询状态为1的用户数据 并且每页显示10条数据
        // $list = Db::name('chat')->paginate(4);
        // return json($list);
		// $this->assign(name:'name',value:'张三');
		// return $this->fetch();
		
		// 查询状态为1的用户数据 并且每页显示10条数据
		$list = Db::name('chat')->paginate(5);
		// 把分页数据赋值给模板变量list
		$this->assign('list', $list);
		// 渲染模板输出
		// dump($this->fetch());
		return $this->fetch();
    }
	public function add(){
		if($this->request->isPost()){
			Db::name("chat")->insert($this->request->post());
			
			$this->success("添加成功","/index.php/data");
		}
		return $this->fetch();
	}
	public function del(){
		if($this->request->isGet()){
			$id=input("get.id");
			// dump($id);
			$data=Db::table("chat")->where("id",$id)->delete();
			if($data){
				$this->success("删除成功","/index.php/data");
			}else{
				$this->success("删除失败","/index.php/data");
			}
		}
		return $this->fetch();
	}
	public function edit(){
		$id=input("get.id");
		$data=Db::name("chat")->where("id",$id)->select();
		// dump($data);
		$this->assign('data',$data);
		return $this->fetch();
	}
	public function update(){
		if($this->request->isPost()){
			Db::name("chat")->update($this->request->post());
		$this->success("修改成功","/index.php/data");
		}
		return $this->fetch();
	}
	public function up(){
		return view();
	}
	public function upload(){
	    // 获取表单上传文件 例如上传了001.jpg
	    $file = request()->file('image');
	    // 移动到框架应用根目录/uploads/ 目录下
	    $info = $file->move( 'uploads','');
	    if($info){
	        // 成功上传后 获取上传信息
	        // 输出 jpg
	        // echo $info->getExtension();
	        // // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
	        echo $info->getSaveName();
	        // // 输出 42a79759f284b767dfcb2a0197904287.jpg
	        // echo $info->getFilename(); 
	    }else{
	        // 上传失败获取错误信息
	        echo $file->getError();
	    }
	}
}

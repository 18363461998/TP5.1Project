<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;
use think\Base;

class Login extends Base
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function login()
    {
        return view();
    }

    //验证用户名以及密码
    public function checkMsg(Request $request)
    {
        //获取用户输入的账号信息
        $data = $request->param();

        //创建验证规则
        $rule = [
            'username' => 'require',
            'password' => 'require',
        ];
        //编写验证规则信息
        $rule_msg = [
            'username.require' => '用户名不可以为空',
            'password.require' => '密码不可以为空',
        ];

        //将规则和信息都传入Validate，初始化Vialidate
        $validate = new \think\Validate($rule,$rule_msg);
        //使用Validate对象的check方法检测用户输入的信息
        if(!$validate->check($data))
        {
            //不通过即返回错误信息并停止运行
            $this->error($validate->getError());
        }

        //通过用户输入的用户名获取数据库存放的用户信息，返回空数组则认为用户不存在
        $Msg = \app\admin\model\Login::table('user')->where(['username'=>$data['username']])->select();

        //判断数组是否为空
        if(!isset($Msg[0]))
        {
            $this->error('用户不存在 ');
        }

        //如果用户存在则将用户输入的密码和数据库保存的密码进行比较

        if($Msg[0]['pwd'] != addsolt($data['password']))
        {
            $this->error('密码错误');
        }

        //用户信息输入正确便将用户信息保存到cookie
        cookie('userMsg',$data);
        //登陆成功，转跳到首页
        $this->success('登陆成功','admin/index/index');
    }

    //=注册用户页面
    public function register()
    {
        return view('register');
    }

    //注册信息验证
    public function addMsg(Request $request)
    {
        $data = $request->param();

        $rule = [
          'username' => 'require|length:5,15',
          'password' => 'require|length:5,15',
          'repassword' => 'require|confirm:password',
        ];

        $msg = [
          'username.require' => '用户名不能为空',
          'username.length' => '用户名长度必须在5-15个字符之间',
          'password.require' => '密码不能为空',
          'password.length' => '密码长度必须在5-10个字符之间',
          'repassword.require' => '第二次输入的密码不能为空',
          'repassword.confirm' => '两次输入的密码不一致，请重新输入'
        ];

        $validate  = new \think\Validate($rule,$msg);
        if(!$validate->check($data))
        {
            $this->error($validate->getError());
        }

        if(isset((\app\admin\model\Login::table('user')->where(['username'=>$data['username']])->select())[0]))
        {
            $this->error('该用户已存在，请换一个用户名');
        }

        $msg = [
            'username' => $data['username'],
            'pwd' => addsolt($data['password']),
        ];

        \app\admin\model\Login::table('user')->insert($msg);
        $this->success('注册成功！正在前往登录页','/admin/login/login');
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {

    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        //
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        //
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        //
    }
}

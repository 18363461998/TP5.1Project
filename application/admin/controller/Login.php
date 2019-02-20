<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;

class Login extends Controller
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

    public function checkMsg(Request $request)
    {
        $data = $request->param();

        $rule = [
            'username' => 'require',
            'password' => 'require',
        ];
        $rule_msg = [
            'username.require' => '用户名不可以为空',
            'password.require' => '密码不可以为空',
        ];

        $valiedate = new \think\Validate($rule,$rule_msg);
        if(!$valiedate->check($data))
        {
            $this->error($valiedate->getError());
        }

        $Msg = \app\admin\model\Login::table('user')->where(['username'=>$data['username']])->select();

        if(!isset($Msg[0]))
        {
            $this->error('用户不存在 ');
        }

        if($Msg[0]['pwd'] != $data['password'])
        {
            $this->error('密码错误');
        }

        $this->success('登陆成功','admin/index/index');
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        //
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

<?php
/**
 * describe:git自动化部署
 * author:<axunl@1140718342@qq.com>
 * datetime:2020/5/1 22:44
 * */

$post = file_get_contents('php://input');//获取请求携带的参数

$post = json_decode($post, true);//将json转换成数组
//验证密码 保证请求安全性
if ($post['password'] == '110609yan') {
    exec('sudo -u root git pull origin master 2<&1', $output);
    echo json_encode($output);
} else {
    echo '失败';
}
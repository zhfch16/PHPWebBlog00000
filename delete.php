<?php
### 个人博客系统
### 需要安装PDO与PDO_MYSQL库

require 'model/BlogModel.php';

$model = new BlogModel();
if (!empty($_REQUEST['id'])) {
    # 根据ID删除对应博客
    $model->delete($_REQUEST['id']);
    echo json_encode(['error' => $model->getError()]);
    return;
}
# 如果未指定ID，重定向到首页
header('index.php');

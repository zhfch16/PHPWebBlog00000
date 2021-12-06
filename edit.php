<?php
### 个人博客系统
### 需要安装PDO与PDO_MYSQL库

require 'model/BlogModel.php';

$model = new BlogModel();

if (!empty($_POST['blog'])) {
    if (!empty($_POST['blog']['id'])) {
        # 如果POST请求包含博客及ID，更新ID对应的博客
        $model->update($_POST['blog']);
        echo json_encode(['error' => $model->getError()]);
        return;
    }
    # 如果POST请求包含博客但是未指定ID，新建一条博客
    $model->create($_POST['blog']);
    echo json_encode(['error' => $model->getError()]);
    return;
}

$record = [];
$error = '';
if (!empty($_REQUEST['id'])) {
    # 如果包含ID，获取ID对应的博客用于更新
    $record = $model->find($_REQUEST['id']);
    $error = $model->getError();
}
?>

<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>个人博客系统</title>

    <link href="css/bootstrap.css" rel="stylesheet">

    <!--[if lt IE 9]>
      <script src="https://cdn.bootcss.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <div class="container">
      <div class="row">
        <div class="col-xs-12">
          <h1 class="text-center">个人博客系统</h1>
          <hr/>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-12 col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2">
          <?php if (!empty($error)) { ?>
          <h3 class="text-center text-danger"><?= $error ?></h3>
          <?php } else { ?>
          <input type="hidden" name="id" value="<?= $record['id'] ?? '' ?>" />
          <div class="form-group">
            <label for="title">标题</label>
            <input type="text" name="title" value="<?= $record['title'] ?? '' ?>" class="form-control" id="title" placeholder="标题">
          </div>
          <div class="form-group">
            <label for="content">内容</label>
            <textarea id="content" name="content" class="form-control" cols="80" placeholder="内容"><?= $record['content'] ?? '' ?></textarea>
          </div>
          <br>
          <div class="form-group text-center">
            <button class="btn btn-primary btn-lg" id="submit" type="button" style="min-width: 300px;">发布博客</button>
          </div>
          <?php } ?>
          <br>
        </div>
      </div>
    </div>

    <script src="js/jquery-3.2.1.js"></script>
    <script src="ckeditor/ckeditor.js"></script>
    <script type="text/javascript">
    $(function() {
        CKEDITOR.replace('content');
        $('#submit').on('click', function(e) {
            var title = $('#title').val();
            if ($.trim(title) == '') {
                $('#title').focus();
                alert('请输入标题');
                return;
            }
            var content = CKEDITOR.instances.content.getData();
            if ($.trim(content) == '') {
                CKEDITOR.instances.content.focus();
                alert('请输入内容');
                return;
            }
            $.post('edit.php', {
                blog: {
                    id: $('input[name=id]').val(),
                    title: title,
                    content: content
                }
            }, function(result) {
                if (result && result.error) {
                    alert(result.error);
                    return;
                }
                location.href = 'index.php';
            }, 'json');
        });
    });
    </script>
  </body>
</html>

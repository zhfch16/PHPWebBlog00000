<?php
### 个人博客系统
### 需要安装PDO与PDO_MYSQL库

require 'model/BlogModel.php';

# 获取所有博客
$model = new BlogModel();
$records = $model->read();
$error = $model->getError();
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
          <h1 class="text-center">个人博客系统 <a class="pull-right glyphicon glyphicon-plus" style="text-decoration:none;" href="edit.php"></a></h1>
          <hr/>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-12 col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2">
          <?php if (!empty($error)) { ?>
          <h3 class="text-center text-danger"><?= $error ?></h3>
          <?php } else if (count($records) == 0) { ?>
          <h3 class="text-center">你还没有写博客^_^</h3>
          <?php } else { ?>
            <?php foreach ($records as $record) {?>
            <h3>
              <?= $record['title'] ?>
              <span class="text-muted" style="font-size: 70%;">（<?= $record['date_created'] ?>）</span>
              <span class="pull-right">
                <a class="glyphicon glyphicon glyphicon-pencil" style="text-decoration:none;" href="edit.php?id=<?= $record['id'] ?>"></a>
                &nbsp;
                <a class="pull-right glyphicon glyphicon-trash" style="text-decoration:none;" href="#" data-id="<?= $record['id'] ?>"></a>
              </span>
            </h3>
            <hr />
            <div style="margin: 0 8px; padding: 8px 16px; box-shadow: 0 4px 4px #eee;"><?= $record['content'] ?></div>
            <br/>
            <br/>
            <?php } ?>
          <?php } ?>
        </div>
      </div>
      <div class="row">
        <div class="col-xs-12 text-center">
          <hr/>
          <a class="btn btn-primary btn-lg" style="min-width: 300px;" href="edit.php">发布博客</a>
          <br/>
          <br/>
          <br/>
        </div>
      </div>
    </div>

    <script src="js/jquery-3.2.1.js"></script>
    <script type="text/javascript">
    $(function() {
        $('.glyphicon-trash').on('click', function(e) {
            var el = $(this),
                id = el.data('id');
            if (!confirm('你确定要删除该条博客？删除后无法撤销！')) {
                return;
            }
            $.post('delete.php', {
                id: $(this).data('id')
            }, function(result) {
                if (result && result.error) {
                    alert(result.error);
                    return;
                }
                location.reload();
            }, 'json');
        });
    });
    </script>
  </body>
</html>

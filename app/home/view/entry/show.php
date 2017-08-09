<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="./static/bt3/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <div class="panel panel-danger">
            <div class="panel-heading">
                <h3 class="panel-title">详细信息</h3>
            </div>
            <div class="panel-body">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>编号</th>
                        <th>姓名</th>
                        <th>头像</th>
                        <th>性别</th>
                        <th>班级</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($data as $k=>$v): ?>
                        <tr>
                            <td><?php  echo $k+1?></td>
                            <td><?php  echo $v['sid']?></td>
                            <td><?php  echo $v['sname']?></td>
                            <td><?php  echo $v['birthday']?></td>
                            <td><?php  echo $v['sex']?></td>
                            <td><?php  echo $v['hobby']?></td>
                            <td>
                                <img src="<?php echo $v['profile']?>" width="80">
                            </td>
                            <td><?php  echo $v['gid']?></td>
                            <td><?php  echo $v['gname']?></td>
                        </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
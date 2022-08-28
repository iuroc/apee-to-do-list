<?php require 'config.php'; ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1, maximum-scale=1, user-scalable=no, viewport-fit=cover">
    <title><?php echo $config['title'] ?></title>
    <meta name="description" content="<?php echo $config['description'] ?>">
    <link rel="stylesheet" href="https://cdn.staticfile.org/bootstrap/4.6.0/css/bootstrap.min.css" />
    <link rel="apple-touch-icon" sizes="180x180" href="img/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="img/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="img/favicon-16x16.png">
    <link rel="manifest" href="img/site.webmanifest">
    <style>
        .page-oyp {
            display: none;
        }
    </style>
    <script src="https://cdn.staticfile.org/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.staticfile.org/bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.staticfile.org/clipboard.js/2.0.10/clipboard.min.js"></script>
    <script src="https://cdn.staticfile.org/blueimp-md5/2.19.0/js/md5.min.js"></script>
    <link rel="stylesheet" href="css/index.css?<?php echo time(); ?>">
    <script src="js/poncon.js?<?php echo time(); ?>"></script>
    <script src="js/index.js?<?php echo time(); ?>"></script>
</head>

<body>
    <nav class="navbar navbar-expand-sm navbar-light bg-light shadow-sm sticky-top mb-4">
        <a class="navbar-brand" href=""><?php echo $config['title'] ?></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <!-- <li class="nav-item nav-active-home">
                    <a class="nav-link" href="#/">文件上传</a>
                </li> -->
            </ul>
        </div>
    </nav>
    <div class="container pb-4">
        <div class="page-home page-oyp">
            <textarea class="form-control mb-3 shadow-sm _jfgghywsegyferg" style="height: 100px;"></textarea>
            <div class="font-size-0 d-flex mb-3">
                <button class="btn btn-info shadow-sm d-none d-sm-inline-block" onclick="Poncon.home_clickAddData()">添加待办</button>
                <button class="btn btn-info shadow-sm d-sm-none" onclick="Poncon.home_clickAddData()">添加</button>
                <button class="btn border-danger text-danger shadow-sm _wfergerge ml-3" onclick="Poncon.home_clickSetNeedTime()">设置期限</button>
                <div class="_fyhferygfyer ml-3">
                    <dic class="input-group">
                        <input type="date" class="form-control border-danger shadow-sm _juafggfuergrth" id="home-input-needTime">
                        <div class="input-group-append">
                            <button class="btn btn-danger shadow-sm" onclick="Poncon.home_clickRemoveNeedTime()">取消设置</button>
                        </div>
                    </dic>
                </div>
            </div>
            <div class="data-list  _jfguyrguyer">
                <div class="rounded border shadow-sm p-3 d-flex mb-3">
                    <div class="custom-control custom-checkbox mr-3">
                        <input type="checkbox" class="custom-control-input d-none" id="home-list-item-0">
                        <label class="custom-control-label" for="home-list-item-0"></label>
                    </div>
                    <div class="right_jfgghesdgfherg">
                        <h5 contenteditable="true" class="font-weight-bold _hfuwugfergtruhg">完成一篇论文，考驾照</h5>
                        <div class="d-flex">期限：<b class="text-info" style="flex: 1;" contenteditable="true">2022 年 8 月 28 日</b></div>
                        <div class="small text-muted">
                            2022年8月28日 创建
                        </div>
                    </div>
                </div>
            </div>
            <button class="btn btn-primary loadMore_jfghe" style="display: none;">加载更多</button>
        </div>
        <div class="page-login page-oyp">
            <div class="row">
                <div class="col-xl-5 col-lg-6 col-md-8 col-sm-10 mx-auto">
                    <div class="rounded border shadow-sm p-3 p-md-4">
                        <h4 class="text-center mb-3">用户登录</h4>
                        <div class="form-group">
                            <label for="login-input-username">用户名</label>
                            <input type="text" class="form-control" id="login-input-username">
                        </div>
                        <div class="form-group mb-4">
                            <label for="login-input-password">密码</label>
                            <input type="password" class="form-control" id="login-input-password" autocomplete="new-password">
                        </div>
                        <div class="row">
                            <div class="col pr-0 pr-sm-2">
                                <button class="btn btn-block btn-success" onclick="Poncon.login_clickLogin()">登录</button>
                            </div>
                            <div class="col">
                                <button class="btn btn-block btn-outline-info" data-toggle="collapse" href="#register-tip">注册</button>
                            </div>
                        </div>
                        <div class="collapse mt-4" id="register-tip">
                            <div class="alert alert-primary mb-0" role="alert">
                                关注 <b>鹏优创</b> 微信公众号，发送 <b>/zc</b> 指令进行注册
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
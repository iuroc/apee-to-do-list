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

<body style="display: none;">
    <nav class="navbar navbar-expand-sm navbar-light bg-light shadow-sm sticky-top mb-3 mb-sm-4">
        <a class="navbar-brand" href=""><?php echo $config['title'] ?></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item nav-active-home">
                    <a class="nav-link cursor _ufyhesgfer" data-container="body" data-toggle="popover" data-trigger="focus" tabindex="0" data-placement="bottom" title="使用教程" data-content="点击列表左边的选框，可以设置事项的完成状态。直接点击列表可以编辑内容，编辑时文字颜色变为红色，回车即可保存修改。删除事项前，需要先将事项状态设为已完成">教程</a>
                </li>
                <li class="nav-item nav-active-home">
                    <a class="nav-link cursor" href="https://github.com/oyps/apee-to-do-list" target="_blank">Github</a>
                </li>
                <li class="nav-item nav-active-home _ajhfghwsf show-hasLogin" style="display: none;">
                    <a class="nav-link cursor" onclick="Poncon.logout()">退出登录</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container pb-4">
        <div class="page-home page-oyp">
            <div class="mb-3">
                <textarea class="form-control shadow-sm _jfgghywsegyferg" style="height: 100px;" onkeyup="Poncon.home_keydown('._jfgghywsegyferg')"></textarea>
                <div class="invalid-feedback _sfeerreh">
                    请输入待办内容
                </div>
            </div>
            <div class="font-size-0 d-flex mb-3">
                <button class="btn btn-info shadow-sm d-none d-sm-inline-block add_hfghsdgfsd" onclick="Poncon.home_clickAddData(this)">添加待办</button>
                <button class="btn btn-info shadow-sm d-sm-none add_hfghsdgfsd" onclick="Poncon.home_clickAddData(this)">添加</button>
                <button class="btn border-danger text-danger shadow-sm _wfergerge ml-3" onclick="Poncon.home_clickSetNeedTime()">设置期限</button>
                <div class="_fyhferygfyer ml-3">
                    <dic class="input-group _jhawergeewr">
                        <input type="date" class="form-control border-danger shadow-sm _juafggfuergrth" id="home-input-needTime">
                        <div class="input-group-append">
                            <button class="btn btn-danger shadow-sm" onclick="Poncon.home_clickRemoveNeedTime()">取消设置</button>
                        </div>
                    </dic>
                </div>
            </div>
            <div class="data-list  _jfguyrguyer"></div>
            <button class="btn btn-primary loadMore_jfghe" onclick="Poncon.home_loadMore()" style="display: none;">加载更多</button>
        </div>
        <div class="page-login page-oyp">
            <div class="row">
                <div class="col-xl-5 col-lg-6 col-md-8 col-sm-10 mx-auto">
                    <div class="rounded border shadow-sm p-3 p-md-4">
                        <h4 class="text-center mb-3">用户登录</h4>
                        <div class="form-group">
                            <label for="login-input-username">用户名</label>
                            <input type="text" class="form-control" id="login-input-username">
                            <div class="invalid-feedback">
                                请输入用户名
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <label for="login-input-password">密码</label>
                            <input type="password" class="form-control" id="login-input-password" autocomplete="new-password" onkeyup="Poncon.login_keyup(event, '._jfgheswfred')">
                            <div class="invalid-feedback">
                                请输入密码
                            </div>
                        </div>

                        <div class="row">
                            <div class="col pr-0 pr-sm-2">
                                <button class="btn btn-block btn-success _jfgheswfred" onclick="Poncon.login_clickLogin()">登录</button>
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
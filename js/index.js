history.scrollRestoration = 'manual'

$(document).ready(function () {
    if (!Poncon.login(true)) {
        location.hash = '/login'
    }
    router(location.hash)
    function router(hash) {
        hash = hash.split('/')
        var target = hash[1]
        // target非法状态
        if (!target || !target.match(/^\w+$/)) {
            target = 'home'
        }
        $('.page-oyp').css('display', 'none')
        var Page = $('.page-' + target)
        Page.css('display', 'block')
        // 控制侧边选项卡阴影
        // $('.oyp-action, .oyp-action-sm').removeClass('oyp-active')
        // $('.tab-' + target).addClass('oyp-active')
        if (target == 'home') {
            history.replaceState({}, null, './')
            document.title = Poncon.title
            if (!Poncon.load.home && Poncon.loginStatus) {
                Poncon.home_loadDataList(0)
            }
            if (!Poncon.loginStatus) {
                location.hash = '/login'
            }
        } else if (target == 'login') {
            document.title = '用户登录 - ' + Poncon.title
            $('body').show()
        } else {
            location.hash = ''
        }
    }
    document.body.ondragstart = () => { return false }
    window.addEventListener('hashchange', function (event) {
        var hash = new URL(event.newURL).hash
        router(hash)
    })
    function getDate() {
        var date = new Date()
        return date.getFullYear() + '年' + (date.getMonth() + 1) + '月' + date.getDate() + '日\n有什么安排...'
    }
    $('input').bind('keyup', function () {
        $(this).removeClass('is-invalid')
    })
    $(function () {
        $('[data-toggle="popover"]').popover({
            trigger: 'focus'
        })
    })
    $('._jfgghywsegyferg').attr('placeholder', '今天是' + getDate())
})

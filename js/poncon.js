const Poncon = {
    title: 'APEE 待办清单',
    storageKey: 'apee_to_do_list', // 本地存储键名
    data: {
        home: {},
        login: {}
    },
    load: {}, // 页面初始化加载完成情况，pageName: true/false
    tempTitle: {}, // 用于必要时记录页面标题
    request: $.post('api/empty.php'),
    /**
     * 用户登陆
     * @param {boolean} ifLoad 是否是初始化验证，如果是，则不弹窗提示
     * @returns {boolean} 是否验证成功
     */
    login(ifLoad) {
        var username = this.getStorage('username')
        var password = this.getStorage('password')
        if (!username || !password) {
            this.notLogin()
            return false
        }
        var success
        var This = this
        $.ajax({
            method: 'post',
            url: 'api/login.php',
            data: {
                username: username,
                password: password
            },
            contentType: 'application/x-www-form-urlencoded',
            dataType: 'json',
            success: function (data) {
                if (data.code == 200) {
                    success = true
                    This.setStorage('username', username)
                    This.setStorage('password', password)
                    This.loginStatus = true
                    $('.show-hasLogin').show()
                    $('.show-noLogin').hide()
                    if (location.hash.split('/')[1] == 'login' && !ifLoad) {
                        location.hash = ''
                    }
                    return true
                }
                if (!ifLoad) {
                    alert(data.msg)
                }
                This.notLogin()
                success = false
                return false
            },
            async: false
        })
        return success
    },
    /**
     * 获取存储值
     * @param {string} key 键名
     * @returns {any} 返回值
     */
    getStorage(key) {
        var data = localStorage[this.storageKey]
        try {
            data = JSON.parse(data)
            return data[key]
        } catch {
            return null
        }
    },
    /**
     * 设置存储值
     * @param {string} key 键名
     * @param {any} value 值
     */
    setStorage(key, value) {
        var data = localStorage[this.storageKey]
        data = data ? data : '{}'
        data = JSON.parse(data)
        data[key] = value
        localStorage[this.storageKey] = JSON.stringify(data)
    },
    /**
     * 未登录状态
     */
    notLogin() {
        $('.show-hasLogin').hide()
        $('.show-noLogin').show()
        this.loginStatus = false
        this.setStorage('username', '')
        this.setStorage('password', '')
    },
    /**
     * 点击登录
     */
    login_clickLogin() {
        var username = $('#login-input-username').val()
        var password = $('#login-input-password').val()
        if (!username) {
            $('#login-input-username').addClass('is-invalid')
            return
        } else if (!password) {
            $('#login-input-password').addClass('is-invalid')
            return
        }
        password = md5(password)
        this.setStorage('username', username)
        this.setStorage('password', password)
        this.login()
    },
    /**
     * 点击设置期限
     */
    home_clickSetNeedTime() {
        $('._fyhferygfyer').fadeIn()
        $('._wfergerge').hide()
        var date = new Date()
        function two(num) {
            if (num < 10) {
                return '0' + num
            }
            return '' + num
        }
        var year = date.getFullYear()
        var month = two(date.getMonth() + 1)
        var day = two(date.getDate())
        $('._juafggfuergrth').val([year, month, day].join('-'))
        this.data.home.need_time = true
    },
    /**
     * 
     * @param {object} ele 按钮DOM
     * @returns 
     */
    home_clickAddData(ele) {
        var content = $('._jfgghywsegyferg').val()
        content = content.replaceAll('<', '&lt;').replaceAll('>', '&gt;').replaceAll(/[\f\r\t\v ]/ig, '&nbsp;').replaceAll(/\n/ig, '<br>')
        var need_time = $('._juafggfuergrth').val().split('-')
        var need_time_str = ''
        if (!content || content.search(/^\s+$/) != -1) {
            $('._sfeerreh').html('请输入待办内容')
            $('._jfgghywsegyferg').addClass('is-invalid')
            return
        }
        if (need_time.length == 3) {
            need_time_str = need_time[0] + ' 年 ' + need_time[1] + ' 月 ' + need_time[2] + ' 日'
        } else if (this.data.home.need_time) {
            alert('请输入正确的日期')
            return
        }
        var This = this
        var old_btn_text = $(ele).html()
        $(ele).html('提交中').attr('disabled', 'disabled')
        $.post('api/add_data.php', {
            username: this.getStorage('username'),
            password: this.getStorage('password'),
            content: content.replace(/([^\x00-\xff])(\w)/g, '$1 $2').replace(/(\w)([^\x00-\xff])/g, '$1 $2'),
            need_time: need_time_str
        }, function (data) {
            if (data.code == 200) {
                $(ele).html(old_btn_text).removeAttr('disabled')
                $('._jfgghywsegyferg').val('')
                This.home_clickRemoveNeedTime()
                Poncon.home_loadDataList(0)
                return
            }
            alert(data.msg)
        })
    },
    /**
     * 取消设置期限
     */
    home_clickRemoveNeedTime() {
        $('._fyhferygfyer').hide()
        $('._wfergerge').fadeIn()
        $('._juafggfuergrth').val('')
        this.data.home.need_time = false
    },
    /**
     * 主页加载待办列表
     */
    home_loadDataList(page = 0, pageSize = 100) {
        var This = this
        if (page == 0) {
            $('.loadMore_jfghe').hide().removeAttr('disabled')
            $('.data-list._jfguyrguyer').html('')
        }
        $('.loadMore_jfghe').html('正在加载中').attr('disabled', 'disabled')
        $.post('api/get_list.php', {
            username: this.getStorage('username'),
            password: this.getStorage('password'),
            page: page,
            pageSize: pageSize
        }, function (data) {
            if (data.code == 200) {
                This.data.home.page = page
                This.data.home.pageSize = pageSize
                This.load.home = true
                if (page == 0) {
                    $('body').show()
                }
                if (data.data.length == 0 && page == 0) {
                    // 没有数据
                } else if (data.data.length == pageSize) {
                    $('.loadMore_jfghe').html('加载更多')
                    $('.loadMore_jfghe').show()
                    $('.loadMore_jfghe').removeAttr('disabled')
                } else if (page > 0) {
                    $('.loadMore_jfghe').show()
                    $('.loadMore_jfghe').html('已经到底了').attr('disabled', 'disabled')
                }
                var html = This.home_makeHtml(data.data)
                $('.data-list._jfguyrguyer').append(html)
                $('._jafrwgerg').unbind().change(function () {
                    var checked = this.checked
                    var parent = $(this).parents('._jshdesrf')
                    var id = parent.data('id')
                    $.post('api/change_finish.php', {
                        username: This.getStorage('username'),
                        password: This.getStorage('password'),
                        id: id,
                        finish: checked ? 1 : 0
                    }, function (data) {
                        if (data.code == 200) {
                            if (data.data.finish) {
                                parent.addClass('finish')
                                parent.find('.contenteditable_df').removeAttr('contenteditable')
                            } else {
                                parent.removeClass('finish')
                                parent.find('._hfuwugfergtruhg').attr('')
                                parent.find('.contenteditable_df').attr('contenteditable', 'true')
                            }
                            parent.find('._ggsdhesfesgf').html(data.data.update_time + ' 更新')
                            return
                        }
                        alert(data.msg)
                    })
                })
                $('.contenteditable_df').unbind().bind('keydown', function (event) {
                    if (event.keyCode == 13 && !event.shiftKey) {
                        return false;
                    }
                }).bind('keyup', function (event) {
                    if (event.keyCode == 13 && !event.shiftKey) {
                        var This_2 = this
                        var parent = $(this).parents('._jshdesrf')
                        var id = parent.data('id')
                        var content = parent.find('._hfuwugfergtruhg').html()
                        var need_time = parent.find('._ufgygtfyerytger').html()
                        $.post('api/edit_data.php', {
                            username: This.getStorage('username'),
                            password: This.getStorage('password'),
                            id: id,
                            content: content,
                            need_time: need_time
                        }, function (data) {
                            if (data.code == 200) {
                                $(This_2).removeClass('text-danger').blur()
                                parent.find('._ggsdhesfesgf').html(data.data.update_time + ' 更新')
                                return
                            }
                            alert(data.msg)
                        })
                        return false
                    } else if ((event.keyCode > 18 || event.keyCode < 16) && !event.shiftKey && !event.ctrlKey && !event.altKey) {
                        $(this).addClass('text-danger')
                    }
                })
                return
            }
            alert(data.msg)
        })
    },
    /**
     * 生成列表HTML
     * @param {Array} data 列表数据
     */
    home_makeHtml(data) {
        var html = ''
        var html_finish = ''
        data.forEach((item, index) => {
            item.finish = parseInt(item.finish)
            var html_temp = `<div class="rounded border shadow-sm py-2 px-3 d-flex mb-3 _jshdesrf${item.finish ? ' finish' : ''}" data-id="${item.id}">
                                <div class="custom-control custom-checkbox mr-3">
                                    <input type="checkbox"${item.finish ? ' checked' : ''} class="custom-control-input d-none _jafrwgerg" id="home-list-item-${index}">
                                    <label class="custom-control-label" for="home-list-item-${index}"></label>
                                </div>
                                <div class="right_jfgghesdgfherg">
                                    <div contenteditable="${item.finish ? 'off' : 'true'}" class="contenteditable_df _hfuwugfergtruhg">${item.content}</div>
                                    ${item.need_time ? `<div class="d-flex">期限：<b class="text-info contenteditable_df _ufgygtfyerytger" contenteditable="${item.finish ? 'off' : 'true'}">${item.need_time}</b></div>` : ''}
                                    <div class="small text-muted _ggsdhesfesgf">
                                        ${item.update_time} 更新
                                    </div>
                                </div>
                                <button class="btn btn-sm btn-danger btn_asdjiad" onclick="Poncon.home_deleteData(this, ${item.id})">删除</button>
                            </div>`
            if (item.finish) {
                html_finish += html_temp
            } else {
                html += html_temp
            }
        })
        return html + html_finish
    },
    /**
     * 按键按下事件
     * @param {string} selector 选择器
     */
    home_keydown(selector) {
        var ele = $(selector)
        ele.removeClass('is-invalid')
    },
    /**
     * 主页加载更多
     */
    home_loadMore() {
        this.home_loadDataList(this.data.home.page + 1, this.data.home.pageSize)
    },
    /**
     * 登录页回车事件
     * @param {string} selector 选择器
     */
    login_keyup(event, selector) {
        if (event.keyCode == 13) {
            $(selector).click()
        }
    },
    home_deleteData(ele, id) {
        $.post('api/delete_data.php', {
            username: this.getStorage('username'),
            password: this.getStorage('password'),
            id: id
        }, function (data) {
            if (data.code == 200) {
                $(ele).parents('._jshdesrf').remove()
                return
            }
            alert(data.msg)
        })
    },
    /**
     * 退出登录
     */
    logout() {
        if (confirm('确定要退出登录吗？')) {
            localStorage.removeItem(this.storageKey)
            location.reload()
        }
    }
}

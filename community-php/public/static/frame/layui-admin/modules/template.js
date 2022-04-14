/**
 * 表格通用模板template(监听表格列表)
 * */

layui.define(['table', 'form'], function (exports) {
    const $ = layui.$
        , table = layui.table
        , form = layui.form;

    //表格管理
    table.render({
        elem: '#LAY-table-manage'
        , url: URL.getData //模拟接口
        , cols: TABLE.cols
        , page: true
        , limit: 13
        , height: 'full-178'
        , text: '暂无数据！'
        , toolbar: "#tool-bar"
        , defaultToolbar: ['filter', 'print', 'exports']
    });


    //监听工具条
    table.on('tool(LAY-table-manage)', function (obj) {
        var data = obj.data;
        if (obj.event === 'del') {
            //询问框
            layer.confirm('是否确定删除？', {
                btn: ['确定', '取消'] //按钮
            }, function () {
                var id = data[TABLE_ID];
                $.ajax({
                    type: "POST",//提交数据的类型 POST GET
                    url: URL.deleteData + "/where/" + TABLE_ID + "/data/" + id,//提交的网址
                    dataType: "json",//"xml", "html", "script", "json", "jsonp", "text".//返回数据的格式
                    success: function (data) {  //成功返回之后调用的函数
                        if (data.code == 0) {
                            layer.msg(data.msg, {
                                time: 1000 //1s后自动关闭
                                , icon: 6
                            });
                            obj.del();
                        } else {
                            layer.msg(data.msg, {
                                time: 2000, //2s后自动关闭
                                icon: 5
                            });
                        }
                    },
                    error: function () { //调用出错执行的函数
                        layer.msg("服务器网络错误", {
                            time: 2000 //1s后自动关闭
                        });
                    }
                });
                layer.closeAll();
            }, function () {
                layer.closeAll();
            });
        } else if (obj.event === 'edit') {
            //获取屏幕宽度，
            let width = parseFloat(document.body.clientWidth);//获取屏幕宽度
            width = width > 800 ? 800 : width;
            var data = obj.data;
            var id = null;
            for (var k in data) { //获取第一个键值，因为第一个默认为id
                id = data[k];
                break;
            }
            layer.open({
                type: 2
                , title: '编辑'
                , content: URL.editData + "/id/" + id
                , maxmin: true
                , fixed: false
                , resize: true
                , offset: '20px'
                , area: [width + 'px', '600px']
                , btn: ['确定', '取消']
                , yes: function (index, layero) {
                    var iframeWindow = window['layui-layer-iframe' + index]
                        , submitID = 'LAY-submit'
                        , submit = layero.find('iframe').contents().find('#' + submitID);
                    //监听提交
                    iframeWindow.layui.form.on('submit(' + submitID + ')', function (data) {
                        var field = data.field; //获取提交的字段
                        //提交 Ajax 成功后，静态更新表格中的数据
                        $.ajax({
                            type: "POST",//提交数据的类型 POST GET
                            url: URL.doEditData,//提交的网址
                            data: field,//提交的数据
                            dataType: "json",//"xml", "html", "script", "json", "jsonp", "text".//返回数据的格式
                            beforeSend: function () {//在请求之前调用的函数
                                //执行的代码
                            },
                            success: function (data) {//成功返回之后调用的函数
                                if (data.code == 0) {
                                    layer.msg(data.msg, {
                                        time: 1000 //1s后自动关闭
                                        , icon: 6
                                    });
                                    table.reload('LAY-table-manage');
                                    layer.close(index); //关闭弹层
                                } else {
                                    layer.msg(data.msg, {
                                        time: 2000, //2s后自动关闭
                                        icon: 5
                                    });
                                }
                            },
                            complete: function (XMLHttpRequest, textStatus) {//调用执行后调用的函数
                            },
                            error: function () {//调用出错执行的函数
                                layer.msg("服务器网络错误", {
                                    time: 2000 //1s后自动关闭
                                });
                            }
                        });
                        table.reload('LAY-table-manage'); //数据刷新
                        layer.close(index); //关闭弹层
                    });
                    submit.trigger('click');
                }
                , success: function (layero, index) {

                }
            });
        }
    });

    exports('template', {})
});
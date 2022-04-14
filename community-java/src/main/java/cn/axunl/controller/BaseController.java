package cn.axunl.controller;

import cn.axunl.exception.ErrorException;
import cn.axunl.exception.LoginException;
import cn.axunl.model.CmUser;
import cn.axunl.util.RedisUtil;
import org.springframework.beans.factory.annotation.Autowired;

/**
 * base控制器
 */
public class BaseController {
    @Autowired
    private RedisUtil redisUtil;

    public CmUser getUser(String token) {
        CmUser user = (CmUser) redisUtil.getCacheObject(token);
        if (user == null) {
            //抛出异常
            throw new LoginException("登录态无效");
        }
        return user;
    }
}

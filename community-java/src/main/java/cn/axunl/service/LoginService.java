package cn.axunl.service;

import cn.axunl.dto.GiteeUserDTO;
import cn.axunl.mapper.IUserMapper;
import cn.axunl.model.CmUser;
import cn.axunl.util.HttpUtil;
import cn.axunl.util.RedisUtil;
import com.alibaba.fastjson.JSON;
import com.baomidou.mybatisplus.core.conditions.AbstractWrapper;
import com.baomidou.mybatisplus.core.conditions.query.QueryWrapper;
import com.baomidou.mybatisplus.core.conditions.update.UpdateWrapper;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.beans.factory.annotation.Value;
import org.springframework.stereotype.Service;

import java.util.Map;
import java.util.UUID;

/**
 * 登录服务
 */
@Service
public class LoginService {
    @Value("${gitee.client-id}")
    private String clientId;
    @Value("${gitee.client-secret}")
    private String clientSecret;
    @Value("${gitee.redirect_uri}")
    private String redirectUri;
    @Autowired
    private IUserMapper userMapper;
    @Autowired
    private RedisUtil redisUtil;

    /**
     * 获取码云oauth地址
     *
     * @return
     */
    public String getOauthUrl() {
        return "https://gitee.com/oauth/authorize?client_id=" + clientId + "&redirect_uri=" + redirectUri + "&response_type=code";
    }

    /**
     * 获取accessToken
     *
     * @param code 换取的code
     * @return
     */
    public String getAccessToken(String code) {
        String url = "https://gitee.com/oauth/token?grant_type=authorization_code&code=" + code + "&client_id=" + clientId + "&redirect_uri=" + redirectUri + "&client_secret=" + clientSecret;
        String res = HttpUtil.post(url, null);
        Map map = (Map) JSON.parse(res);
        return (String) map.get("access_token");
    }

    /**
     * 获取giteeUser信息
     *
     * @param assessToken 得到的as
     * @return
     */
    public GiteeUserDTO getGiteeUser(String assessToken) {
        String url = "https://gitee.com/api/v5/user?access_token=" + assessToken;
        String res = HttpUtil.get(url);
        GiteeUserDTO giteeUserDTO = JSON.parseObject(res, GiteeUserDTO.class);
        return giteeUserDTO;
    }

    /**
     * gitteUser saveOrUpdate
     *
     * @param giteeUser
     * @return
     */
    public CmUser saveOrUpdate(GiteeUserDTO giteeUser) {
        int giteeId = giteeUser.getId();
        AbstractWrapper wrapper = new QueryWrapper();
        wrapper.eq("gitee_id", giteeId);
        CmUser user = userMapper.selectOne(wrapper);
        if (user != null) {
            //删除token
            redisUtil.deleteObject(user.getUserToken());
            //更新
            user.setUserToken(UUID.randomUUID().toString());
            user.setUserName(giteeUser.getName());
            user.setUserAvatarUrl(giteeUser.getAvatarUrl());
            AbstractWrapper updateWrapper = new UpdateWrapper();
            updateWrapper.eq("user_id", user.getUserId());
            userMapper.update(user, updateWrapper);
        } else {
            //新增
            user = new CmUser();
            user.setGiteeId(giteeId);
            user.setUserToken(UUID.randomUUID().toString());
            user.setUserName(giteeUser.getName());
            user.setUserAvatarUrl(giteeUser.getAvatarUrl());
            userMapper.insert(user);
            //自查询
            user = userMapper.selectOne(wrapper);
        }
        redisUtil.setCacheObject(user.getUserToken(), user);
        return user;
    }

    public void loginOut(String token) {
        redisUtil.deleteObject(token);
    }
}

package cn.axunl.controller;

import cn.axunl.dto.GiteeUserDTO;
import cn.axunl.model.CmUser;
import cn.axunl.service.LoginService;
import cn.axunl.vo.AjaxResult;
import com.alibaba.fastjson.JSON;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.beans.factory.annotation.Value;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestBody;
import org.springframework.web.bind.annotation.RestController;
import org.springframework.web.servlet.view.RedirectView;

/**
 * 登录控制器
 */
@RestController
public class LoginController {
    @Value("${font-end-host}")
    private String fontEndHost;
    @Autowired
    private LoginService loginService;

    @GetMapping("/getOauthUrl")
    public AjaxResult getOauthUrl() {
        return AjaxResult.success(loginService.getOauthUrl());
    }

    @GetMapping("/callback")
    public RedirectView callback(String code) {
        String as = loginService.getAccessToken(code);
        GiteeUserDTO giteeUser = loginService.getGiteeUser(as);
        CmUser user = loginService.saveOrUpdate(giteeUser);
        RedirectView redirectView = new RedirectView();
        redirectView.setUrl(fontEndHost + "?user=" + JSON.toJSONString(user));
        return redirectView;
    }

    @PostMapping("/loginOut")
    public AjaxResult loginOut(@RequestBody String token) {
        loginService.loginOut(token);
        return AjaxResult.success();
    }
}

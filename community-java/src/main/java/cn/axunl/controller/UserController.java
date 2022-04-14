package cn.axunl.controller;

import cn.axunl.service.UserService;
import cn.axunl.vo.AjaxResult;
import org.apache.catalina.User;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.RequestHeader;
import org.springframework.web.bind.annotation.RequestParam;
import org.springframework.web.bind.annotation.RestController;

@RestController
public class UserController extends BaseController {
    @Autowired
    private UserService userService;

    @GetMapping("/user/question")
    public AjaxResult getQuestion(@RequestHeader("token") String token,
                                  @RequestParam(name = "page", defaultValue = "1") Integer page,
                                  @RequestParam(name = "limit", defaultValue = "10") Integer limit
    ) {
        return AjaxResult.success(userService.getQuestion(page, limit, getUser(token).getUserId()));
    }

    @GetMapping("user/comment/notReadNum")
    public AjaxResult getCommentNotReadNum(@RequestHeader("token") String token) {
        return AjaxResult.success(userService.getNotReadNum( getUser(token).getUserId()));
    }
    @GetMapping("user/comment/replies")
    public AjaxResult getCommentReplies(@RequestHeader("token") String token) {
        return AjaxResult.success(userService.getCommentReplies( getUser(token).getUserId()));
    }
}

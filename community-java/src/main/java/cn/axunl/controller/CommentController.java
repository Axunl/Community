package cn.axunl.controller;

import cn.axunl.dto.CommentDTO;
import cn.axunl.dto.ReplyDTO;
import cn.axunl.service.CommentService;
import cn.axunl.vo.AjaxResult;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.web.bind.annotation.*;

import java.util.List;

@RestController
public class CommentController extends BaseController {
    @Autowired
    private CommentService commentService;

    @GetMapping("/comment")
    public AjaxResult findAll() {
        return null;
    }

    @PostMapping("/comment")
    public AjaxResult create(ReplyDTO replyDTO,
                             @RequestHeader("token") String token, String method) {
        switch (method) {
            case "comment":
                replyDTO.setUserId(getUser(token).getUserId());
                break;
            case "reply":
                replyDTO.setReplyId(getUser(token).getUserId());
                break;
        }
        return AjaxResult.success(commentService.create(replyDTO));
    }

    @GetMapping("/comment/{commentId}")
    public AjaxResult findChildren(@PathVariable("commentId") Integer commentId) {
        return AjaxResult.success(commentService.findChildren(commentId));
    }

    @PutMapping("/comment/read/{commentId}")
    public AjaxResult readComment(@PathVariable("commentId") Integer commentId,
                                  @RequestHeader("token") String token) {
        commentService.readComment(commentId, getUser(token).getUserId());
        return AjaxResult.success();
    }
}

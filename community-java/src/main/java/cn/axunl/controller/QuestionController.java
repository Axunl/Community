package cn.axunl.controller;

import cn.axunl.model.CmQuestion;
import cn.axunl.service.CommentService;
import cn.axunl.service.QuestionService;
import cn.axunl.vo.AjaxResult;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.web.bind.annotation.*;

/**
 * 问题控制器
 */
@RestController
public class QuestionController extends BaseController {
    @Autowired
    private QuestionService questionService;

    @PostMapping("/question")
    public AjaxResult insert(CmQuestion question, @RequestHeader("token") String token) {
        question.setUserId(getUser(token).getUserId());
        questionService.insert(question);
        return AjaxResult.success();
    }

    @GetMapping("/question")
    public AjaxResult findAll(@RequestParam(name = "page", defaultValue = "1") Integer page,
                              @RequestParam(name = "limit", defaultValue = "10") Integer limit,
                              @RequestParam(name = "tag", defaultValue = "") String tag,
                              @RequestParam(name = "title", defaultValue = "") String title) {
        return AjaxResult.success(questionService.findAll(page, limit, tag, title));
    }

    @GetMapping("/question/{id}")
    public AjaxResult find(@PathVariable("id") Integer id) {
        return AjaxResult.success(questionService.find(id));
    }

    @DeleteMapping("/question/{id}")
    public AjaxResult delete(@PathVariable("id") Integer id, @RequestHeader("token") String token) {
        questionService.delete(id, getUser(token).getUserId());
        return AjaxResult.success();
    }

    @PutMapping("/question/{id}")
    public AjaxResult edit(@PathVariable("id") Integer id,
                           @RequestHeader("token") String token,
                           CmQuestion question
    ) {
        questionService.edit(question, getUser(token).getUserId());
        return AjaxResult.success();
    }
}

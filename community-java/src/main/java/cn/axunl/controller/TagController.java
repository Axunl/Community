package cn.axunl.controller;

import cn.axunl.service.TagService;
import cn.axunl.vo.AjaxResult;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.RestController;

/**
 * 标签控制器
 */
@RestController
public class TagController {
    @Autowired
    TagService tagService;

    @GetMapping("/tag")
    public AjaxResult findAll() {
        return AjaxResult.success(tagService.findAll());
    }
}

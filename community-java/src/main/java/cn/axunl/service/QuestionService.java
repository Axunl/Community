package cn.axunl.service;

import cn.axunl.dto.QuestionDTO;
import cn.axunl.exception.ErrorException;
import cn.axunl.mapper.IQuestionMapper;
import cn.axunl.model.CmQuestion;
import cn.axunl.model.CmTag;
import cn.axunl.util.PaginationUtil;
import com.baomidou.mybatisplus.core.conditions.AbstractWrapper;
import com.baomidou.mybatisplus.core.conditions.query.QueryWrapper;
import org.springframework.beans.BeanUtils;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.util.*;

@Service
public class QuestionService {
    @Autowired
    private IQuestionMapper questionMapper;
    @Autowired
    private TagService tagService;
    @Autowired
    private CommentService commentService;
    @Autowired
    private UserService userService;

    public int insert(CmQuestion question) {
        return questionMapper.insert(question);
    }

    public Map findAll(Integer page, Integer limit, String tag, String title) {
        Map map = PaginationUtil.page(page, limit);
        List<QuestionDTO> list = questionMapper.findAll((Integer) map.get("offset"),
                (Integer) map.get("limit"),
                tag,
                title);
        Long count = questionMapper.countAll(tag, title, null);
        Map hashMap = new HashMap();
        hashMap.put("count", count);
        hashMap.put("list", list);
        return hashMap;
    }

    public QuestionDTO find(Integer id) {
        questionMapper.incReadNum(id);
        AbstractWrapper queryWrapper = new QueryWrapper();
        queryWrapper.eq("question_id", id);
        CmQuestion question = questionMapper.selectOne(queryWrapper);
        return toDTO(question);
    }


    /**
     * to DTO
     *
     * @param question
     * @return
     */
    private QuestionDTO toDTO(CmQuestion question) {
        QuestionDTO questionDTO = new QuestionDTO();
        BeanUtils.copyProperties(question, questionDTO);
        Collection arrayList = Arrays.asList(questionDTO.getTag().split(","));
        List<CmTag> tags = tagService.findByBetween(arrayList);
        questionDTO.setTags(tags);
        questionDTO.setCommentNum((int) commentService.countByQuestionId(questionDTO.getQuestionId()));
        questionDTO.setUser(userService.find(questionDTO.getUserId()));
        questionDTO.setCommentList(commentService.findByQuestionId(questionDTO.getQuestionId()));
        AbstractWrapper query = new QueryWrapper();
        query.ne("question_id", questionDTO.getQuestionId());
        query.like("tag", questionDTO.getTag());
        questionDTO.setAboutQuestionList(questionMapper.selectList(query));
        return questionDTO;
    }

    public void delete(Integer id, Integer userId) {
        AbstractWrapper wrapper = new QueryWrapper();
        wrapper.eq("question_id", id);
        wrapper.eq("user_id", userId);
        if (questionMapper.delete(wrapper) <= 0) {
            throw new ErrorException("删除失败");
        }
    }

    public void edit(CmQuestion question, int userId) {
        if (questionMapper.update(question, userId) <= 0) {
            throw new ErrorException("修改失败");
        }
    }
}

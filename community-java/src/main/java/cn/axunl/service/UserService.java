package cn.axunl.service;

import cn.axunl.dto.CommentDTO;
import cn.axunl.dto.QuestionDTO;
import cn.axunl.mapper.ICommentMapper;
import cn.axunl.mapper.IQuestionMapper;
import cn.axunl.mapper.IUserMapper;
import cn.axunl.model.CmUser;
import cn.axunl.util.PaginationUtil;
import com.baomidou.mybatisplus.core.conditions.AbstractWrapper;
import com.baomidou.mybatisplus.core.conditions.query.QueryWrapper;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.util.HashMap;
import java.util.List;
import java.util.Map;

@Service
public class UserService {
    @Autowired
    private IUserMapper userMapper;
    @Autowired
    private IQuestionMapper questionMapper;
    @Autowired
    private ICommentMapper commentMapper;

    public CmUser find(Integer id) {
        AbstractWrapper queryWrapper = new QueryWrapper<>();
        queryWrapper.eq("user_id", id);
        return userMapper.selectOne(queryWrapper);
    }

    public Map getQuestion(Integer page, Integer limit, int userId) {
        Map map = PaginationUtil.page(page, limit);
        List<QuestionDTO> list = questionMapper.getQuestionByUserId((int) map.get("offset"), (int) map.get("limit"), userId);
        Long count = questionMapper.countAll(null, null, userId);
        Map hashMap = new HashMap();
        hashMap.put("count", count);
        hashMap.put("list", list);
        return hashMap;
    }

    public Long getNotReadNum(int userId) {
        return commentMapper.getNotReadNum(userId);
    }

    public List<CommentDTO> getCommentReplies(int userId) {
        return  commentMapper.getCommentReplies(userId);
    }
}

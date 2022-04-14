package cn.axunl.service;

import cn.axunl.dto.CommentDTO;
import cn.axunl.dto.ReplyDTO;
import cn.axunl.mapper.ICommentMapper;
import cn.axunl.model.CmComment;
import org.springframework.beans.BeanUtils;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.util.List;

@Service
public class CommentService {
    @Autowired
    private ICommentMapper commentMapper;

    public long countByQuestionId(Integer questionId) {
        return commentMapper.countByQuestionId(questionId);
    }

    public List<CommentDTO> findByQuestionId(Integer questionId) {
        return commentMapper.findByQuestionId(questionId);
    }

    public CmComment create(ReplyDTO replyDTO) {
        CmComment comment = new CmComment();
        BeanUtils.copyProperties(replyDTO, comment);
        commentMapper.insertGetId(comment);
        return comment;
    }

    public List<CommentDTO> findChildren(Integer commentId) {
        return commentMapper.findChildren(commentId);
    }

    public void readComment(Integer commentId, int userId) {
        commentMapper.readComment(commentId,userId);
    }
}

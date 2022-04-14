package cn.axunl.mapper;

import cn.axunl.dto.CommentDTO;
import cn.axunl.model.CmComment;
import cn.axunl.model.CmQuestion;
import com.baomidou.mybatisplus.core.mapper.BaseMapper;
import org.apache.ibatis.annotations.Param;

import java.util.List;

public interface ICommentMapper extends BaseMapper<CmComment> {
    Long countByQuestionId(@Param("questionId") Integer questionId);

    List<CommentDTO> findByQuestionId(@Param("questionId") Integer questionId);

    void insertGetId(CmComment comment);

    List<CommentDTO> findChildren(@Param("commentId") Integer commentId);

    Long getNotReadNum(@Param("userId") int userId);

    List<CommentDTO> getCommentReplies(@Param("userId") int userId);

    int readComment(@Param("commentId")Integer commentId, @Param("userId")int userId);
}

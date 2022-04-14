package cn.axunl.mapper;

import cn.axunl.dto.CommentDTO;
import cn.axunl.dto.QuestionDTO;
import cn.axunl.model.CmQuestion;
import com.baomidou.mybatisplus.core.conditions.Wrapper;
import com.baomidou.mybatisplus.core.mapper.BaseMapper;
import org.apache.ibatis.annotations.Param;

import java.util.List;

public interface IQuestionMapper extends BaseMapper<CmQuestion> {

    List<QuestionDTO> findAll(@Param("offset") Integer offset,
                              @Param("limit") Integer limit,
                              @Param("tag") String tag,
                              @Param("title") String title);

    Long countAll(@Param("tag") String tag,
                  @Param("title") String title,
                  @Param("userId") Integer userId);

    void incReadNum(@Param("questionId") Integer questionId);

    List<QuestionDTO> getQuestionByUserId(
            @Param("offset") Integer offset,
            @Param("limit") Integer limit,
            @Param("userId") int userId);


    int update(@Param("question") CmQuestion entity, @Param("userId") Integer userId);
}

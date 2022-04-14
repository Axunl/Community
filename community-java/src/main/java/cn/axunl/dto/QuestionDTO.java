package cn.axunl.dto;

import cn.axunl.model.CmQuestion;
import cn.axunl.model.CmTag;
import cn.axunl.model.CmUser;

import java.util.List;

public class QuestionDTO extends CmQuestion {
    private CmUser user;
    private Integer commentNum;
    private List<CommentDTO> commentList;
    private List<CmTag> tags;
    private List<CmQuestion> aboutQuestionList;

    public List<CmQuestion> getAboutQuestionList() {
        return aboutQuestionList;
    }

    public void setAboutQuestionList(List<CmQuestion> aboutQuestionList) {
        this.aboutQuestionList = aboutQuestionList;
    }

    public List<CommentDTO> getCommentList() {
        return commentList;
    }

    public void setCommentList(List<CommentDTO> commentList) {
        this.commentList = commentList;
    }

    public List<CmTag> getTags() {
        return tags;
    }

    public void setTags(List<CmTag> tags) {
        this.tags = tags;
    }

    public CmUser getUser() {
        return user;
    }

    public void setUser(CmUser user) {
        this.user = user;
    }

    public Integer getCommentNum() {
        return commentNum;
    }

    public void setCommentNum(Integer commentNum) {
        this.commentNum = commentNum;
    }
}

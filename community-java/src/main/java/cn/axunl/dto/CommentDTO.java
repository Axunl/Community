package cn.axunl.dto;

import cn.axunl.model.CmComment;
import cn.axunl.model.CmUser;

public class CommentDTO extends CmComment {
    private CmUser user;
    private int childrenNum;
    private CmUser replyUser;
    private String questionTitle;

    public CmUser getReplyUser() {
        return replyUser;
    }

    public void setReplyUser(CmUser replyUser) {
        this.replyUser = replyUser;
    }

    public String getQuestionTitle() {
        return questionTitle;
    }

    public void setQuestionTitle(String questionTitle) {
        this.questionTitle = questionTitle;
    }

    public CmUser getUser() {
        return user;
    }

    public void setUser(CmUser user) {
        this.user = user;
    }

    public int getChildrenNum() {
        return childrenNum;
    }

    public void setChildrenNum(int childrenNum) {
        this.childrenNum = childrenNum;
    }
}

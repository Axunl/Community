package cn.axunl.model;

import java.io.Serializable;

public class CmSet implements Serializable {
    private int setId;
    private String setUserAgree;

    public int getSetId() {
        return setId;
    }

    public void setSetId(int setId) {
        this.setId = setId;
    }

    public String getSetUserAgree() {
        return setUserAgree;
    }

    public void setSetUserAgree(String setUserAgree) {
        this.setUserAgree = setUserAgree;
    }
}

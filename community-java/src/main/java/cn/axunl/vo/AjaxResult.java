package cn.axunl.vo;

import java.util.HashMap;

/**
 * ajax返回数据
 */
public class AjaxResult extends HashMap<String, Object> {
    public static final int DEFAULT_SUCCESS_CODE = 1;
    public static final int DEFAULT_ERROR_CODE = 0;
    public static final int LOGIN_ERROR_CODE = -1;
    public static final String CODE_TAG = "code";
    public static final String MSG_TAG = "msg";
    public static final String DATA_TAG = "data";


    public AjaxResult(int code, String msg, Object data) {
        super.put(CODE_TAG, code);
        super.put(MSG_TAG, msg);
        super.put(DATA_TAG, data);
    }

    /**
     * 成功返回
     *
     * @param data
     * @return
     */
    public static AjaxResult success(Object data) {
        return new AjaxResult(DEFAULT_SUCCESS_CODE, "success", data);
    }

    /**
     * 成功返回
     *
     * @return
     */
    public static AjaxResult success() {
        return new AjaxResult(DEFAULT_SUCCESS_CODE, "success", null);
    }

    /**
     * 失败返回
     *
     * @param msg
     * @param data
     * @return
     */
    public static AjaxResult error(String msg, Object data) {
        return new AjaxResult(DEFAULT_ERROR_CODE, msg, data);
    }

    /**
     * 失败返回
     *
     * @param msg
     * @return
     */
    public static AjaxResult error(String msg) {
        return new AjaxResult(DEFAULT_ERROR_CODE, msg, null);
    }

    /**
     * 特殊失败返回
     *
     * @param code
     * @param msg
     * @return
     */
    public static AjaxResult error(int code, String msg) {
        return new AjaxResult(code, msg, null);
    }
}

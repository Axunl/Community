package cn.axunl.advice;

import cn.axunl.exception.ErrorException;
import cn.axunl.exception.LoginException;
import cn.axunl.vo.AjaxResult;
import org.springframework.web.bind.annotation.ExceptionHandler;
import org.springframework.web.bind.annotation.RestControllerAdvice;

@RestControllerAdvice
public class ExceptionHandle {
    @ExceptionHandler(ErrorException.class)
    public AjaxResult handler(ErrorException e) {
        return AjaxResult.error(e.getMessage());
    }

    @ExceptionHandler(LoginException.class)
    public AjaxResult loginHandler(LoginException e) {
        return AjaxResult.error(AjaxResult.LOGIN_ERROR_CODE, e.getMessage());
    }

    @ExceptionHandler(Exception.class)
    public AjaxResult error(Exception e) {
        return AjaxResult.error(e.getMessage());
    }
}

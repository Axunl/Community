package cn.axunl.util;

import okhttp3.*;

import java.io.IOException;
import java.util.Map;

public class HttpUtil {
    /**
     * get请求
     *
     * @param url 请求地址
     * @return
     */
    public static String get(String url) {
        OkHttpClient client = new OkHttpClient();
        Request request = new Request.Builder()
                .url(url)
                .get()
                .build();
        return getString(client, request);
    }

    /**
     * post请求
     *
     * @param url url地址
     * @param map body
     * @return
     */
    public static String post(String url, Map<String, String> map) {
        OkHttpClient client = new OkHttpClient();
        FormBody.Builder builder = new FormBody.Builder();
        if (map != null) {
            for (String key : map.keySet()) {
                builder.add(key, map.get(key));
            }
        }
        FormBody form = builder.build();
        Request request = new Request.Builder()
                .url(url)
                .post(form)//给post设置参数;
                .build();
        return getString(client, request);
    }

    /**
     * 执行请求
     *
     * @param client
     * @param request
     * @return
     */
    private static String getString(OkHttpClient client, Request request) {
        Call call = client.newCall(request);
        try {
            Response response = call.execute();//执行
            if (response.isSuccessful()) {
                String res = response.body().string();
                response.body().close();
                response.close();
                return res;
            }
        } catch (IOException e) {
            e.printStackTrace();
        }
        return null;
    }
}

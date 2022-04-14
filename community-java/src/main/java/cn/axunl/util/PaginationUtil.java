package cn.axunl.util;

import java.util.HashMap;
import java.util.Map;

public class PaginationUtil {
    public static Map page(int page, int limit) {
        int offset = (page - 1) * limit;
        HashMap hashMap = new HashMap();
        hashMap.put("offset", offset);
        hashMap.put("limit", limit);
        return hashMap;
    }
}

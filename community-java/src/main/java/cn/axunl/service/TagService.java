package cn.axunl.service;

import cn.axunl.mapper.ITagMapper;
import cn.axunl.model.CmTag;
import com.baomidou.mybatisplus.core.conditions.AbstractWrapper;
import com.baomidou.mybatisplus.core.conditions.query.QueryWrapper;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.util.Collection;
import java.util.List;

@Service
public class TagService {
    @Autowired
    private ITagMapper tagMapper;

    public List<CmTag> findAll() {
        return tagMapper.selectList(null);
    }

    public List<CmTag> findByBetween(Collection ids) {
        AbstractWrapper queryWrapper = new QueryWrapper();
        queryWrapper.in("tag_id", ids);
        return tagMapper.selectList(queryWrapper);
    }
}

import axios from 'axios'
import common from '@/common/js/common'
import store from '@/store'
// 创建axios实例
const instance = axios.create({
  // axios中请求配置有baseURL选项，表示请求URL公共部分
  baseURL: 'http://120.26.71.236:8080/',
  // 超时
  timeout: 10000
})
// request拦截器
instance.interceptors.request.use(
  config => {
    if (store.state.user.loginUser) {
      config.headers['token'] = store.getters.getUserToken
    }
    return config
  },
  error => {
    console.log(error)
    Promise.reject(error)
  }
)

// axios拦截器
instance.interceptors.response.use(res => {
  if (res.data.code == 1) {
    return res.data.data
  } else if (res.data.code == -1) {
    store.commit('setLoginUser', null)
  }
  common.toast(res.data.msg, 'error')
  return Promise.reject(res.data)
}, err => {

})

export default instance

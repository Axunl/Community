import request from '@/network/request'

export function getOauthUrl() {
  return request({
    url: 'getOauthUrl',
    method: 'get'
  })
}

export function loginOut(data) {
  return request({
    url: 'loginOut',
    data,
    method: 'post'
  })
}

import request from '@/network/request'

export function getTag() {
  return request({
    url: 'tag',
    method: 'get'
  })
}

import request from '@/network/request'

export function getUserQuestion(params) {
  return request({
    url: 'user/question',
    method: 'get',
    params
  })
}

export function getUserCommentReadNum() {
  return request({
    url: 'user/comment/notReadNum',
    method: 'get'
  })
}

export function getUserCommentReplies() {
  return request({
    url: 'user/comment/replies',
    method: 'get'
  })
}

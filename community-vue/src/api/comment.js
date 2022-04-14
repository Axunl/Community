import request from '@/network/request'

export function createComment(data) {
  return request({
    url: 'comment',
    method: 'post',
    data
  })
}

export function getCommentChildren(commentId) {
  return request({
    url: `comment/${commentId}`,
    method: 'get'
  })
}

export function readComment(commentId) {
  return request({
    url: `comment/read/${commentId}`,
    method: 'put'
  })
}

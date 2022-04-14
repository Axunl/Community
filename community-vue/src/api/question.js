import request from '@/network/request'

export function createQuestion(data) {
  return request({
    url: 'question',
    method: 'post',
    data
  })
}

export function getQuestion(params) {
  return request({
    url: 'question',
    method: 'get',
    params
  })
}

export function getQuestionById(id) {
  return request({
    url: `question/${id}`,
    method: 'get',
  })
}

export function deleteQuestion(id) {
  return request({
    url: `question/${id}`,
    method: 'delete',
  })
}

export function editQuestion(id, data) {
  return request({
    url: `question/${id}`,
    method: 'put',
    data
  })
}

/* 公共js */
import {Notification, MessageBox, Message} from 'element-ui'
import store from '@/store/index'

export default {
  toast(message = '', type = 'success', duration = 5 * 1000) {
    Message({
      message,
      type,
      duration
    })
  },
  isLogin() {
    if (store.getters.isLogin) {
      this.toast('请先登录', 'error')
    } else {
      return true;
    }
  },
  dateFormat() {
    let date = new Date();
    let month = date.getMonth() + 1;
    let strDate = date.getDate();
    if (month >= 1 && month <= 9) {
      month = "0" + month;
    }
    if (strDate >= 0 && strDate <= 9) {
      strDate = "0" + strDate;
    }
    var currentDate = date.getFullYear() + "-" + month + "-" + strDate
      + " " + date.getHours() + ":" + date.getMinutes() + ":" + date.getSeconds();
    return currentDate;
  }
}

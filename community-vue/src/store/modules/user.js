import {getOauthUrl, loginOut} from '@/api/login'
import common from "@/common/js/common";

const user = {
  state: {
    loginUser: null
  },
  mutations: {
    setLoginUser(state, loginUser) {
      state.loginUser = loginUser
    },
    decNotReadNum(state) {
      state.loginUser.notReadNum--
    }
  },
  getters: {
    getUserToken: (state) => {
      return state.loginUser.userToken
    },
    isLogin: (state) => {
      return state.loginUser === null
    },
    getLoginUser: (state) => {
      return state.loginUser
    }
  },
  actions: {
    GetOauthUrl() {
      return getOauthUrl()
    },
    LoginOut(data) {
      return loginOut(data);
    }
  }
}
export default user

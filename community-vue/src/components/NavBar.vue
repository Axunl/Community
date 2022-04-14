<template>
  <div class="nav flex fl-ai-center fl-jc-space-between fl-wrap">

    <div class="flex fl-ai-center">
      <el-link href="/dist" class="mgr10 mdis">码问</el-link>
      <el-input placeholder="请输入内容"
                v-model="input"
                clearable class="search mgl10"
      >
      </el-input>
      <el-button type="primary" class="mgl10" @click="search">搜索</el-button>
    </div>
    <div class="index">
      <el-link href="/dist" class="mgr10">首页</el-link>
    </div>
    <div class="login">
      <div class="flex fl-ai-center" v-if="$store.state.user.loginUser">
        <el-link type="primary" class="mgr10" @click="toPublish()">提问</el-link>
        <div class="flex fl-ai-center">
          <el-link @click="toReplies()">
            通知
          </el-link>
          <div class="circle">{{$store.state.user.loginUser.notReadNum}}</div>
        </div>
        <el-dropdown @command="drop" class="mgl10">
  <span class="el-dropdown-link">
    {{$store.state.user.loginUser.userName}}
    <i class="el-icon-arrow-down el-icon--right"></i>
  </span>
          <el-dropdown-menu slot="dropdown">
            <el-dropdown-item command="questions">我的问题</el-dropdown-item>
            <el-dropdown-item command="logout" divided>退出登录</el-dropdown-item>
          </el-dropdown-menu>
        </el-dropdown>
      </div>
      <div v-else class="flex">
        <el-link type="primary" class="mgr10" @click="login()">登录</el-link>
      </div>
    </div>

  </div>

</template>

<script>
  import {getUserCommentReadNum} from '@/api/user'

  export default {
    name: "NavBar",
    data() {
      return {
        input: ''
      }
    },
    created() {
      if (this.$store.state.user.loginUser) {
        //获取未读数
        getUserCommentReadNum().then(res => {
          let user = this.$store.getters.getLoginUser
          user.notReadNum = res
          this.$store.commit('setLoginUser', user)
          this.$forceUpdate()
        })
      }
    },
    methods: {
      toPublish() {
        this.$router.push("/publish")
      },
      toQuestions() {
        this.$router.push("/profile/questions")
      },
      toReplies() {
        this.$router.push("/profile/replies")
      },
      drop(e) {
        switch (e) {
          case 'questions':
            this.toQuestions()
            break;
          case  'logout':
            let token = this.$store.state.user.loginUser.userToken
            this.$store.dispatch('LoginOut', this.$qs.stringify({
              token
            })).then(res => {
              this.$store.commit('setLoginUser', null)
              //销毁cookie
              this.$cookies.remove('loginUser')
              //重置
              this.$router.replace('/')
            })
            break
        }
      },
      login() {
        this.$store.dispatch('GetOauthUrl').then(res => {
          // 存取cookie
          location.href = res
        })
      },
      search() {
        if (!this.input) {
          this.common.toast('请输入内容', 'error')
          return
        }
        location.href = "http://" + document.domain + ":" + location.port + "?search=" + this.input
      }
    },
  }
</script>

<style scoped>
  .nav {
    background-color: #fcfcfc;
    height: 50px;
    padding: 0 30px;
    box-shadow: 0 0 2px #888888;
  }

  .search {
    width: 200px;
  }

  .mdis {
    display: block;
  }

  .index {
    display: none;
  }

  @media only screen and (max-width: 500px) {
    .nav {
      /*display: none;*/
      height: 70px;
      justify-content: flex-end;
    }

    .mdis {
      display: none;
    }

    .index {
      display: flex;
    }

    .login {
      display: flex;
      align-items: center;
    }
  }
</style>

<template>
  <div>
    <el-row :gutter="60">
      <el-col :xs="24" :sm="24" :md="24" :lg="18" :xl="18">
        <div class="mgb10">{{question.questionTitle}}</div>
        <div class="gray mgb10">
          作者：{{question.user.userName}} | 发布时间：{{question.createTime}} | 阅读数： {{question.readNum}}
        </div>
        <div class="mgb10" v-html="question.questionDescription">

        </div>
        <div class="flex line fl-ai-center">
          <div class="mgr10">标签:</div>
          <el-tag v-for="item in question.tags"
                  class="mgr10 pointer"
                  effect="dark"
                  @click="search(item)"
          >
            {{item.tagName}}
          </el-tag>
        </div>
        <div class="line">{{question.commentNum}}个回复</div>

        <div class="flex mgt10 mgb10" v-for="(item,index) in question.commentList"
             :key="index">
          <div>
            <el-avatar shape="square" :src="item.user.userAvatarUrl"
                       class="mgr10"></el-avatar>
          </div>
          <div class="fl-one">
            <div>{{item.user.userName}}</div>
            <div class="flex fl-jc-space-between">
              <div>{{item.commentContent}}</div>
              <div class="gray">{{item.createTime}}</div>
            </div>
            <div class="flex fl-ai-center" @click="showChildren(item)">
              <div class="pointer flex fl-ai-center">
                <i class="el-icon-chat-square"></i>
                <div>{{item.childrenNum}}</div>
              </div>
            </div>
            <div>

              <div v-if="item.isHide" class="mgt10 children">
                <div class="line flex fl-ai-center" v-for="it in item.childrenList">
                  <el-avatar shape="square" :src="it.user.userAvatarUrl"
                             class="mgr10"></el-avatar>

                  <div class="fl-one">
                    <div>{{it.user.userName}}</div>
                    <div class="flex fl-jc-space-between">
                      <div>{{it.commentContent}}</div>
                      <div class="gray">{{it.createTime}}</div>
                    </div>
                  </div>
                </div>
                <div class="line">
                  <el-input v-model="item.input" placeholder="评论一下..."
                            @input="change($event)"
                  ></el-input>
                  <el-button type="success" class="float-right mgt10" @click="commentReply(item)">评论</el-button>
                </div>
              </div>


            </div>
          </div>
        </div>

        <div class="line mgb10">提交回复</div>
        <div>
          <div class="flex fl-ai-center mgb10">
            <el-avatar shape="square"
                       :src="this.$store.state.user.loginUser?this.$store.state.user.loginUser.userAvatarUrl:defaultImg"></el-avatar>
            <div class="mgl10">
              {{this.$store.state.user.loginUser?this.$store.state.user.loginUser.userName:'匿名游客'}}
            </div>
          </div>
          <el-input
            type="textarea"
            rows="10"
            placeholder="请输入内容"
            v-model="textarea">
          </el-input>
          <el-button type="success" class="mgt10 float-right" @click="reply">回复</el-button>
        </div>
      </el-col>
      <el-col :xs="24" :sm="24" :md="24" :lg="6" :xl="6">
        <div class="line">发起人</div>
        <el-avatar shape="square"
                   :src="question.user.userAvatarUrl"
                   class="mgr10 mgt10 mgb10"></el-avatar>
        <div class="mgb10">相关问题</div>
        <div v-for="item in question.aboutQuestionList" @click="toQuestion(item)">
          <el-link type="primary">
            {{item.questionTitle}}
          </el-link>
        </div>
      </el-col>
    </el-row>


  </div>
</template>

<script>
  import {getQuestionById} from '@/api/question'
  import defaultImg from '@/assets/default-avatar.png'
  import {createComment, getCommentChildren} from '@/api/comment'

  export default {
    name: "Question",
    data() {
      return {
        defaultImg,
        questionId: null,
        textarea: '',
        question: {
          questionTitle: '',
          createTime: '',
          readNum: 0,
          commentNum: 0,
          questionDescription: '',
          user: {
            userName: '',
            userAvatarUrl: ''
          },
          tags: [],
          commentList: [],
          aboutQuestionList: []
        }
      }
    },
    created() {
      const params = this.$route.params
      this.questionId = params.id
      getQuestionById(this.questionId).then(res => {
        document.title = res.questionTitle
        this.question = res
        this.addChildren(this.question)
      })
    },
    methods: {
      reply() {
        if (!this.textarea) {
          this.common.toast("请输入内容", 'error')
          return;
        }
        if (this.common.isLogin()) {
          let question = this.question
          let textarea = this.textarea
          let reply = this.createReplyDTO(
            0, question.questionId, 0, textarea, 'comment'
          )
          let user = this.$store.state.user.loginUser
          createComment(this.$qs.stringify(reply)).then(res => {
            res.likeNum = 0
            res.createTime = this.common.dateFormat()
            res.childrenNum = 0
            res.user = user
            this.question.commentNum++
            this.question.commentList.push(res)
            this.addChildren(this.question)
            this.common.toast('回复成功')
          })
        }
      },
      createReplyDTO(parentId, questionId, userId, commentContent, method) {
        return {
          parentId,
          questionId,
          userId,
          commentContent,
          method
        }
      },
      showChildren(e) {
        e.isHide = !e.isHide
        if (!e.isGet) {
          getCommentChildren(e.commentId).then(res => {
            e.childrenList = (res)
            e.isGet = true
            this.$forceUpdate()//强制渲染
          })
        }
        this.$forceUpdate()//强制渲染
      },
      //为commentList加工
      addChildren(e) {
        e.commentList.forEach((i, v) => {
          //v是下标
          if (!i.input) {
            i.input = ''
            i.isHide = false
            i.isGet = false
            i.childrenList = []
          }
        })
      },
      commentReply(e) {
        let reply = this.createReplyDTO(
          e.commentId, e.questionId, e.userId, e.input, 'reply'
        )
        createComment(this.$qs.stringify(reply)).then(res => {
          this.common.toast('评论成功')
          reply.createTime = this.common.dateFormat()
          reply.user = this.$store.state.user.loginUser
          e.childrenList.push(reply)
          e.childrenNum = e.childrenList.length
          e.input = ''
          this.$forceUpdate()//强制渲染
        })
      },
      change(e) {
        this.$forceUpdate()//强制渲染
      },
      search(e) {
        this.$router.push({
          path: '/',
          params: {
            tag: e.tagId
          }
        })
      },
      toQuestion(e) {
        this.$router.replace(`/question/${e.questionId}`)
        this.$router.go(0)
      }

    }
  }
</script>

<style scoped>
  .children {
    padding: 10px;
    border: 1px solid #f4f4f4;
    border-radius: 10px;
    overflow: hidden;
  }
</style>

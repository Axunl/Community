<template>
  <div>
    <Template title="最新通知" selected="replies" :repliesNum="$store.state.user.loginUser.notReadNum">
      <div class="flex fl-ai-center line" v-for="item in commentList">
        <div class="mgr10">{{item.replyUser.userName}}</div>
        回复了
        <el-link type="primary" class="mgr10" @click="toQuestion(item)">{{item.questionTitle}}</el-link>
        内容为:
        <div class="mgr10">{{item.commentContent}}</div>
        <el-button type="danger" size="mini" v-if="!item.isRead">未读</el-button>
      </div>
    </Template>
  </div>
</template>

<script>
  import Template from "@/components/Profile/Template";
  import {getUserCommentReplies} from "@/api/user"
  import {readComment} from "@/api/comment"

  export default {
    name: "Replies",
    components: {
      Template
    },
    created() {
      getUserCommentReplies().then(res => {
        this.commentList = res
      })
    },
    data() {
      return {
        commentList: []
      }
    },
    methods: {
      toQuestion(e) {
        if (e.isRead == 0) {
          readComment(e.commentId).then(res => {
            e.isRead = 1
            this.$store.commit("decNotReadNum")
            this.$router.push(`/question/${e.questionId}`)
          })
        } else {
          this.$router.push(`/question/${e.questionId}`)
        }
      }
    }
  }
</script>

<style scoped>

</style>

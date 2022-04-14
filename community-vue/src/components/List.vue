<template>
  <div>
    <div v-for="item in list" class="mgb10">
      <div class="flex">
        <div class="mgr10">
          <el-avatar shape="square"
                     :src="item.user.userAvatarUrl"></el-avatar>
        </div>
        <div>
          <el-link type="primary" @click="toQuestion(item)">{{item.questionTitle}}</el-link>
          <div class="gray">{{item.commentNum}} 个回复 • {{item.readNum}} 次浏览 • {{item.createTime}}</div>
        </div>
      </div>
      <div class="flex" v-if="$store.state.user.loginUser&&item.userId==$store.state.user.loginUser.userId">
        <el-link type="success" class="mgr10" @click="toEditQuestion(item)">编辑</el-link>
        <el-link type="danger" @click="deleteQuestion(item)">删除</el-link>
      </div>
    </div>
  </div>
</template>

<script>
  import {deleteQuestion} from '@/api/question'

  export default {
    name: "List",
    props: {
      list: {
        type: Array,
        default: () => {
        }
      }
    },
    methods: {
      toQuestion(e) {
        console.log(e);
        this.$router.push(`/question/${e.questionId}`)
      },
      deleteQuestion(e) {
        if (confirm("确定要删除吗?")) {
          deleteQuestion(e.questionId).then(res => {
            this.common.toast("删除成功")
            location.reload()
          })
        }
      },
      toEditQuestion(e) {
        this.$router.push({
          path: `/question/edit/${e.questionId}`,
          query: e
        })
      }
    }
  }
</script>

<style scoped>

</style>

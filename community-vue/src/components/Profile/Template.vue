<template>
  <div>
    <el-row :gutter="60">
      <el-col :xs="24" :sm="24" :md="24" :lg="18" :xl="18">
        <div class="line">{{title}}</div>
        <slot></slot>
      </el-col>
      <el-col :xs="24" :sm="24" :md="24" :lg="6" :xl="6">
        <div class="box">
          <div :class="selected=='questions'?'selected':''" @click="toQuestions()">我的问题</div>
          <div class="fl-jc-space-between" :class="selected=='replies'?'selected':''" @click="toReplies()">
            <div>最新回复</div>
            <div class="circle" v-if="repliesNum>0">{{repliesNum}}</div>
          </div>
        </div>
      </el-col>
    </el-row>
  </div>
</template>

<script>
  export default {
    name: "Template",
    components: {},
    props: {
      title: '',
      selected: '',
      repliesNum: 0
    },
    methods: {
      toQuestions() {
        this.$router.replace('/profile/questions')
      },
      toReplies() {
        this.$router.replace('/profile/replies')
      }
    }
  }
</script>

<style scoped>
  .box {
    margin-top: 15px;
    border: 1px solid #e8e8e8;
    border-radius: 4px;
    overflow: hidden;
  }

  .box > div {
    padding: 10px;
    height: 30px;
    display: flex;
    align-items: center;
    cursor: pointer;
  }

  .box > div:not(.selected):hover {
    background: #f4f4f4;
  }

  .selected {
    background-color: #2f71aa;
    color: white;
  }

</style>

<template>
  <div>
    <el-row :gutter="60">
      <el-col :xs="24" :sm="24" :md="24" :lg="18" :xl="18">
        <div class="mgb10">
          <i class="el-icon-s-unfold mgr10"></i>发现
        </div>
        <Question-List :list="questions.list"></Question-List>
        <div class="block mgt10">
          <Pagination :total="questions.count" @current-change="change"></Pagination>
        </div>
      </el-col>
      <el-col :xs="24" :sm="24" :md="24" :lg="6" :xl="6">
        <div class="mgb10">热门标签</div>
        <el-tag v-for="item in tags" class="mgr10 pointer" @click="changeTag(item)"> {{item.tagName}}</el-tag>
      </el-col>
    </el-row>
  </div>

</template>

<script>
  import Pagination from "@/components/Pagination";
  import QuestionList from "@/components/List";
  import {getQuestion} from '@/api/question'
  import {getTag} from "@/api/tag";

  export default {
    name: "List",
    components: {
      Pagination, QuestionList
    },
    data() {
      return {
        questions: {},
        tags: {},
        search: {
          title: '',
          tag: ''
        }
      }
    },
    created() {
      let query = this.$route.query
      if(query.search){
        this.search = {
          title: query.search,
          tag: null
        }
      }
      else{
        this.search = {
          title: null,
          tag: query.tag
        }
      }

      this.getQuestions()
      getTag().then(res => {
        this.tags = res
      })
    },
    methods: {
      getQuestions(page = 1) {
        let tag = this.search.tag
        let title = this.search.title
        return getQuestion({page, tag, title}).then(res => {
          this.questions = res
        })
      },
      change(e) {
        this.getQuestions(e)
      },
      changeTag(item) {
        this.search = {
          title: null,
          tag: item.tagId
        }
        this.getQuestions()
      }
    }
  }
</script>

<style scoped>

</style>

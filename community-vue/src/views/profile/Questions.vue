<template>
  <div>
    <Template title="我的问题" selected="questions">
      <List :list="questions.list"></List>
      <div class="block mgt10">
        <Pagination :total="questions.count" @current-change="change"></Pagination>
      </div>
    </Template>
  </div>
</template>

<script>
  import Template from "@/components/Profile/Template";
  import List from "@/components/List";
  import {getUserQuestion} from "@/api/user"
  import Pagination from "@/components/Pagination";

  export default {
    name: "Questions",
    components: {
      Template, List, Pagination
    },
    data() {
      return {
        questions: {}
      }
    },
    created() {
      this.getUserQuestions().then(res => {
        this.questions = res
      })
    },
    methods: {
      getUserQuestions(page = 1) {
        return getUserQuestion({
          page
        });
      },
      change(e) {
        this.getQuestions(e)
      },
    }
  }
</script>

<style scoped>

</style>

<template>
  <Pub title="修改"
       :question="question"
       subTitle="修改"
       @sub="sub"
  ></Pub>
</template>

<script>
  import Pub from "@/components/PETemplate";
  import {editQuestion} from "@/api/question"

  export default {
    name: "Edit",
    components: {
      Pub
    },
    created() {
      let query = this.$route.query
      this.questionId = query.questionId
      this.question.questionId = query.questionId
      this.question.title = query.questionTitle
      this.question.content = query.questionDescription
      this.question.tags = query.tag.split(',')
    },
    data() {
      return {
        questionId: '',
        question: {
          title: '',
          content: '',
          tags: []
        }
      }
    },
    methods: {
      sub(e) {
        editQuestion(this.questionId, e).then(res => {
          this.common.toast('修改成功')
        })
      }
    }
  }
</script>

<style scoped>

</style>

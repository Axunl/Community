<template>
  <Pub title="发起" :question="question" subTitle="发布" @sub="sub"></Pub>
</template>

<script>
  import Pub from "@/components/PETemplate";
  import {createQuestion} from "@/api/question";

  export default {
    name: "Publish",
    components: {
      Pub
    },
    data() {
      return {
        question: {
          title: '',
          content: '',
          tags: []
        }
      }
    },
    methods: {
      sub(e) {
        createQuestion(e).then(res => {
          this.common.toast("发布成功")
          setTimeout(() => {
            this.$router.replace('/')
          }, 1000)
        })
      }
    }
  }
</script>

<style scoped>

</style>

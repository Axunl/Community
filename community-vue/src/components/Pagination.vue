<template>
  <el-pagination
    background
    layout="prev, pager, next"
    :total="total"
    @current-change="change">
  </el-pagination>
</template>

<script>
  export default {
    name: "Pagination",
    props: {
      total: 0
    },
    methods: {
      change(e) {
        this.$emit("current-change", e);
      }
    }
  }
</script>

<style scoped>

</style>

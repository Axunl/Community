<template>
  <div>
    <el-row :gutter="60">
      <el-col :xs="24" :sm="24" :md="24" :lg="18" :xl="18">
        <div class="mgb10">
          <i class="el-icon-plus mgr10"></i>{{title}}
        </div>
        <el-input
          placeholder="请输入标题"
          v-model="question.title"
          clearable
          class="mgb10"
          maxlength="25"

        >
        </el-input>
        <quill-editor
          v-model="question.content" class="mgb10"
          :options="editorOption">
        </quill-editor>
        <!--        <el-input-->
        <!--          type="textarea"-->
        <!--          :rows="20"-->
        <!--          placeholder="请输入内容"-->
        <!--          v-model="question.content"-->
        <!--          class="mgb10"-->
        <!--        >-->
        <!--        </el-input>-->

        <div>
          <el-button type="primary" round v-for="item in question.tags" class="mgb10" @click="closeTag(item)">
            {{item.tagName}} x
          </el-button>
        </div>
        <div class="flex fl-ai-center">
          <span class="mgr10 gray">请选择标签:</span>
          <el-button type="primary" round v-for="item in tags" @click="addTag(item)">
            {{item.tagName}}
          </el-button>
        </div>
        <div>
          <el-button type="success" class="mgt10 float-right" @click="sub">{{subTitle}}</el-button>
        </div>
      </el-col>
      <el-col :xs="24" :sm="24" :md="24" :lg="6" :xl="6">
        <div class="mgb10">问题发起指南</div>
        <div class="gray">
          <div class="mgb10">• 问题标题: 请用精简的语言描述您发布的问题，不超过25字</div>
          <div class="mgb10">• 问题补充: 详细补充您的问题内容，并确保问题描述清晰直观, 并提供一些相关的资料</div>
          <div class="mgb10">• 选择标签: 选择一个或者多个合适的标签</div>
        </div>
      </el-col>
    </el-row>
  </div>
</template>

<script>
  import {getTag} from "@/api/tag";
  import {quillEditor} from "vue-quill-editor"; //调用编辑器
  import 'quill/dist/quill.core.css';
  import 'quill/dist/quill.snow.css';
  import 'quill/dist/quill.bubble.css';
  import * as Quill from 'quill' //引入编辑器
  import {ImageDrop} from 'quill-image-drop-module';

  Quill.register('modules/imageDrop', ImageDrop);
  export default {
    name: "PETemplate",
    components: {quillEditor},
    data() {
      return {
        tags: [],
        editorOption: { //  富文本编辑器配置
          theme: 'snow',
          placeholder: '请输入内容'
        },
      }
    },
    props: {
      title: '',
      question: {
        title: '',
        content: '',
        tags: []
      },
      subTitle: ''
    },
    created() {
      getTag().then(res => {
        this.tags = res
        if (this.question.tags) {
          this.changeTag(this.question.tags, this.tags)
        }
      })
    },
    methods: {
      addTag(e) {
        for (let i of this.question.tags) {
          if (e.tagId == i.tagId) {
            return;
          }
        }
        this.question.tags.push({
          tagId: e.tagId,
          tagName: e.tagName
        })
      },
      closeTag(e) {
        this.question.tags.forEach((i, v) => {
          // v是索引
          if (e.tagId == i.tagId) {
            this.question.tags.splice(v, 1)
            return;
          }
        })
      },
      sub() {
        let question = this.question
        if (!question.title) {
          this.common.toast('请输入标题', 'error')
          return;
        }
        if (!question.content) {
          this.common.toast('请输入内容', 'error')
          return;
        }
        if (question.tags.length <= 0) {
          this.common.toast('请输入标签', 'error')
          return;
        }
        let tags = [];
        question.tags.forEach((i, v) => {
          // v是索引
          tags.push(i.tagId)
        })
        this.$emit('sub', this.$qs.stringify({
          questionId: this.question.questionId ? this.question.questionId : 0,
          questionTitle: question.title,
          questionDescription: question.content,
          tag: tags.sort().join(',')
        }))
      }
      , changeTag(e, v) {
        let temp = []
        for (let i of e) {
          v.forEach((x, y) => {
            if (x.tagId == i) {
              temp.push(x)
            }
          })
        }
        this.question.tags = temp
      }
    }
  }
</script>

<style scoped>

</style>

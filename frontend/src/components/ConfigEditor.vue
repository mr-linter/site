<template>
  <div class="config-editor">
    <div class="title">
      JSON Config Editor
    </div>
    <div class="edit-form">
      <textarea class="config-editor-textarea" v-model="lint_config"></textarea>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    lint_config: String,
  }
}
</script>

<style>
.config-editor {
  box-sizing: border-box;
  border: 1px solid #ccc;
  height: 100%;
  background: #fff;
  margin: 0;
}

.config-editor .edit-form {
  height: 100%;
  box-sizing: border-box;
  margin: 0;
  padding: 0;
}

.config-editor-textarea {
  border: none;
  width: 100%;
  resize: none;
  margin: 0;
  padding: 5px;
  height: 250px;
  box-sizing: border-box;
  overflow: auto;
  outline: 0 none;
  color: #666;
}

.config-editor .title {
  padding: 15px;
  border-bottom: 1px solid #ccc;
  font-size: 14pt;
}
</style>

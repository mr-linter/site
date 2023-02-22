<template>
  <div class="card" style="border-radius: 0">
    <h5 class="card-header">Validation failed</h5>
    <div class="card-body">
      <b-table head-variant="error" striped hover :items="preparedErrors"></b-table>
    </div>
  </div>
</template>

<script>
export default {
  computed: {
    preparedErrors() {
      let errors = [];

      for (let name in this.fails) {
        let fail = this.fails[name]

        for (let i in fail) {
          errors.push({'error': fail[i]})
        }
      }

      return errors
    },
  },
  props: {
    fails: Object,
  }
}
</script>

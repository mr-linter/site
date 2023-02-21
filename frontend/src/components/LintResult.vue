<template>
  <div class="card" style="border-radius: 0">
    <h5 class="card-header">Result</h5>
    <div class="card-body">
      <b-alert v-if="this.result.notes.length > 0" show variant="danger">
        Notes: {{ this.result.notes.length }}
      </b-alert>

      <b-alert v-if="this.result.notes.length === 0" show variant="success">
        No notes
      </b-alert>

      <b-table striped hover :items="result.notes" v-if="result.notes.length > 0"></b-table>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    result: {
      state: Boolean(),
      notes: []
    }
  }
}
</script>

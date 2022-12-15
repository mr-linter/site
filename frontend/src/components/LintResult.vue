<template>
  <div class="card" style="border-radius: 0">
    <h5 class="card-header">Result</h5>
    <div class="card-body">
      <b-table striped hover :items="result.notes"></b-table>
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

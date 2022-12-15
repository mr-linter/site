<template>
  <tester></tester>
</template>

<script>
import Tester from '../components/Tester'
export default {
  components: {Tester},
  data: () => {
    return {
      lintResult: {}
    }
  }
}
</script>

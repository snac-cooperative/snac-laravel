<template>
  <tr><td>{{text}}</td></tr>
</template>

<script>
export default {
  props: ['text', 'id'],
  methods: {
    mounted(){
      console.log('Component mounted!');
    }
  }
}
</script>

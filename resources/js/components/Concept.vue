<template>
    <table id="concept-table" className="table">
        <thead>
            <tr>
                <th>Concept</th>
            </tr>
        </thead>
        <tbody>
          <term v-for="term in concept.terms" v-bind:text="term.text" v-bind:key="term.id"></term>
        </tbody>
    </table>
</template>

<script>
Vue.component('term', require('./Term.vue').default);
export default {
  props: ['concept'],
  methods: {
    mounted(){
      console.log('Component mounted!');
    }
  }
}
</script>

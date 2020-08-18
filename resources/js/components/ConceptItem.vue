    <template>
        <div id="concept-table" className="">
            <div v-bind:key="term.id" v-for="term in this.terms">
                <h2 v-if="term.preferred">{{term.text}}</h2>
            </div>
            <!-- <h2>{{ preferredTerm.text }}</h2> -->
            <ul>
                <table>

                <tr v-bind:key="term.id" v-for="term in terms">
                    <td v-if="!term.preferred">{{term.text}}</td>
                    <td v-if="!term.preferred"><button @click="makeTermPreferred(term)"> Make Preferred</button></td>
                    <td>{{count}}</td>
                </tr>
            </table>
            </ul>
        </div>
    </template>

<script>
export default {
  props: {
      terms: {
          type: Array
      },
      count: {
          type: String
      }
  },
  data() {
      return {

          term: {
              id: '',
              text: '',
              preferred: ''
          }
      };
  },
  computed: {
      alternateTerms: function() {
          return this.terms.filter(term => !term.preferred)
      },
      preferredTerm:  function() {
          return this.terms.find(term => term.preferred)
      }
  },
  created() {
      console.log("Concept component loaded");
      // this.fetchConcept()
  },
  methods: {
      fetchConcept() {
          fetch('/api/concepts/2')
            .then(data => data.json())
            .then(data => {
                console.log("here you are: ", data)
                this.terms = data.terms
            })
      },
      makeTermPreferred: function(term) {
          console.log(`${term.text} is preferred!`, term);
          this.preferredTerm.preferred = false;
          term.preferred = true;
          this.terms.push('hi')
          this.count = (this.count + 1) % term.length
      }
  }
}
</script>

<style scoped>
</style>

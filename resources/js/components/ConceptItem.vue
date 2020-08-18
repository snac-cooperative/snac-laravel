<template>
    <div id="concept-table" classname="">
        <h2>{{ preferredTerm.text}}</h2>
        <table>
            <tr v-bind:key="term.id" v-for="term in alternateTerms">
                <td>{{term.text}}</td>
                <td>
                    <button @click="makeTermPreferred(term)">Make Preferred</button>
                </td>
                <td>{{count}}</td>
            </tr>
        </table>
    </div>
</template>

<script>
    export default {
        props: {
            terms: {
                type: Array
            }
        },
        data() {
            return {terms: this.terms.slice(), count: 0};
        },
        computed: {
            alternateTerms() {
                return this.terms.filter(term => !term.preferred).sort()
            },
            preferredTerm() {
                return this.terms.find(term => term.preferred)
            }
        },
        created() {
            console.log("Concept component loaded");
            // this.fetchConcept()
        },
        methods: {
            fetchConcept() {
                fetch('/api/concepts/2').then(data => data.json()).then(data => {
                    console.log("here you are: ", data)
                    this.terms = data.terms
                })
            },
            makeTermPreferred: function (term) {
                console.log(`${term.text} is preferred!`, term);
                if (!confirm(`Are you sure you want to make '${term.text}' the preferred term for this concept?`)) {
                    return;
                }
                this.preferredTerm.preferred = false;
                term.preferred = true;
                this.count += 1
            }
        }
    }
</script>

<style scoped="scoped"></style>

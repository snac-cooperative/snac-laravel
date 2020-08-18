<template>
    <div id="concept-table" classname="">
        <div class="form-group">
            <div class="col-xs-8">

                <h2>{{ preferredTerm.text}}</h2>
                <p type="text" class="term form-control" readonly> {{preferredTerm.text}}</p>
                <table>
                    <div v-bind:key="term.id" v-for="term in alternateTerms">
                        <div class="input-group">
                            <p type="text" class="form-control"> {{term.text}}</p>
                            <span class="input-group-btn">
                                <button @click="editTerm(term).prevent" class="btn btn-primary" title="Make Preferred"><i class="fa fa-edit"></i></button>
                                <button @click="makeTermPreferred(term).prevent" class="btn btn-info" title="Make Preferred"><i class="fa fa-check-square-o"></i></button>
                                <button @click="deleteTerm(term).prevent" class="btn btn-danger" title="Delete"><i class="fa fa-trash"></i></button>
                            </span>
                            {{count}}
                        </div>
                </div>
                </table>
                <button @click.prevent="fetchConcept()" class="btn btn-primary">Fetch</button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            termProps: {
                type: Array
            }
        },
        data() {
            return {terms: this.termProps.slice(), count: 0};
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

        },
        methods: {
            fetchConcept() {
                fetch('/api/concepts/2').then(data => data.json()).then(data => {
                    console.log("here you are: ", data)
                    this.terms = data.terms
                })
            },
            makeTermPreferred: function(term) {
                console.log(`${term.text} is preferred!`, term);
                if (!confirm(`Are you sure you want to make '${term.text}' the preferred term for this concept?`)) {
                    return;
                }
                this.preferredTerm.preferred = false;
                term.preferred = true;
                this.count += 1
            },
            deleteTerm: function(term){
                console.log(`Deleting ${term.text} with id ${term.id}`)
            },
            editTerm: function(term){
                console.log(`Editing ${term.text} with id ${term.id}`)
                term.inEdit = true
            }
        }
    }
</script>

<style scoped="scoped">
    .form-control {
        min-width: 500px;
    }

    /* Find why input */
    .input-group-btn button {
        margin-top: -4px;
    }
</style>

<template>
    <div>
        <form
            id="concept-relationship-form"
            @submit.stop.prevent="searchConcept()">
            <div class="form-group">
                <label for="relation-search">Concept</label>
                <div class="input-group mb-3">
                    <input id="relation-search" ref="searchQuery" type="text" class="form-control" placeholder="Concept" aria-label="Related Concept">
                    <div class="input-group-append">
                        <button class="btn btn-info" type="button" @click="searchConcept()">Search</button>
                    </div>
                </div>
            </div>
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="is-preferred" v-model="allTermsSearch" title="Search only Preferred Terms">
                <label class="form-check-label" for="is-preferred" >Search non-preferred terms</label>
            </div>

            <div class="">
                <table class="table table-hover mt-3" v-if="termSearch.length">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Term</th>
                            <th>Category</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr :key="term.term_id" v-for="(term) in termSearch">
                            <!-- <td><input type="radio" name="relation-choice" :value="term.concept_id" v-model="selected_concept"></td> -->
                            <td></td>
                            <td> <a :href="term.concept_id">{{ term.term }}</a></td>
                            <td>{{ term.category }}</td>
                            <!-- <td>{{ term.preferred }}</td> -->
                            <!-- TODO: Handle multiple categories by conjoining.  -->
                            <!-- TODO: Display result count.  -->
                        </tr>
                    </tbody>
                </table>
            </div>
        </form>
    </div>
</template>


<script>
export default {
    data() {
        return {
            termSearch: [],
            allTermsSearch: false,
        }
    },
    methods: {
        searchConcept: function() {
            let vm = this;
            var query = this.$refs.searchQuery.value  // Is there a better way to do this?
            if (this.allTermsSearch) {
                query += "&all_terms"
            }

            const promise = axios.get(`search?term=${query}`)
                promise.then(response => {
                let terms = response.data;
                let terms_result = terms.map(term => {
                    return {
                        id: term.term_id,
                        concept_id: term.concept_id,
                        term: term.text,
                        category: term.category,
                        preferred: term.preferred
                    };
                });
                this.totalRows = response.data.total;
                this.termSearch = terms_result || [];
            });
        },

    }
}
</script>

<style scoped>

</style>

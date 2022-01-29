<template>
    <div id="concept-table" classname="">
        <div class="form-group">
            <div class="mt-3">
                <h4>Concept Category</h4>
                <b-col cols="4">
                    <b-form-select v-model="selectedCategory" :options="categories"></b-form-select>
                </b-col>
            </div>
        </div>
    </div>
</template>

<script>
// import TermItem from './TermItem.vue';
    export default {
        props: {
            categoriesProps: {
                type: Array
            }

        },
        data() {
            return {
                categories: [
                    { value:  process.env.MIX_ETHNICITY_ID, text: 'Ethnicity'},
                    { value:  process.env.MIX_OCCUPATION_ID, text: 'Occupation'},
                    { value:  process.env.MIX_ACTIVITY_ID, text: 'Activity'},
                    { value:  process.env.MIX_SUBJECT_ID, text: 'Subject'},
                    { value:  process.env.MIX_RELIGION_ID, text: 'Religion'},
                    { value:  process.env.MIX_RELATION_ID, text: 'Relation'},
                ],
            }
        }
    }
</script>

<style scoped>
</style>

<template>
    <div class="container">
        <div class="row">
          <!-- TODO: Set base url? -->
          <a :href="term.concept_id">{{term.text}}</a>
        </div>
    </div>
</template>

<script>
    export default {
        props: ["term"],
        data() {
            return {}

        },
        mounted() {
            console.log("Component mounted.")
        }
    }
</script>

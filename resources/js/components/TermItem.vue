<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
            <p>{{term.text}}</p>
            </div>
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

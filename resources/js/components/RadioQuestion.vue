<template>
    <div>
        <div class="form-group" id="address-question">
            <label>Is your Access Policy Online?</label><br/>
            <label class="radio-inline">
                <input type='radio'
                    name='access-policy'
                    value=true
                    v-model="accessPolicy">
                Yes
            </label>
            <label class="radio-inline">
                <input type='radio'
                    name='access-policy'
                    value=false
                    v-model="accessPolicy">
                No
            </label>
        </div>
        <h1>here: {{ accessPolicy }}</h1>
        <div class="form-group" v-show="accessPolicy">
            <label for="description">Access Policy URL</label>
            <input type="text" value="" class="form-control"  name="">
        </div>


    </div>
</template>

<script>
export default {
  data() { return {
      'accessPolicy' : null
      }
  },
  methods: {
    mounted(){
      console.log('Component mounted!');
    }
  }
}
</script>



//config > cors.php

<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */

    'paths' => ['api/*', '*'],

    'allowed_methods' => ['*'],

    'allowed_origins' => ['*'],

    'allowed_origins_patterns' => ['*'],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => false,

];

<script>

import Layout from './Layout.vue';
import axios from 'axios';
import { getUrlList } from '../provider.js';

export default {
    name: "Category",
    components: {
        Layout,
    }
}

</script>

<template>
    <Layout>
        <template v-slot:content>
            <h1>This is category page</h1>
        </template>
    </Layout>
</template>

<template>
    <div>
        <index 
            v-if="method == 'index'"
            path="/protocols"
            singular="protocol"
            idfield="name"
            :fields="{ 
                'name' : 'Name', 
                'updated_at' : 'Updated At'
            }"
            :translate="{}"
            :filters="{
                'name' : 'Name',
            }"
        ></index>
        <create-edit 
            v-if="method == 'create' || method == 'edit'"
            path="/protocols"
            :method ="method"
            :fields="[
                {
                    label : 'Protocol Name',
                    placeholder : 'Protocol Name',
                    type : 'inputtext',
                    name : 'name'
                },
                {
                    label : 'Description',
                    placeholder : 'Description',
                    type : 'textarea',
                    name : 'description'
                },
                {
                    label : 'JSON',
                    placeholder : 'JSON',
                    type : 'textarea',
                    name : 'json_data'
                },
            ]"
            :selectssettings="[]"
        ></create-edit>
        <show 
            v-if="method == 'show'"
            path="/protocols"
            :fields="[
                {
                    label : 'Protocol Name',
                    name : 'name'
                },
                {
                    label : 'Description',
                    name : 'description'
                },
                {
                    label : 'JSON',
                    name : 'json_data'
                },
            ]"
            :translate="{}"
        ></show>
    </div>
</template>

<script>
    import Index from '../crud/Index.vue';
    import CreateEdit from '../crud/CreateEdit.vue';
    import Show from '../crud/Show.vue';
    export default {
        props : {
            method : String
        },
        components : { Index, CreateEdit, Show }
    }
</script>

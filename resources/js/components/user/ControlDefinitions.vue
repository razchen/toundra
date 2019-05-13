<template>
    <div>
        <index 
            v-if="method == 'index'"
            path="/control-definitions"
            singular="control definition"
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
            path="/control-definitions"
            routename="control_definitions"
            :method ="method"
            :fields="[
                {
                    label : 'Choose a User',
                    placeholder : 'Users',
                    type : 'select',
                    name : 'user_id',
                    settingname : 'users',
                    admin : true
                },
                {
                    label : 'Control Definition Name',
                    placeholder : 'Control Definition Name',
                    type : 'inputtext',
                    name : 'name'
                },
                {
                    label : 'Choose a Model',
                    placeholder : 'Model',
                    type : 'select',
                    name : 'three_d_id',
                    settingname : 'three_d'
                },
                {
                    label : 'Choose a Protocol',
                    placeholder : 'Protocol',
                    type : 'select',
                    name : 'protocol_id',
                    settingname : 'protocols'
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
            :selectssettings="[
                {
                    route : '/models',
                    name : 'three_d'
                },
                {
                    route : '/protocols',
                    name : 'protocols'
                },
                {
                    route : '/users',
                    name : 'users',
                    admin : true
                }
            ]"
        ></create-edit>
        <show 
            v-if="method == 'show'"
            path="/control-definitions"
            routename="control_definitions"
            :fields="[
                {
                    label : 'User',
                    name : 'user',
                    sub : 'name',
                    admin : true
                },
                {
                    label : 'Control Definition Name',
                    name : 'name'
                },
                {
                    label : 'Model', 
                    name : 'three_d',
                    sub : 'name'
                },
                {
                    label : 'Protocol', 
                    name : 'protocol',
                    sub : 'name'
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

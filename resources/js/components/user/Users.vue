<template>
    <div>
        <index 
            v-if="method == 'index'"
            path="/users"
            singular="user"
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
            path="/users"
            :method ="method"
            :fields="[
                {
                    label : 'Type',
                    placeholder : 'Type',
                    type : 'select',
                    name : 'type',
                    settingname : 'type'
                },
                {
                    label : 'Name',
                    placeholder : 'Name',
                    type : 'inputtext',
                    name : 'name'
                },
                {
                    label : 'Email',
                    placeholder : 'Email',
                    type : 'inputtext',
                    name : 'email'
                },
                {
                    label : 'API Key',
                    placeholder : 'API Key',
                    type : 'inputtext',
                    name : 'api_key'
                },
                {
                    label : 'Password',
                    placeholder : 'Password',
                    type : 'inputtext',
                    name : 'password'
                }
            ]"
            :selectssettings="[
                {
                    route : '',
                    name : 'type',
                    predefined : [
                        {
                            value : '',
                            label : 'User'
                        },
                        {
                            value : 'admin',
                            label : 'Admin'
                        }
                    ]
                },
            ]"
        ></create-edit>
        <show 
            v-if="method == 'show'"
            path="/users"
            :fields="[
                {
                    label : 'Type',
                    name : 'type',
                },
                {
                    label : 'Name',
                    name : 'name'
                },
                {
                    label : 'Email',
                    name : 'email'
                },
                {
                    label : 'API Key',
                    name : 'api_key'
                }
            ]"
            :translate="{
                type : {
                    'admin' : 'Admin',
                    '' : 'User'
                }
            }"
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

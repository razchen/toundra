<template>
    <div>
        <index 
            v-if="method == 'index'"
            path="/scenes"
            singular="scene"
            idfield="name"
            :fields="{ 
                'name' : 'Name', 
                'active' : 'Status', 
                'updated_at' : 'Updated At'
            }"
            :translate="{
                active : {
                    0 : 'Inactive',
                    1 : 'Active'
                }
            }"
            :filters="{
                'name' : 'Name',
            }"
        ></index>
        <create-edit 
            v-if="method == 'create' || method == 'edit'"
            path="/scenes"
            routename="scenes"
            :method="method"
            :selectssettings="[
                {
                    route : '/cameras',
                    name : 'cameras'
                },
                {
                    route : '',
                    name : 'active',
                    predefined : [
                        {
                            value : '1',
                            label : 'Active'
                        },
                        {
                            value : '0',
                            label : 'Inactive'
                        }
                    ]
                },
                {
                    route : '/users',
                    name : 'users',
                    admin : true
                }
            ]"
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
                    label : 'Scene Name',
                    placeholder : 'Scene Name',
                    type : 'inputtext',
                    name : 'name'
                },
                {
                    label : 'Choose a Camera',
                    placeholder : 'Camera',
                    type : 'select',
                    name : 'camera_id',
                    settingname : 'cameras'
                },
                {
                    label : 'Range of likely transforms',
                    placeholder : 'Range of likely transforms',
                    type : 'textarea',
                    name : 'transforms'
                },
                {
                    label : 'Status',
                    placeholder : 'Status',
                    type : 'select',
                    name : 'active',
                    settingname : 'active'
                },
            ]"
        ></create-edit>
        <show 
            v-if="method == 'show'"
            path="/scenes"
            routename="scenes"
            :fields="[
                {
                    label : 'User',
                    name : 'user',
                    sub : 'name',
                    admin : true
                },
                {
                    label : 'Scene Name',
                    name : 'name'
                },
                {
                    label : 'Camera', 
                    name : 'camera',
                    sub : 'name'
                },
                {
                    label : 'Range of likely transforms', 
                    name : 'transforms'
                },
                {
                    label : 'Status', 
                    name : 'active'
                },
            ]"
            :translate="{
                active : {
                    0 : 'Inactive',
                    1 : 'Active'
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

<template>
    <div>
        <index 
            v-if="method == 'index'"
            path="/reports"
            singular="report"
            idfield="instance_id"
            :fields="{ 
                'instance_id' : 'Instance ID', 
                'updated_at' : 'Updated At'
            }"
            :translate="{}"
            :filters="{
                'instance_id' : 'Instance ID',
            }"
        ></index>
        <create-edit 
            v-if="method == 'create' || method == 'edit'"
            path="/reports"
            routename="reports"
            :method ="method"
            :fields="[
                {
                    label : 'Instance ID',
                    placeholder : 'Instance ID',
                    type : 'inputtext',
                    name : 'instance_id'
                },
                {
                    label : 'Choose a Control Definition',
                    placeholder : 'Control Definition',
                    type : 'select',
                    name : 'control_definition_id',
                    settingname : 'control_definition'
                },
                {
                    label : 'JSON',
                    placeholder : 'JSON',
                    type : 'textarea',
                    name : 'json_data'
                },
                {
                    label : 'Status',
                    placeholder : 'Status',
                    type : 'select',
                    name : 'active',
                    settingname : 'active'
                },
            ]"
            :selectssettings="[
                {
                    route : '/control-definitions',
                    name : 'control_definition'
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
                }
            ]"
        ></create-edit>
        <show 
            v-if="method == 'show'"
            path="/reports"
            routename="reports"
            :fields="[
                {
                    label : 'Instance ID',
                    name : 'instance_id'
                },
                {
                    label : 'Control Definition', 
                    name : 'control_definition',
                    sub : 'name'
                },
                {
                    label : 'JSON',
                    name : 'json_data'
                },
                {
                    label : 'Status',
                    name : 'active'
                }
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

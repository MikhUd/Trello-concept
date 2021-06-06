<template>
    <div @drop="onDrop($event, deskData.id)" class="col-lg-4 droppable" @dragover.prevent @dragenter.prevent>
        <div class="card mt-3 mb-3 text-dark" style="max-width: 18rem;">
            <div class="card-body">
                <router-link :to="{name: 'showDesk', params:{desk: deskData, tasks: tasks}}" class="card-header text-center header hover-shadow">{{deskData.desk_name}}</router-link>
                <div class="card-body">
                    <div class="d-flex justify-content-center">
                        <div class="spinner-border text-secondary" style="width: 5rem; height: 5rem;" role="status" v-if="loading">
                        </div>
                    </div>
                    <div
                        v-for="task in tasks"
                        :key="task.id"
                        class="mt-2 card-header"
                        id="element"
                        draggable="true"
                        v-on:dragstart="startDrag($event, task, tasks)"
                        v-on:dragend="dragging(task, tasks)"
                        @dblclick="done(task, tasks)"
                        v-bind:class="{done: task.is_done}"
                    >
                    {{task.title}}
                        <div v-if="task.is_done" class="d-flex justify-content-end" style="margin-top:-20px;">
                            <img class="text-right" src="https://logodix.com/logo/470775.png" style="width:25px; height:20px;"/>
                        </div>    
                    </div>

                    <p class="alert alert-danger" role="alert" v-if="validateErrors.length">
                        {{validateErrors[0]}}
                    </p>
                    <input type="text" v-model="title" name="desk_name" placeholder="Заголовок задания" v-on:input="isEmpty" class="form-control mt-3">
                    <button class="btn bg-dark text-white mt-3" v-if="fillable" v-on:click="checkForm" @click="reload(deskData.id)">Добавить</button>
                    <button class="btn bg-dark text-white mt-3" v-on:click="deleteDesk(deskData.id)" @click="$emit('reload-desks')">Удалить доску</button>
                </div>
            </div>
        </div>
    </div>     
</template>

<script>
import Vue from 'vue'
import taskItem from "./Task"
export default {
    components:{
        taskItem
},

    data(){
        return{
        tasks:[],    
        title:null,
        fillable: false,
        validateErrors:[],
        loading:true,
        items:[],
        isDone: false,
        }
},    
    props:{
        deskData:{
                type:Object,
                default(){
                    return{}
                }
            },
         
    },
    methods:{
        startDrag(event, item, items){
            var currentItem = JSON.stringify(item);
            var currentArrayItems = JSON.stringify(items);
            event.dataTransfer.setData('item', currentItem)
            event.dataTransfer.setData('items', currentArrayItems)
            event.dataTransfer.setData('itemId', item.id.toString())
            
            event.dataTransfer.effectAllowed = 'move'
            
        },
        dragging(task, items){
            const index = items.indexOf(task)
            
            items.splice(index,1)
        },
        
        onDrop(event, deskId){
            console.log('dropped')

            const task = JSON.parse(event.dataTransfer.getData('item'))
            //const currentArrayItems = JSON.parse(event.dataTransfer.getData('items'))

            //console.log(currentArrayItems.indexOf(task))
            
            this.$set(this.tasks,this.tasks.length,task)

            const itemId = event.dataTransfer.getData('itemId')
            

            axios.post('/api/tasks/'+deskId,{
                _method: 'PUT',
                id: itemId,
                desk_id: deskId
            })
            .then(response=>{
                
            })
            .catch(error=>{
                console.log(error)
                this.errored = true
            })
        },
        reload(id){
            console.log('Обновляем доску с id '+ id)
            axios.get('/api/tasks/'+id)
            .then(response=>{
                this.tasks = response.data

                //console.log(this.tasks)
                
            })
            .catch(error=>{
                console.log(error)
                this.errored = true
            })
            .finally(() => {
                this.loading = false
            })
        },
        checkForm: function (e) {
            if (this.title) {
                this.saveTask();
                this.validateErrors = [];
                this.title=null;
                this.fillable=false;
                return true;
            } 
            if (!this.title) {
                this.validateErrors.push('Пустой заголовок!');
            }

            e.preventDefault();
    },
        isEmpty(){
            if(this.title){
                this.fillable = true
            }else{
                this.fillable = false    
            }
      },
        deleteDesk(id){
            axios.post('/api/desks/'+id)
            .then(response=>{
                //this.$router.push({name:'home'}); 
            })
            .catch(error=>{
                console.log(error)
                this.errored = true
            }) 
        },
        saveTask(){
            axios.post('/api/tasks/'+this.deskData.id,{
                title: this.title,
                desk_id: this.deskData.id
            })
            .then(response=>{
                //$this.$emit('reload-desks')
            })
            .catch(error=>{
                console.log(error)
                this.errored = true
            })
            .finally(() => {
                this.loading = false
            })
        },
        done(task, tasks){
            const index = tasks.indexOf(task)
            if(!task.is_done){
                task.is_done=true
                tasks.splice(index, 1, task)
            }else{
                task.is_done=false
                tasks.splice(index, 1, task)
            }

            axios.post('/api/task/done/'+task.id,{
                id: task.id
            })
            .then(response=>{

            })
            .catch(error=>{
                console.log(error)
                this.errored = true
            })
        }
    },
    mounted(){
        axios.get('/api/tasks/'+this.deskData.id)
        .then(response=>{
            this.tasks = response.data
        })
        .catch(error=>{
            console.log(error)
            this.errored = true
        })
        .finally(() => {
            this.loading = false
        })
  
    }
    
}
</script>
<style scoped>

.card-header{
    background: bisque;
}

.card{
    background: linear-gradient(130deg,#75bda1,#75bda1 50%,
    #b9a66d 50%, #b9a66d);
    backdrop-filter: blur(25px);
}
.card-body{
    text-decoration: none;
    color:black;
       
}
.hidden{
    display: none;
}
.header{
    text-decoration:none;
    color:black;
    width: 200px;
    margin: 0 auto;
    position: relative;
    display: block;
}
.header:hover{

   background-color: blanchedalmond;
}
.done{
    background: rgb(124, 216, 181);
}

</style>
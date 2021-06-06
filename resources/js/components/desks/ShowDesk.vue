<template>
    <div class="container">
        
        <h2 class="text-center text-white">Доска № {{desk.id}}</h2>
        <h3 class="text-center text-white" v-if="desk">{{desk.updated_at|subStr}}</h3>
        <div class="form-group mt-5">
            <input type="text" @blur="saveTitle" class="form-control" v-if="desk" v-model="desk.desk_name">
        </div>
        <hr class="border-white">
        <h3 class="text-center text-white">Список заданий</h3>
                    <div
                    v-for="task in tasks"
                    :key="task.id"
                    class="mt-2 card-header"
                    :class="{ done: task.is_done }"
                    @dblclick="deleteTask(task, tasks)"
                    >
                    {{task.title}}
                    </div>
        <div class="alert alert-danger" role="alert" v-if="errored">
            Ошибка загрузки данных!
        </div>
        
    </div>
    
</template>

<script>
export default {
    props: {
        desk:{
            type: Object
        },
        tasks: {
            type: Array,
            default: () => [],
        },
            
    },
    data(){
        return{
            //desk:null,
            //tasks:[],
            errored: false,
            //loading: true,
            desk_name: null,

        }
    },
     filters: {
  
  	subStr: function(string) {
    	return string.substring(0,10);
        }
  
  },
    methods:{
        saveTitle(){
            axios.post('/api/desks/'+this.desk.id, {
                _method: 'PUT',
                desk_name: this.desk.desk_name,
            })
            .then(response=>{

            })
            .catch(error=>{
                console.log(error)
                this.errored = true
            })
            .finally(() => {
                this.loading = false
            })
        },
        deleteTask(task, tasks){
            const index = tasks.indexOf(task)
            tasks.splice(index,1)
            axios.post('/api/task/'+task.id, {
                id: task.id,
            })
            .then(response=>{
                console.log(response)
            })
            .catch(error=>{
                console.log(error)
                this.errored = true
            })
            .finally(() => {
                this.loading = false
            })
        }
    },
    mounted(){
    //    axios.get('/api/desks/'+this.deskId)
    //    .then(response=>{
    //        this.desk = response.data
    //    })
    //    .catch(error=>{
    //        console.log(error)
    //        this.errored = true
     //   })
    //    .finally(() => {
     //       this.loading = false
    //    })
    //    axios.get('/api/tasks/'+this.desk.id)
     //   .then(response=>{
     //      this.tasks = response.data
     //       console.log(this.tasks)
    //    })
   //     .catch(error=>{
      //      console.log(error)
     //       this.errored = true
    //    })
    //    .finally(() => {
    //        this.loading = false
    //    })
    }
    }
</script>

<style scoped>
.container{
   margin-top: 30px;
   padding: 15px;
   padding-bottom: 25px; 
   width: 800px;
   max-width: 90%;
   background-color:rgba(84, 180, 172, 0.5);
   border-radius: 1%; 
}
.card-header{
    background: bisque;
}
.done{
    background: rgb(124, 216, 181);
}
</style>
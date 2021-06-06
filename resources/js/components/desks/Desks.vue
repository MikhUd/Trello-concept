<template>
    <div class="container">
       <h1 class="text-center text-white">Доски</h1>
       <hr class="border-white">
        <div class="row" style="margin-left:2rem;">
            <desk-item
            @reload-desks="reload"
            v-for="desk in desks"
            :key="desk.id"
            :deskData="desk"
            />
            <div class="card mt-3 text-dark bg-light mb-3" id="desk">
                <div class="card-header">Добавить доску</div>
                    <p class="alert alert-danger" role="alert" v-if="validateErrors.length">
                        {{validateErrors[0]}}
                    </p>
                    <div class="card-body">
                        <input type="text" id="desk_name" v-model="desk_name" name="desk_name" placeholder="Заголовок доски" v-on:input="isEmpty" class="form-control">
                        <label for="period" class="text-uppercase font-weight-bold mt-3">Время на исполнение(ч.)</label>
                        <input type="text" id="period" v-model="period" name="period" v-on:input="isEmpty" class="form-control"> <div id="hours">часов.</div>
                        <button class="btn bg-dark text-white mt-3" v-if="fillable" v-on:click="checkForm">Добавить</button>
                    </div>
            </div>
        </div>
        <div>
            
        </div>
        <div class="alert alert-danger" role="alert" v-if="errored">
            Ошибка загрузки данных!
        </div> 
        <div class="d-flex justify-content-center">
            <div class="spinner-border text-secondary" style="width: 10rem; height: 10rem;" role="status" v-if="loading">
                
            </div>
        </div>
    </div>
</template>

<script>
import deskItem from "./Desk"
export default {
  components:{
        deskItem
  },
  data(){
      return{
          desks: [],
          errored: false,
          loading: true,
          fillable: false,
          desk_name: null,
          period: null,
          validateErrors:[],
      }
  },
  methods:{
      reload(){
          axios.get('/api/desks')
          .then(response=>{
             this.desks = response.data
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
      if (this.desk_name) { 
        this.saveDesk()
        this.validateErrors = [];
        this.desk_name = null 
        return true;
      } 
      if (!this.desk_name) {
        this.validateErrors.push('Пустой заголовок!');
      }

      e.preventDefault();
    },
      isEmpty(){
          if(this.desk_name && this.period && !isNaN(this.period)){
          this.fillable = true
          }else{
          this.fillable = false    
          }
      },
      saveDesk(){
            axios.post('/api/desks', {
                desk_name: this.desk_name,
            })
            .then(response=>{
                this.desks = response.data
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
      axios.get('/api/desks')
      .then(response=>{
          this.desks = response.data
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
#period{
    width: 60px;
}
#hours{
    margin-top:-33px; 
    margin-left: 70px;
}
#desk{
    width: 18rem; 
    margin-left:0.9rem; 
    height:250px;
    max-height: 70%;
}
</style>
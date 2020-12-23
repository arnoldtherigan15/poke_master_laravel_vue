<template>
  <div class="container">
    <h1 style="text-align:center; margin-top:10px; margin-bottom:10px">Welcome to pokemon world</h1>
    <button @click="logout" class="nes-btn is-error" style="position:absolute;top:20px;right:20px">Logout</button>
    <div class="container-small">
      <Card v-for="pokemon in pokemons" :key="pokemon.id" :pokemon="pokemon"/>
    </div>
    <div>
      <img @click="addPokemon" class="add-btn" src="../assets/ball.gif" alt="">
    </div>
  </div>
</template>

<script>
// @ is an alias to /src
// import HelloWorld from '@/components/HelloWorld.vue'
import Card from '../components/Card'
import { mapActions, mapState } from 'vuex'
export default {
  name: 'Home',
  components: {
    Card
  },
  computed: {
    ...mapState(['pokemons'])
  },
  methods: {
    ...mapActions(['fetchPokemons']),
    addPokemon() {
      this.$router.push({name:'AddPokemon'})
    },
    logout() {
      this.$store.dispatch('logout')
        .then(()=> {
          this.$router.push({name:'Login'})
        })
    }
  },
  created() {
    this.fetchPokemons()
  }
}
</script>

<style scoped>
.container {
  padding: 2em;
  height: 100vh;  
  background-image: url(../assets/bg.gif);
  background-position: center;
  overflow-y: auto;
  background-size: cover;
  background-repeat: no-repeat;
  /* height: 100vh; */
}
.container-small {
  justify-content: center;
  display: flex;
  flex-wrap: wrap;

}
.add-btn {
  width: 150px;
  position: absolute;
  bottom: 20px;
  left: 20px;
  cursor: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAAzElEQVRYR+2X0Q6AIAhF5f8/2jYXZkwEjNSVvVUjDpcrGgT7FUkI2D9xRfQETwNIiWO85wfINfQUEyxBG2ArsLwC0jioGt5zFcwF4OYDPi/mBYKm4t0U8ATgRm3ThFoAqkhNgWkA0jJLvaOVSs7j3qMnSgXWBMiWPXe94QqMBMBc1VZIvaTu5u5pQewq0EqNZvIEMCmxAawK0DNkay9QmfFNAJUXfgGgUkLaE7j/h8fnASkxHTz0DGIBMCnBeeM7AArpUd3mz2x3C7wADglA8BcWMZhZAAAAAElFTkSuQmCC) 14 0, pointer;
}

@media only screen and (max-width: 600px) {
    .add-btn {
        width: 90px;
    }
}
</style>

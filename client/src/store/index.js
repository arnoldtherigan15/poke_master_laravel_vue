import Vue from 'vue'
import Vuex from 'vuex'
import axios from '../config/axios'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    pokemons: []
  },
  mutations: {
    SET_POKEMONS(state,payload) {
      state.pokemons = payload
    },
    ADD_POKEMON(state,payload) {
      state.pokemons.push(payload)
    }
  },
  actions: {
    login(ctx, paylaod) {
      const { email, password } = paylaod
      return axios({
        method: 'post',
        url: '/login',
        data: {
          email,
          password
        }
      })
    },
    register(ctx, paylaod) {
      const { name, email, password, password_confirmation } = paylaod
      return axios({
        method: 'post',
        url: '/register',
        data: {
          name,
          email,
          password,
          password_confirmation
        }
      })
    },
    fetchPokemons({ commit }) {
      axios({
        method: 'get',
        url: '/pokemons',
        headers: {
          'Authorization': `Bearer ${localStorage.token}`
        }
      })
        .then(({data}) => {
          // let pokemons = data.data
          // console.log(data.data, '>>>Fetch');
          commit('SET_POKEMONS', data.data)
        })
        .catch(err => {
          console.log(err.response ,'>>>Errror fetch');
        })
    },
    addPokemon({ commit }, payload) {
      return new Promise((resolve,reject) => {
        axios({
          method: 'post',
          url: '/pokemons',
          headers: {
            'Authorization': `Bearer ${localStorage.token}`
          },
          data: {
            name: payload.name,
            img_url: payload.img_url
          }
        })
          .then(({data}) => {
            commit('ADD_POKEMON', data.data)
            resolve(data)
          })
          .catch(err => {
            reject(err)
            console.log(err.response ,'>>>Errror add');
          })
      })
    },
    deletePokemon({dispatch}, id) {
      axios({
        method: 'delete',
        url: '/pokemons/' + id,
        headers: {
          'Authorization': `Bearer ${localStorage.token}`
        }
      })
        .then(({data}) => {
          dispatch('fetchPokemons')
        })
        .catch(err => {
          console.log(err.response ,'>>>Errror delete');
        })
    },
    fetchDetail(ctx, id) {
      return new Promise((resolve,reject) => {
        axios({
          method: 'get',
          url: '/pokemons/' + id,
          headers: {
            'Authorization': `Bearer ${localStorage.token}`
          }
        })
          .then(({data}) => {
            resolve(data.data)
          })
          .catch(err => {
            reject(err)
            console.log(err.response ,'>>>Errror fetch detail');
          })

      })
    },
    editPokemon({dispatch}, payload) {
      return new Promise((resolve,reject) => {
        axios({
          method: 'put',
          url: '/pokemons/' + payload.id,
          headers: {
            'Authorization': `Bearer ${localStorage.token}`
          },
          data: {
            name: payload.name,
            img_url: payload.img_url
          }
        })
          .then(({data}) => {
            dispatch('fetchPokemons')
            resolve(data)
          })
          .catch(err => {
            reject(err)
            console.log(err.response ,'>>>Errror add');
          })
      })
    },
    logout() {
      return new Promise((resolve,reject) => {
        axios({
          method: 'post',
          url: '/logout',
          headers: {
            'Authorization': `Bearer ${localStorage.token}`
          }
        })
          .then(({data}) => {
            localStorage.clear()
            resolve(data)
          })
          .catch(err => {
            reject(err)
            console.log(err.response ,'>>>Errror logout');
          })

      })
    }
  },
  modules: {
  }
})

<template>
    <div class="container">
        <form @submit.prevent="addPokemon" class="form-center text">
            <h1>Catch New Pokemon</h1>
            <div class="nes-field">
                <label for="name" class="text">Pokemon name</label>
                <input v-model="name" type="text" id="name" class="nes-input">
                <div v-if="errors.name">
                    <p class="text-red">{{ errors.name[0] }}</p>
                </div>
            </div>
            <div class="nes-field">
                <label for="img_url" class="text">Pokemon photo</label>
                <input v-model="img_url" type="text" id="img_url" class="nes-input">
                <div v-if="errors.img_url">
                    <p class="text-red">{{ errors.img_url[0] }}</p>
                </div>
            </div>
            <button type="submit" class="nes-btn is-success btn-full">Catch</button>
        </form>
    </div>
</template>

<script>
import Swal from 'sweetalert2';
export default {
    name: 'AddPokemon',
    data() {
        return {
            name: '',
            img_url: '',
            errors: {}
        }
    },
    methods: {
        addPokemon() {
            let payload = {
                name: this.name,
                img_url: this.img_url
            }
            this.$store.dispatch('addPokemon', payload)
                .then(({data}) => {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    })

                    Toast.fire({
                        icon: 'success',
                        title: 'Catch New Pokemon'
                    })
                    this.$router.push({ name: 'Home' });
                })
                .catch(err => {
                    console.log(err.response,'error');
                    this.errors = err.response.data
                })
        }   
    }
}
</script>

<style scoped>
.text-red {
    color: red;
}
.text {
    font-size: 1rem !important;
}
.text-small {
    font-size: .8rem;
}
.text-anchor {
    text-decoration: underline;
    cursor: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAAzElEQVRYR+2X0Q6AIAhF5f8/2jYXZkwEjNSVvVUjDpcrGgT7FUkI2D9xRfQETwNIiWO85wfINfQUEyxBG2ArsLwC0jioGt5zFcwF4OYDPi/mBYKm4t0U8ATgRm3ThFoAqkhNgWkA0jJLvaOVSs7j3qMnSgXWBMiWPXe94QqMBMBc1VZIvaTu5u5pQewq0EqNZvIEMCmxAawK0DNkay9QmfFNAJUXfgGgUkLaE7j/h8fnASkxHTz0DGIBMCnBeeM7AArpUd3mz2x3C7wADglA8BcWMZhZAAAAAElFTkSuQmCC) 14 0, pointer;
}
.container {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100vw;
    height: 100vh;
    background-image: url(../assets/bg.gif);
    background-position: center;
    overflow-y: auto;
    background-size: cover;
    background-repeat: no-repeat;
}
.form-center {
    width: 50%;
    overflow-x: auto;
    background-color: rgba(245, 246, 250,.8);
    box-shadow: 0px 0px 10px 5px white;
    padding: 30px;
    border-radius: 20px;
}
.nes-field {
    margin-bottom: 2em;
}
.btn-full {
    width: 100%;
}

@media only screen and (max-width: 600px) {
    .form-center {
        width: 90%;
    }
}
</style>
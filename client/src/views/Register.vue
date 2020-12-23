<template>
    <div class="container">
        <form @submit.prevent="register" class="form-center text">
            <div class="nes-field">
                <label for="name">Your name</label>
                <input v-model="name" type="text" id="name" class="nes-input">
                <div v-if="errors.name">
                    <p class="text-red">{{ errors.name[0] }}</p>
                </div>
            </div>
            <div class="nes-field">
                <label for="email">Your email</label>
                <input v-model="email" type="email" id="email" class="nes-input">
                <div v-if="errors.email">
                    <p class="text-red">{{ errors.email[0] }}</p>
                </div>
            </div>
            <div class="nes-field">
                <label for="password">Your password</label>
                <input v-model="password" type="password" id="password" class="nes-input">
                <div v-if="errors.password">
                    <p class="text-red">{{ errors.password[0] }}</p>
                </div>
            </div>
            <div class="nes-field">
                <label for="confirm_password" class="text">Confirm password</label>
                <input v-model="password_confirmation" type="password" id="confirm_password" class="nes-input">
            </div>
            <p class="text-small">already have an account ? Login <span class="text-anchor" @click="toLogin">here</span></p>
            <button type="submit" class="nes-btn is-success btn-full">Register</button>
        </form>
    </div>
</template>

<script>
import Swal from 'sweetalert2';
export default {
    name: 'Register',
    data() {
        return {
            name: '',
            email: '',
            password: '',
            password_confirmation: '',
            errors: {}
        }
    },
    methods: {
        toLogin() {
            this.$router.push({name: 'Login'});
        },
        register() {
            let payload = {
                name: this.name,
                email: this.email,
                password: this.password,
                password_confirmation: this.password_confirmation
            }
            this.$store.dispatch('register', payload)
                .then(()=> {
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
                        title: 'Register success'
                    })
                    this.$router.push({name:'Login'})
                })
                .catch(err => {
                    this.errors = err.response.data
                    console.log(err.response, '>>>>> regiserete error');
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
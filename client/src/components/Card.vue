<template>
    <div class="card">
        <div class="caption">
            <h1 style="text-align:center">{{ pokemon.name }}</h1>
        </div>
        <img class="thumbnail" :src="pokemon.img_url" alt="">
        <div class="button-container">
            <button @click="edit(pokemon.id)" class="nes-btn is-warning">Edit</button>   
            <button @click="deletePokemon(pokemon.id)" class="nes-btn is-error">Delete</button>
        </div>
    </div>
</template>

<script>
export default {
    name: 'Card',
    props: ['pokemon'],
    methods: {
        deletePokemon(id) {
            this.$store.dispatch('deletePokemon',id);
        },
        edit(id) {
            this.$router.push(`/edit/${id}`);
        }
    }
}
</script>

<style scoped>
.caption {
    height: 30%;
}
.card {
    width: 25%;
    height: 50vh;
    background-color: rgba(245, 246, 250,.8);
    box-shadow: 0px 0px 10px 5px white;
    padding: 30px;
    border-radius: 20px;
    margin: 1rem;
    overflow-y: auto;
}
.thumbnail {
    width: 100%;
    object-fit: contain;
    height: 50%;
}
.button-container {
    display: flex;
    justify-content: space-between;
    margin-top: 10px;
}

@media only screen and (max-width: 600px) {
    .card {
        width: 90%;
    }
}
</style>
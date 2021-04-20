<template>
    <div>
        <nav class="navbar navbar-expand-lg navbar-light bg-success">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">My Church</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <span class="nav-link"><router-link to="/lider" aria-current="page">Home</router-link></span>
                        </li>
                        <li class="nav-item">
                            <span class="nav-link"><router-link to="/home">Teste</router-link></span>
                        </li>
                        <li class="nav-item">
                            <a href="/porteiro" class="nav-link">Porteiro</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</template>

<script>
    export default {
        name: 'Header',
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
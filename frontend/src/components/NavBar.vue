<template>
  <div>
    <b-navbar toggleable="lg" type="dark" variant="black">
      <div class="container-fluid">
        <b-navbar-brand href="#">
          MR Linter
        </b-navbar-brand>

        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
          <div class="navbar-nav">
            <a class="nav-link active" aria-current="page" href="#">Home</a>
            <a class="nav-link" href="#">Config Builder</a>
            <a class="nav-link" href="https://github.com/ArtARTs36/php-merge-request-linter">Github</a>
          </div>
        </div>

        <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>
      </div>
    </b-navbar>
  </div>
</template>

<script>
export default {
  name: 'NavBar'
}
</script>

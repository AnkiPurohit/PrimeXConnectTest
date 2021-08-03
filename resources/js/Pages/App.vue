<template>
  <div class="container">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark" id="navbar">
      <a class="navbar-brand" href="/products"
        >Primex -Test</a
      >
      <button
        class="navbar-toggler"
        type="button"
        data-toggle="collapse"
        data-target="#navbarText"
        aria-controls="navbarText"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end">
        <!-- for logged-in user-->
        <div class="navbar-nav" v-if="isLoggedIn">
          
          <router-link
            to="/products"
            class="nav-item nav-link"
            >Products
          </router-link>
          <router-link
            to="/import_product"
            class="nav-item nav-link"
            >Import Product
          </router-link>
          <router-link
            to="/import_stock"
            class="nav-item nav-link"
            >Import Stock
          </router-link>
          <a class="nav-item nav-link logout" style="cursor: pointer" @click="logout">
            Logout {{ name }}
          </a>
        </div>

        <div class="navbar-nav" v-else>
          <router-link to="/" class="nav-item nav-link"
            >login</router-link
          >
          <router-link
            to="/register"
            class="nav-item nav-link"
            >Register
          </router-link>
        </div>
      </div>
    </nav>

    <div class="container p-3 my-3 border">
      <router-view></router-view>
    </div>
  </div>
</template>

<script>
export default {
  name: "App",
  data() {
    return {
      isLoggedIn: false,
    };
  },
  created() {
    if (window.Laravel.user) {
      this.name = window.Laravel.user.name;
    }
    if (window.Laravel.isLoggedin) {
      this.isLoggedIn = true;
    }
  },
  methods: {
    logout(e) {
      console.log("ss");
      e.preventDefault();
      this.$axios.get("/sanctum/csrf-cookie").then((response) => {
        this.$axios
          .post("/api/logout")
          .then((response) => {
            if (response.data.success) {
              window.location.href = "/";
            } else {
              console.log(response);
            }
          })
          .catch(function (error) {
            console.error(error);
          });
      });
    },
  },
};
</script>
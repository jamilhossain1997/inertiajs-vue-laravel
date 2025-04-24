<template>
    <div>
      <h2>Login</h2>
      <form @submit.prevent="login">
        <input type="email" v-model="email" placeholder="Email" /><br/><br/>
        <input type="password" v-model="password" placeholder="Password" /> <br/><br/>
        <button type="submit">Login</button>
      </form>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        email: '',
        password: ''
      };
    },
    methods: {
      async login() {
        try {
          const response = await axios.post('/api/login', {
            email: this.email,
            password: this.password
          });
          localStorage.setItem('token', response.data.token);
          this.$router.push('/dashboard');
        } catch (error) {
          console.error('Login failed', error);
        }
      }
    }
  };
  </script>
  